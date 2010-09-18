<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class delItemAction extends ItemAction {

    private function delItem() {
        global $DB;
        $this->db_query("DELETE FROM $DB[items], $DB[item_props] ".
                "USING $DB[items] NATURAL LEFT JOIN $DB[item_props] ".
                "WHERE item_id=$this->iid");
    }

    public function exec() {
        $this->checkItemBelongs();
        $this->delItem();
        return null;
    }
}
?>
