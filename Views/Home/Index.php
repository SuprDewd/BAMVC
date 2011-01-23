<?=$Html->Css('scaffoldTest.css', true)?>
<h2>Test</h2>

<ol>
	<? foreach ($Animals as $Animal): ?>
		<li><?=$Animal?></li>
	<? endforeach; ?>
</ol>