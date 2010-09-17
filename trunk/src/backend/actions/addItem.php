<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class addItemAction extends UserAction {

    private function newItem() {
        global $DB;
        $result = $this->db_query("INSERT INTO $DB[items] (user_id) ".
                "SELECT user_id FROM $DB[sessions] ".
                "WHERE session_id='$this->sid' LIMIT 1");
        if(!$result)
            throw new Exception("Stale SID!", ERR_NO_SID);
        return mysqli_insert_id($this->mysql);
    }

    public function exec() {
        return $this->newItem();
    }
}
?>
