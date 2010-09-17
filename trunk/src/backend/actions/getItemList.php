<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

require_once "checkSID.php";

class getItemListAction extends UserAction {
    protected $items = array();
    
    private function getItems() {
        global $DB;
        $result = $this->db_query("SELECT item_id FROM $DB[sessions],
            $DB[items] WHERE session_id='$this->sid' AND
            $DB[sessions].user_id=$DB[items].user_id
            ORDER BY sort_int ASC");
        foreach($result as $row)
        {
            $this->items[] = intval($row['item_id']);
        }
    }

    public function exec() {
        $this->getItems();
        if(empty($this->items))
        {
            #No such sid or no items?
            $checkSid = new checkSIDAction();
            $checkSid->exec(); //throws exception if no such sid
        }
        return $this->items;
    }
}

?>
