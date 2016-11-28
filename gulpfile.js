var elixir = require('laravel-elixir');

elixir(function(mix) {
	/** Copy Fonts */
    mix.copy([
    	'public/vendor/bootstrap/fonts',
    	'public/vendor/font-awesome/fonts',
    ], 'public/fonts', 'public/vendor');

    /** Mix Stylesheets */
    mix.styles([
        'public/vendor/font-awesome/css/font-awesome.css',
        'public/vendor/ladda/dist/ladda.min.css',
        'public/vendor/bootstrap/dist/css/bootstrap.css',
        'public/vendor/iCheck/skins/square/blue.css',
        'public/vendor/datatables/media/css/dataTables.bootstrap.css',
        'public/vendor/datatables-plugins/datatables.button.css',
        'public/vendor/daterangepicker/daterangepicker.css',
        'public/vendor/datepicker/css/datepicker.css',
        'public/vendor/jt.timepicker/jquery.timepicker.css',
        'public/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'public/vendor/select2/dist/css/select2.css',
        'public/vendor/sweetalert/dist/sweetalert.css',
        'public/vendor/jquery-treegrid/css/jquery.treegrid.css'

    ], 'public/css/vendor.css', 'public/vendor');

    /** Mix Scripts */
    mix.scripts([
        'public/vendor/daterangepicker/moment.js',
        'public/vendor/jquery/dist/jquery.js',
        'public/vendor/bootstrap/dist/js/bootstrap.js',
        'public/vendor/datatables/media/js/jquery.dataTables.js',
        'public/vendor/datatables/media/js/dataTables.bootstrap.js',
        'public/vendor/datatables-plugins/datatables.button.js',
        'public/vendor/datatables-plugins/datatables.button.flash.js',
        'public/vendor/datatables-plugins/datatables.jszip.js',
        'public/vendor/datatables-plugins/datatables.pdfmake.js',
        'public/vendor/datatables-plugins/datatables.vfs_fonts.js',
        'public/vendor/datatables-plugins/datatables.html5.js',
        'public/vendor/datatables-plugins/datatables.print.js',
        'public/vendor/datatables-plugins/datatables.sum.js',
        'public/vendor/daterangepicker/daterangepicker.js',
        'public/vendor/datepicker/js/bootstrap-datepicker.js',
        'public/vendor/jt.timepicker/jquery.timepicker.js',
        'public/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'public/vendor/iCheck/icheck.js',
        'public/vendor/jquery.inputmask/dist/inputmask/jquery.inputmask.js',
        'public/vendor/jquery.inputmask/dist/inputmask/inputmask.js',
        'public/vendor/select2/dist/js/select2.js',
        'public/vendor/fastclick/fastclick.js',
        'public/vendor/slimScroll/jquery.slimscroll.js',
        'public/vendor/jsvalidation/js/jsvalidation.js',
        'public/vendor/sweetalert/dist/sweetalert.min.js',
        'public/vendor/ladda/dist/spin.min.js',
        'public/vendor/ladda/dist/ladda.min.js',
        'public/vendor/ladda/dist/ladda.jquery.min.js',
        'public/vendor/jquery-treegrid/js/jquery.cookie.js',
        'public/vendor/jquery-treegrid/js/jquery.treegrid.js',
        'public/vendor/jquery-treegrid/js/jquery.treegrid.bootstrap3.js',
        'public/vendor/Collapsible/jquery.collapsible.js'
    ], 'public/js/vendor.js', 'public/vendor');
});
