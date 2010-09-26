<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getUpdateListAction extends UserAction {
    protected $timestamp = null;

    function  __construct($message) {
        parent::__construct($message);
        $this->timestamp = $this->getMessageParam('time',
                'No timestamp provided', ERR_NO_TIMESTAMP);
        if(!is_numeric($this->timestamp))
            throw new Exception('Invalid timestamp provided', ERR_NO_TIMESTAMP);
    }
    
    private function getUpdatedItems() {
        global $DB;
        $result = $this->db_query("SELECT item_id FROM $DB[items] ".
            "WHERE timestamp > $this->timestamp AND ".
            "user_id=$this->uid ".
            "ORDER BY sort_int ASC");
        foreach($result as $row) {
            $items[] = intval($row['item_id']);
        }
        return $items;
    }

    public function exec() {
        $timestamp = microtime(true);
        $items = $this->getUpdatedItems();
        return array(
            'time' => $timestamp,
            'items' => $items,
                );
    }
}

?>
