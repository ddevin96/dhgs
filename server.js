const express = require('express')
const path = require('path')
const fs = require('fs')
const app = express()
const port = 3000
const matter = require("gray-matter")
const axios = require('axios');

require('dotenv').config()

app.engine('.html', require('ejs').__express);

// Optional since express defaults to CWD/views
app.set('views', path.join(__dirname, 'views'));

// Path to our public directory
app.use(express.static(path.join(__dirname, 'public')));
app.use(express.static(path.join(__dirname, 'datasets')));

// Without this you would need to
// supply the extension to res.render()
// ex: res.render('users.html').
app.set('view engine', 'html');

const utils = require('./utils');


app.get('/', function(req, res){
  res.render('index', {
    title: "DHGS",
    header: "Hypergraphs Dataset"
  });
});

app.get('/list', function(req, res){
  const infos = utils.getInfos()
  sources = []
  for (const info of infos) {
    apiCall = "https://api.github.com/repos/ddevin96/dhgs/commits?path=datasets/" + info.nameHG + "/info.md"
    sources.push(apiCall)
  }
  run(sources, infos, res)
});

async function run(sources, infos, res) {
  const axios = require('axios');
  const tasks = sources.map(source => axios.get(source, { withCredentials: true }));
  const results = await Promise.allSettled(tasks);
  const fulfilled = results.filter(result => result.status === 'fulfilled');

  for (const apiCall of fulfilled) {
    url = apiCall.value.config.url
    console.log(url)
    s = url.split("/")
    nameHG = s[s.length - 2]
    const result = infos.filter(info => info.nameHG == nameHG)
    // console.log(result)
    /*
    date = apiCall.value.data[apiCall.value.data.length - 1].commit.author.date
    date = date.split("T")
    date = date[0] + " " + date[1].split("Z")[0]
    */
    result[0].dateUpload = apiCall.value.data[apiCall.value.data.length - 1].commit.author.date
    result[0].uploader = apiCall.value.data[apiCall.value.data.length - 1].commit.author.name
    result[0].dateLastUpdate = apiCall.value.data[0].commit.author.date
  }

  res.render('infoDataset', {
    title: "DHGS",
    header: "Hypergraphs Dataset",
    infos: infos
  });
}


app.get('/dataset/:hg', function(req, res){
  // iterate through the datasets folder and get the list of datasets
  const d = utils.getDatasets()
  hgName = req.params.hg
  // Convert the Markdown file content to HTML with markdown-it
  const post = matter.read(__dirname + "/datasets/" + hgName + "/info.md")
  // const myPath = path.join(__dirname, '/datasets/')
  // const post = matter.read("./" + myPath + hgName + "/info.md")
  const md = require("markdown-it")({ html: true }) 
  const content = post.content 
  const mdRendered = md.render(content) // this is the HTML result

  res.render('datasets', {
    title: "DHGS",
    header: "Hypergraphs Dataset",
    myhtml: mdRendered,
    datasetsList: d
  });
});

// /files/* is accessed via req.params[0]
// but here we name it :file
app.get('/dataset/:hg/:file', function(req, res, next){
  hgName = req.params.hg
  fileName = req.params.file
  var mypath = path.join(__dirname, "/datasets/", hgName, fileName)
  res.download(mypath, function (err) {
    if (!err) return; // file sent
    if (err.status !== 404) return next(err); // non-404 error
    // file for download not found
    res.statusCode = 404;
    res.send('Cant find that file, sorry!');
  });
});


app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})