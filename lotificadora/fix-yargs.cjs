const fs = require('fs');
const path = require('path');
const pkgPath = path.join(__dirname, 'node_modules', 'yargs', 'package.json');
const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf-8'));
if (pkg.type === 'module') {
    delete pkg.type;
    fs.writeFileSync(pkgPath, JSON.stringify(pkg, null, 2) + '\n');
    console.log('Fixed yargs package.json: removed "type": "module"');
}
