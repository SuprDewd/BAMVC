<h2>Register</h2>

<?=$Html->CreateForm('User/RegisterSubmit')?>
	<? if ($Error): ?>
		<h4 class="error">One of the following errors occured:</h4>
		<ul>
			<li>Passwords did not match</li>
			<li>Password is less than 6 characters or more than 15 characters</li>
			<li>Username is taken</li>
			<li>Invalid username</li>
		</ul>
	<? endif; ?>
	<?=$Html->Label('Username:', 'Username')?>
	<?=$Html->Input('text', null, array('name' => 'Username', 'value' => $Html->Escape($Username)))?><br />
	<?=$Html->Label('Password:', 'Password')?>
	<?=$Html->Input('password', null, array('name' => 'Password'))?><br />
	<?=$Html->Label('Password Again:', 'PasswordAgain')?>
	<?=$Html->Input('password', null, array('name' => 'PasswordAgain'))?>
	<?=$Html->Submit('Register')?>
<?=$Html->EndForm()?>