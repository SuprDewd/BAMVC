<?php

Config::Write('ProductionEnvironment', true);

Config::Write('Router.Default', array(
	'Controller' => 'Home',
	'Action'     => 'Index'
));

Config::Write('TryCompressOutput', true);

Config::Write('Error.Log', Logs . 'Error.log');