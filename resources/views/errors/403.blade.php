<!DOCTYPE html>
<html>
<head>
<title>Action Forbidden</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Custom Theme files -->
<link href="/css/error-style.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!-- //web font -->
</head>
<body>
<!--mian-content-->
<h1>{{ config('app.name') }}</h1>
	<div class="main-wthree">
		<h2>403</h2>
		<p>
			<span class="sub-agileinfo">Access Denied! </span>You dont have permission to access this page. <br/>
			{{ $exception->getMessage() }}
		</p>
	</div>
<!--//mian-content-->
<!-- copyright -->
	<div class="copyright-w3-agile">
		<p> © {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now())->year }} Global Family Survey . All rights reserved </p>
	</div>
<!-- //copyright -->

</body>
</html>
