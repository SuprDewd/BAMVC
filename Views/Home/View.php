<h2>View Test</h2>

<? if ($Animal): ?>
	<h3>ID: <?=$Animal['ID']?></h3>
	<h3>Name: <?=$Animal['Name']?></h3>
<? else: ?>
	<h3>Animal not found.</h3>
<? endif; ?>