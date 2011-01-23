<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?=isset($Title) ? $Title : ''?></title>
		<?=$Html->Css('styles.css')?>
	</head>
	<body>
		<?require $View?>
	</body>
</html>