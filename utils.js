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
    }
  };
  
  var zemba = function () {
  }