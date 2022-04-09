<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRM - @yield('title') </title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="{!! asset('flat-admin/css/bootstrap.min.css') !!}">
        <!-- Bootstrap responsive -->
        <link rel="stylesheet" href="{!! asset('flat-admin/css/bootstrap-responsive.min.css') !!}">
        <!-- jQuery UI -->
        <link rel="stylesheet" href="{!! asset('flat-admin/css/plugins/jquery-ui/smoothness/jquery-ui.css') !!}">
        <link rel="stylesheet" href="{!! asset('flat-admin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css') !!}">
        <!-- multi select -->
	    <link rel="stylesheet" href="{!! asset('flat-admin/css/plugins/select2/select2.css') !!}">
        <!-- Theme CSS -->
        <link rel="stylesheet" href="{!! asset('flat-admin/css/style.css') !!}">
        <!-- Color CSS -->
        <link rel="stylesheet" href="{!! asset('flat-admin/css/themes.css') !!}">

        <!-- Datepicker -->
	    <link rel="stylesheet" href="{!! asset('flat-admin/css/plugins/datepicker/datepicker.css') !!}">


        <!-- jQuery -->
        <script src="{!! asset('flat-admin/js/jquery.min.js') !!}"></script>
        <!-- Nice Scroll -->
        <script src="{!! asset('flat-admin/js/plugins/nicescroll/jquery.nicescroll.min.js') !!}"></script>
        <!-- jQuery UI -->
        <script src="{!! asset('flat-admin/js/plugins/jquery-ui/jquery.ui.core.min.js') !!}"></script>
        <script src="{!! asset('flat-admin/js/plugins/jquery-ui/jquery.ui.widget.min.js') !!}"></script>
        <script src="{!! asset('flat-admin/js/plugins/jquery-ui/jquery.ui.mouse.min.js') !!}"></script>
        <script src="{!! asset('flat-admin/js/plugins/jquery-ui/jquery.ui.resizable.min.js') !!}"></script>
        <script src="{!! asset('flat-admin/js/plugins/jquery-ui/jquery.ui.sortable.min.js') !!}"></script>
        <!-- slimScroll -->
        <script src="{!! asset('flat-admin/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}"></script>
        <!-- Bootstrap -->
        <script src="{!! asset('flat-admin/js/bootstrap.min.js') !!}"></script>
        <!-- Form -->
        <script src="{!! asset('flat-admin/js/plugins/form/jquery.form.min.js') !!}"></script>
        <!-- select2 -->
	    <script src="{!! asset('flat-admin/js/plugins/select2/select2.min.js') !!}"></script>

        <!-- Theme framework -->
        <script src="{!! asset('flat-admin/js/eakroko.min.js') !!}"></script>
        <!-- Theme scripts -->
        <script src="{!! asset('flat-admin/js/application.min.js') !!}"></script>
        <!-- Just for demonstration -->
        <script src="{!! asset('flat-admin/js/demonstration.min.js') !!}"></script>

        <!-- Datepicker -->
	    <script src="{!! asset('flat-admin/js/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>

        <script src="{!! asset('librarys/jquery.mask.min.js') !!}"></script>

        <!--[if lte IE 9]>
            <script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('input, textarea').placeholder();
                });
            </script>
        <![endif]-->

        <!-- Favicon -->
        <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="{!! asset('crm.png') !!}" />

        </head>


            <!-- Top Bar -->
            @include('layouts.topnavbar')




            @yield('content')

        </body>
</html>
