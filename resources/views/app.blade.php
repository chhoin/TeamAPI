<!DOCTYPE html>
<html>
<head>
	<title>Article Management</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">\
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link href="asset/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="asset/fileinput/js/fileinput.js" type="text/javascript"></script>
	<script src="asset/fileinput/js/fileinput_locale_fr.js" type="text/javascript"></script>
	<script src="asset/fileinput/js/fileinput_locale_es.js" type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
    @yield('head')
</head>
<body>
	<!-- header -->
	<div class="container-fluid head">
		<div class="row">
			<div class="col-xs-12">
					<h2>Well Come Article Manegement</h2>
			</div>
		</div>
	</div>
    <br/>

    	@yield('body')
	
	<br/>
	<!-- footer -->
	<div class="container-fluid foot">
		<div class="row">
			<div class="col-xs-12">
					<h4>Copy Right@2015</h4>
			</div>
		</div>
	</div>
	
	 <script src="{{ asset('asset/js/jquery.js') }}"></script>
	 <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
	 @yield('foot')
</body>
</html>

