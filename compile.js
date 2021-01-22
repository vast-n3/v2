const sass = require('sass');
const fs = require('fs');
const rendered = sass.renderSync({
    file: __dirname + '/frame/VastN3/css/index.scss',
    outFile:  __dirname + '/frame/VastN3/css/index.css'
})

fs.writeFileSync(__dirname + '/frame/VastN3/css/index.css', rendered.css, 'utf-8');
console.log('done')