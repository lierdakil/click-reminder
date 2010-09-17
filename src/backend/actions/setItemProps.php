<?php

class setItemPropsAction extends ItemAction {
    protected $props = array();

    function  __construct() {
        global $message;
        parent::__construct();
        foreach($message['props'] as $prop_name=>$prop_val) {
            $this->props[htmlspecialchars($prop_name,ENT_QUOTES)] =
                    htmlspecialchars($prop_val,ENT_QUOTES);
        }
    }

    private function setItemProp($prop_name, $prop_value) {
        global $DB;
        $result=$this->db_query("SELECT item_id
            FROM $DB[item_props]
            WHERE item_id=$this->iid
                AND prop_name='$prop_name'
            LIMIT 1");
        if(empty($result))
            $this->db_query("INSERT INTO $DB[item_props]
                    (prop_name,prop_value,item_id) VALUES
                    ('$prop_name','$prop_value',$this->iid)");
        else
            $this->db_query("UPDATE $DB[item_props] SET
                    prop_value='$prop_value'
                    WHERE prop_name='$prop_name'
                        AND item_id=$this->iid");
    }

    public function exec() {
        $this->checkItemBelongs();
        foreach($this->props as $name=>$value)
            $this->setItemProp($name, $value);
        return null;
    }
}
?>
