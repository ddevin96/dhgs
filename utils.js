const { get } = require('http');

module.exports = {
    getDatasets: function () {
      const fs = require('fs')
      const path = require('path')
      const dir = path.join(__dirname, 'datasets')
      const datasets = fs.readdirSync(dir)
      return datasets
    },
    getSizeDatasets: function () {
      try {
        const fs = require('fs')
        const path = require('path')
        const dir = path.join(__dirname, 'datasets')
        const datasets = fs.readdirSync(dir)
        var sizes = []
        for (const dir1 of datasets) {
          const dir = path.join(__dirname, 'datasets', dir1)
          const files = fs.readdirSync(dir);
          for (const file of files) {
            if (file.endsWith(".hg")) {
              const stats = fs.statSync(dir + "/" + file);
              const fileSizeInBytes = stats.size;
              const fileSizeInMegaBytes = fileSizeInBytes / (1024 * 1024);
              sizes.push(fileSizeInMegaBytes.toFixed(5))
            }
          }
        }
        return sizes
      } catch (err) {
        console.log(err.message);
      }
    },
    getInfos: function () {
      const axios = require('axios');

      infosJSON = []
      // jsonSample = {
      //   "nameHG": ,
      //   "uploader": ,
      //   "dateUpload": ,
      //   "dateLastUpdate": ,
      //   "download": ,
      //   "size": ,
      // }
      try {
        const fs = require('fs')
        const path = require('path')
        const dir = path.join(__dirname, 'datasets')
        const datasets = fs.readdirSync(dir)
        for (const dir1 of datasets) {
          const dir = path.join(__dirname, 'datasets', dir1)
          const files = fs.readdirSync(dir);
          for (const file of files) {
            if (file.endsWith(".hg")) {
              tempJson = {
                "nameHG": file,
                "uploader": "placeholder",
                "dateUpload": "placeholder",
                "dateLastUpdate": "placeholder",
                "download": "placeholder",
                "size": "placeholder",
              }
              const stats = fs.statSync(dir + "/" + file);
              const fileSizeInBytes = stats.size;
              const fileSizeInMegaBytes = fileSizeInBytes / (1024 * 1024);
              tempJson.size = fileSizeInMegaBytes.toFixed(5)
              s = file.split(".")
              tempJson.nameHG = s[0]
              tempJson.download = "dataset/" + s[0] + "/" + file
              infosJSON.push(tempJson)

              
            }
          }
        }
        console.log(infosJSON);
        return infosJSON
      } catch (err) {
        console.log(err.message);
      }

      
    },

  };
  


async function run(sources) {
  const axios = require('axios');
  const tasks = sources.map(source => axios.get(source));
  const results = await Promise.allSettled(tasks);
  const fulfilled = results.filter(result => result.status === 'fulfilled');
  console.log(fulfilled)
}