<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>FLAT - Login</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="{!! asset('flat-admin/css/bootstrap.min.css') !!}">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="{!! asset('flat-admin/css/bootstrap-responsive.min.css') !!}">
	<!-- icheck -->
	<link rel="stylesheet" href="{!! asset('flat-admin/css/plugins/icheck/all.css') !!}">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="{!! asset('flat-admin/css/style.css') !!}">
	<!-- Color CSS -->
	<link rel="stylesheet" href="{!! asset('flat-admin/css/themes.css') !!}">


	<!-- jQuery -->
	<script src="{!! asset('flat-admin/js/jquery.min.js') !!}"></script>

	<!-- Nice Scroll -->
	<script src="{!! asset('flat-admin/js/plugins/nicescroll/jquery.nicescroll.min.js') !!}"></script>
	<!-- Validation -->
	<script src="{!! asset('flat-admin/js/plugins/validation/jquery.validate.min.js') !!}"></script>
	<script src="{!! asset('flat-admin/js/plugins/validation/additional-methods.min.js') !!}"></script>
	<!-- icheck -->
	<script src="{!! asset('flat-admin/js/plugins/icheck/jquery.icheck.min.js') !!}"></script>
	<!-- Bootstrap -->
	<script src="{!! asset('flat-admin/js/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('flat-admin/js/eakroko.js') !!}"></script>

	<!--[if lte IE 9]>
		<script src="{!! asset('flat-admin/js/plugins/placeholder/jquery.placeholder.min.js') !!}"></script>
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

<body class='login'>
	<div class="wrapper">
		<h1><a href="javascript:void(0)">DRY AIR TEC</a></h1>
		<div class="login-body">
            @yield('content')
		</div>
	</div>
</body>

</html>
