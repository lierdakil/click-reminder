<?php

class delItemAction extends ItemAction {

    private function delItem() {
        global $DB;
        $this->db_query("DELETE FROM $DB[items] WHERE item_id=$this->iid");
        $this->db_query("DELETE FROM $DB[item_props] WHERE item_id=$this->iid");
    }

    public function exec() {
        $this->checkItemBelongs();
        $this->delItem();
        return null;
    }
}
?>
