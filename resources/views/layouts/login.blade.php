<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('page-title') | {{ config('app.name', 'Global Family Survey') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/skins/skin-blue.min.css') }}">

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('/plugins/select2/select2.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Admin LTE -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/AdminLTE.min.css') }}">

    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('/plugins/jQuery/jquery-3.2.1.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/gfs-admin.css') }}">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            GLOBAL<b> FS</b>
        </div>
        <!-- /.login-logo -->
        @yield('content')
    </div>
    <!-- /.login-box -->

    <!-- select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>

    <!-- gfs -->
    <script type="text/javascript" src="{{ asset('/js/gfs-admin.js') }}"></script>
</body>
</html>
