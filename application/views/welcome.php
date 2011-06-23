<html>
<head>
<title></title>
</head>
<body>

<?php foreach ($teamLeagues->result() as $league): ?>
	<p><?=$league->name?></p>
<?php endforeach; ?>
</body>
</html>