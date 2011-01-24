<?php

Config::Write('ProductionEnvironment', true);

Config::Write('Router.Default', array(
	'Controller' => 'Home',
	'Action'     => 'Index'
));

Config::Write('TryCompressOutput', true);

Config::Write('Debug.Log', Logs . 'Error.log');
