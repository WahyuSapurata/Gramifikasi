const mix = require('laravel-mix');

mix.copy('node_modules/admin-lte/dist/css/adminlte.min.css', 'public/css')
    .copy('node_modules/admin-lte/dist/js/adminlte.min.js', 'public/js')
    .copyDirectory('node_modules/admin-lte/plugins', 'public/plugins');
