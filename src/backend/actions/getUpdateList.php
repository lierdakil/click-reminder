<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getUpdateListAction extends UserAction {
    protected $timestamp = null;

    function  __construct($message) {
        parent::__construct($message);
        $this->timestamp = $this->getMessageParam('timestamp',
                'No timestamp provided', ERR_NO_TIMESTAMP);
        if(!is_numeric($this->timestamp))
            throw new Exception('Invalid timestamp provided', ERR_NO_TIMESTAMP);
    }
    
    private function getUpdatedItems() {
        global $DB;
        $result = $this->db_query("SELECT item_id FROM $DB[sessions], ".
            "$DB[items] WHERE session_id='$this->sid' AND ".
            "timestamp > $this->timestamp AND ".
            "$DB[sessions].user_id=$DB[items].user_id ".
            "ORDER BY sort_int ASC");
        foreach($result as $row)
        {
            $items[] = intval($row['item_id']);
        }
        return $items;
    }

    public function exec() {
        return $this->getUpdatedItems();
    }
}

?>