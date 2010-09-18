<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class checkSIDAction extends UserAction {
    public function exec() {
        #Return current microtimestamp
        return microtime(true);
    }
}

?>
