<?php

class addItemAction extends UserAction {

    protected $uid = null;
    protected $iid = null;

    private function getUid(){
        global $DB;
        $result = $this->db_query("SELECT user_id FROM $DB[sessions]
                WHERE session_id='$this->sid' LIMIT 1");
        if(empty($result))
            throw new Exception("Stale SID!", ERR_NO_SID);
        else
            $this->uid = $result[0]['user_id'];
    }

    private function newItem() {
        global $DB;
        $this->db_query("INSERT INTO $DB[items] SET user_id=$this->uid");
        $result = $this->db_query("SELECT LAST_INSERT_ID()");
        $this->iid = $result[0][0];
    }

    public function exec() {
        $this->getUid();
        $this->newItem();
        return $this->iid;
    }
}
?>
