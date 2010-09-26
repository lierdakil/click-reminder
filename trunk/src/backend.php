<?php

define('__IN_CLICK__', true);

require_once 'backend/include/config.php';
require_once 'backend/include/errors.php';
require_once 'backend/include/BaseAction.php';
ini_set('display_errors', '1');

$message = file_get_contents('php://input');
$message = json_decode($message, true);
try {
    if (empty($message)) {
        throw new Exception("No message provided", ERR_NO_MSG);
    } else {
        $actions = scandir('backend/actions');
        if (in_array($message['action'] . '.php', $actions)) {
            require_once 'backend/actions/' . $message['action'] . '.php';
            $className = $message['action'] . 'Action';
            $action = new $className($message);
            $reply = $action->execute();
        } else {
            throw new Exception("No action provided", ERR_NO_ACT);
        }
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error', '', 500);
    $reply = array(
        'errcode' => htmlspecialchars($e->getCode()),
        'message' => htmlspecialchars($e->getMessage()),
    );
}

header("Content-Type:application/json");
echo json_encode($reply);
?>
