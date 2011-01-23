<?php

Config::Write('Router.CustomRoutes', array(
	'/^Animals(\/.*)?$/' => 'Home$1'
));