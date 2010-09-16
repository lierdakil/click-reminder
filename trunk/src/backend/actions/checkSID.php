<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class checkSIDAction extends BaseAction {
    function checkSIDValid() {
        global $DB;
        $result = $this->db_query("SELECT session_id FROM $DB[sessions]
                WHERE session_id='$this->sid' AND
                ADDTIME(last_activity, '06:00:00:00')>NOW() LIMIT 1");
        if(empty($result)) {
           throw new Exception("No such SID or expired", ERR_NO_SID);
        }
    }

    function updateLastActivity() {
        global $DB;
        $this->db_query("UPDATE $DB[sessions] SET
            last_activity=NOW() WHERE session_id='$this->sid'");
    }

    function exec() {
        $this->checkSIDValid();
        $this->updateLastActivity();
        return "";
    }
}

?>
