<h2>Login</h2>

<?=$Html->CreateForm('User/LoginSubmit')?>
	<? if ($Error): ?>
		<h4 class="error">Username and Password do not match</h4>
	<? endif; ?>
	<?=$Html->Label('Username:', 'Username')?>
	<?=$Html->Input('text', null, array('name' => 'Username', 'value' => $Html->Escape($Username)))?><br />
	<?=$Html->Label('Password:', 'Password')?>
	<?=$Html->Input('password', null, array('name' => 'Password'))?>
	<?=$Html->Submit('Login')?>
<?=$Html->EndForm()?>