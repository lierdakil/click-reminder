<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class logoutAction extends BaseAction {
    function exec() {
        global $DB;
        $this->db_query("DELETE FROM $DB[sessions]
            WHERE session_id='$this->sid'");
        return "";
    }
}

?>
