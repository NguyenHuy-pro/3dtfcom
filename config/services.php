<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'key' => '',
		'secret' => '',
	],

	/*
	'facebook' => [
		'client_id' => '1837265536541006',
		'client_secret' => '7126404627a6f354418ca28c987e8e46',
		'redirect' => 'http://3dtf.local.com/login/facebook/callback',
	],
	*/

	'facebook' => [
		'client_id' => '1414531328614181',
		'client_secret' => 'b73e429dca35d2c97a1cc54e3a196017',
		'redirect' => 'http://3dtf.com/register/facebook/callback',
	],

	# google
	'google' => [
		'client_id' => '13049530624-ncbsbltdqstpcokne3b55a0sf7h52c8f.apps.googleusercontent.com',
		'client_secret' => 'prql8VBWxs57B4UMqLIEXk5W',
		'redirect' => 'http://3dtf.com/register/google/callback',
	],
];
