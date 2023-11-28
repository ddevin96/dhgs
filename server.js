const express = require('express')
const path = require('path')
const app = express()
const port = 3000
const matter = require("gray-matter")

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
  const d = utils.getDatasets()

  res.render('list', {
    title: "DHGS",
    header: "Hypergraphs Dataset",
    datasetsList: d
  });
});

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

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})