<?php

class addItemAction extends UserAction {

    private function getUid(){
        global $DB;
        $result = $this->db_query("SELECT user_id FROM $DB[sessions]
                WHERE session_id='$this->sid' LIMIT 1");
        if(empty($result))
            throw new Exception("Stale SID!", ERR_NO_SID);
        else
            return $result[0]['user_id'];
    }

    private function newItem($uid) {
        global $DB;
        $this->db_query("INSERT INTO $DB[items] SET user_id=$uid");
        $result = $this->db_query("SELECT LAST_INSERT_ID()");
        return $result[0][0];
    }

    public function exec() {
        $uid = $this->getUid();
        $iid = $this->newItem($uid);
        return $iid;
    }
}
?>
