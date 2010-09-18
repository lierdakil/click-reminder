<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

define('ERR_NO_MSG', 1); #Returned when there is no 'message' parameter in POST
define('ERR_NO_ACT', 2); #Returned when message does not have 'action' property
define('ERR_LOGIN', 3); #Returned if login is failed: user/pass do not match or there is no requested user at all
define('ERR_DB', 4); #Returned whenever there are database problems on server
define('ERR_NO_SID', 5); #Sid expired, never existed, or was not provided at all
define('ERR_NO_IID', 6); #No itemID provided
define('ERR_NO_USER', 7); #No username provided
define('ERR_NO_EMAIL', 8); #No email provided
define('ERR_NO_PASS', 9); #No password provided
define('ERR_NO_PROPS', 10); #No props to set or read specified
define('ERR_USER_EXISTS', 11); #On registration, such username already exists
define('ERR_DELE_FAIL', 12); #Failed to delete user. Invalid data most probable
define('ERR_NO_TIMESTAMP', 13); #No timestamp provided

?>
