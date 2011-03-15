<?php

Config::Write('ProductionEnvironment', true);

Config::Write('Router.MaxDepth', 50);
Config::Write('Router.Default', array(
	'Controller' => 'Home',
	'Action'     => 'Index'
));

Config::Write('TryCompressOutput', true);

Config::Write('Error.Log', Logs . 'Error.log');

Config::Write('Security', array(
	'Salt' => 'f#@V(su^!!%dwF6($)=Ö/',
	'HashAlgorithm' => 'sha1',
	'HashIterations' => 200,
	'BadLoginSleepLength' => 1
));