<?php
define('__IN_CLICK__', true);

require_once 'backend/include/config.php';
require_once 'backend/include/errors.php';
require_once 'backend/include/BaseAction.php';
ini_set('display_errors', '1');

try {
    if(empty($_POST)) {
        throw new Exception("No message provided",ERR_NO_MSG);
    } else {
        $actions = scandir('backend/actions');
        if(in_array($_POST['action'].'.php', $actions)) {
            require_once 'backend/actions/'.$_POST['action'].'.php';
            $className = $_POST['action'].'Action';
            $action = new $className();
            $reply = $action->exec();
        } else {
            throw new Exception("No action provided",ERR_NO_ACT);
        }
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error','',500);
    $reply=json_encode(array(
        'errcode' => $e->getCode(),
        'message' => $e->getMessage(),
    ));
}

echo $reply;
?>
