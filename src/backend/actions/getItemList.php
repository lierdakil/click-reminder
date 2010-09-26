<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getItemListAction extends UserAction {
    
    private function getItems() {
        global $DB;
        $result = $this->db_query("SELECT item_id FROM ".
            "$DB[items] WHERE ".
            "user_id = $this->uid ".
            "ORDER BY sort_int ASC");
        foreach($result as $row)
        {
            $items[] = intval($row['item_id']);
        }
        return $items;
    }

    public function exec() {
        return $this->getItems();
    }
}

?>
