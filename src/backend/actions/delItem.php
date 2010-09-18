<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class delItemAction extends ItemAction {

    private function delItem() {
        global $DB;
        $this->db_query("DELETE FROM $DB[items] WHERE item_id=$this->iid");
    }

    public function exec() {
        $this->checkItemBelongs();
        $this->delItem();
        return null;
    }
}
?>
