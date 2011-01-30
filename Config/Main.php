<?php

Config::Write('ProductionEnvironment', false);

Config::Write('Auth.Roles', array(
	'User',
	'Admin'
));

Config::Write('Recaptcha', array(
	'PublicKey'  => '6Lfw0MASAAAAANEjR9MwvkYguV9EKU17zDunP9HV',
	'PrivateKey' => '6Lfw0MASAAAAADJyCU0w5o61-GhM99voSN8N-ijg'
));

Config::Write('Security.Salt', '@f#@V%#(su^!!%dwF6($)=Ö/');