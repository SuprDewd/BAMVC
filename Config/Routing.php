<?php

Config::Write('Router.CustomRoutes', array(
	'/^Animals(\/.*)?$/' => 'Home$1',
	'/^Login$/' => 'User/Login',
	'/^Logout$/' => 'User/Logout',
	'/^Register$/' => 'User/Register'
));