<?php

require_once ('codebird.php');
\Codebird\Codebird::setConsumerKey('YOURKEY', 'YOURSECRET'); // static, see 'Using multiple Codebird instances'

$cb = \Codebird\Codebird::getInstance();

$cb->setToken('YOURTOKEN', 'YOURTOKENSECRET');

$params = array(
  'status' => 'Auto Post on Twitter with PHP http://goo.gl/OZHaQD #php #twitter'
);
$reply = $cb->statuses_update($params);