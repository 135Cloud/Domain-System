<?php http_response_code(500); ?>
<!DOCTYPE html>
<html>
<head>
<title>500 Internal Server Error</title>
<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?=$_Global['URL']?>/static/error/css/style.css" />
</head>
<body>
<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>500</h1>
			<h2>Oops! An error occurred</h2>
			<p>This program is missing files, or the file permissions are incorrect.</p>
			<p>Route : <?=(@$_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/Index')?></p>
			<a href="<?=$_Global['URL']?>">Back to homepage</a>
		</div>
	</div>
</body>
</html>