<h2>Register</h2>

<?=$Html->CreateForm('User/RegisterSubmit')?>
	<? if ($GeneralError): ?>
		<? if (count($Errors) === 0): ?>
			<h4 class="error">An error occured. Please try again later.</h4>
		<? else: ?>
			<ul>
				<? foreach ($Errors as $Error): ?>
					<li class="error"><?=$Error?></li>
				<? endforeach; ?>
			</ul>
		<? endif; ?>
	<? endif; ?>
	<?=$Html->Label('Username:', 'Username')?>
	<?=$Html->Input('text', null, array('name' => 'Username', 'value' => $Html->Escape($Username)))?><br />
	<?=$Html->Label('Password:', 'Password')?>
	<?=$Html->Input('password', null, array('name' => 'Password'))?><br />
	<?=$Html->Label('Password Again:', 'PasswordAgain')?>
	<?=$Html->Input('password', null, array('name' => 'PasswordAgain'))?>
	<?=$Recaptcha->WithTheme('clean')?>
	<?=$Recaptcha->GetHtml()?>
	<?=$Html->Submit('Register')?>
<?=$Html->EndForm()?>