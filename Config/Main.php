<?php

Config::Write('ProductionEnvironment', false);

Config::Write('Router.Default', array(
	'Controller' => 'Home',
	'Action'     => 'Index'
));