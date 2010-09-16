<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

define('ERR_NO_MSG', 1); #Returned when there is no 'message' parameter in POST
define('ERR_NO_ACT', 2); #Returned when message does not have 'action' property
define('ERR_LOGIN', 3); #Returned if login is failed: user/pass do not match or there is no requested user at all
define('ERR_DB', 4); #Returned whenever there are database problems on server
define('ERR_NO_SID', 5); #Sid expired, never existed, or was not provided at all
define('ERR_NO_IID', 6); #No itemID provided

?>
