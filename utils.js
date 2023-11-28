module.exports = {
    getDatasets: function () {
      const fs = require('fs')
      const path = require('path')
      const dir = path.join(__dirname, 'datasets')
      const datasets = fs.readdirSync(dir)
      return datasets
    },
    bar: function () {
    }
  };
  
  var zemba = function () {
  }