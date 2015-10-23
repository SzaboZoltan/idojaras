<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Időjárás adatok lekérdezése és megjelenítése">
    <meta name="author" content="Szabó Zoltán">

    <link rel="icon" href="/favicon.ico">

    <title>Időjárás</title>

    <!-- Bootstrap core CSS -->
    <link href="/view/css/bootstrap.min.css" rel="stylesheet">
    <link href="/view/css/style.css" rel="stylesheet">
    <link href="http://openlayers.org/en/v3.10.1/css/ol.css" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
{$modul}
</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/view/js/jquery-2.1.4.min.js"></script>
<script src="/view/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/view/js/ie10-viewport-bug-workaround.js"></script>
{literal}<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC87tJdE5cPhQKZRS7RxbKX2QN5rmnHzNQ&signed_in=true" type="text/javascript"></script>
    <script src="http://openlayers.org/en/v3.10.1/build/ol.js" type="text/javascript"></script>
<script src="/view/js/main.js"></script>
{/literal}
</body>
</html>
