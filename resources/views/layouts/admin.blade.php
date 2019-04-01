<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Global Family Survey')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/skins/skin-purple.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('/plugins/select2/select2.min.css') }}">
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- Admin LTE -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/AdminLTE.min.css') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('/css/gfs-admin.css') }}">

    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

    <!-- jQuery -->
    <script type="text/javascript" src="/plugins/jQuery/jquery-3.2.1.min.js"></script>
    <!-- DataTables -->
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body class="hold-transition skin-purple sidebar-mini {{ request()->is('dashboard*') ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">
        @include('components.header')
        @include('components.sidemenu')

        <div id="app" class="content-wrapper">
            @yield('content')
        </div>

        @include('components.footer')
    </div>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    {{-- <!-- jQuery -->
    <script type="text/javascript" src="/plugins/jQuery/jquery-3.2.1.min.js"></script> --}}
    <!-- bootstrap -->
    <script type="text/javascript" src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>
    <!-- AdminLTE -->
    <script type="text/javascript" src="{{ asset('/adminlte/js/adminlte.min.js') }}"></script>
    <!-- gfs -->
    <script type="text/javascript" src="{{ url('assets/js/gfs-admin.js?date='.date('YmdHis')) }}"></script>
    <!-- dynamically added scripts -->
    @stack('scripts')
</body>
</html>
