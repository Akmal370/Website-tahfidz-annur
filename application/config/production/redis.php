<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Default connection group
$config['redis_default']['host'] = '127.0.0.1';		// IP address or host
$config['redis_default']['port'] = '6379';			// Default Redis port is 6379
$config['redis_default']['password'] = '';			// Can be left empty when the server does not require AUTH

$config['redis_slave']['host'] = '';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';
