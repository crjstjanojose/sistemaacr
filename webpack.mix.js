const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .styles(['resources/vendor/fontawesome/css/all.min.css',
        'resources/vendor/css/custom.css',
        'resources/vendor/datatables/datatables/css/dataTables.bootstrap4.min.css',
        'resources/vendor/datatables/buttons/css/buttons.bootstrap4.css',
        'resources/vendor/duallistbox/bootstrap-duallistbox.min.css',
        'resources/vendor/datepicker/bootstrap-datepicker.css',
        'resources/vendor/select2/css/select2.css',
    ], 'public/css/custom.css')

    .js("resources/js/app.js", "public/js")

    .scripts([
        'resources/vendor/jquery/jquery34.js',
        'resources/vendor/jquery/popper.min.js',
        'resources/vendor/bootstrap/js/bootstrap.js',
        'resources/vendor/duallistbox/jquery.bootstrap-duallistbox.min.js',
        'resources/vendor/datepicker/bootstrap-datepicker.min.js',
        'resources/vendor/inputmask/jquery.mask.js',
        'resources/vendor/inputmask/custom.js',
        'resources/vendor/select2/js/select2.js',
    ], 'public/js/vendor.js')


    .scripts(['resources/vendor/datatables/jszip/jszip.js',
            'resources/vendor/datatables/pdfmake/pdfmake.js',
            'resources/vendor/datatables/pdfmake/vfs_fonts.js',
            'resources/vendor/datatables/datatables/js/jquery.dataTables.js',
            'resources/vendor/datatables/datatables/js/dataTables.bootstrap4.js',
            'resources/vendor/datatables/buttons/js/dataTables.buttons.min.js',
            'resources/vendor/datatables/buttons/js/buttons.bootstrap4.min.js',
            'resources/vendor/datatables/buttons/js/buttons.flash.min.js',
            'resources/vendor/datatables/buttons/js/buttons.html5.js',
            'resources/vendor/datatables/buttons/js/buttons.print.js',
        ],
        'public/js/datatable.js')

    .copy('resources/vendor/fontawesome/webfonts', 'public/webfonts')

    .sass(
        "resources/views/scss/style.scss",
        "public/css/app.css"
    );
