<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class setItemPropsAction extends ItemAction {
    protected $props = array();

    function  __construct($message) {
        parent::__construct($message);
        $props = $this->getMessageParam('props', 'No props list', ERR_NO_PROPS);
        foreach($props as $prop_name=>$prop_val) {
            $this->props[htmlspecialchars($prop_name,ENT_QUOTES)] =
                    htmlspecialchars($prop_val,ENT_QUOTES);
        }
    }

    private function setItemProps() {
        global $DB;
        $values="";
        foreach($this->props as $name=>$value)
            $values[] = "('$name', '$value', $this->iid)";
        $strvalues=implode(',', $values);

        $this->db_query("INSERT INTO $DB[item_props] ".
                "(prop_name,prop_value,item_id) VALUES $strvalues".
                "ON DUPLICATE KEY UPDATE prop_value=VALUES(prop_value)");

        $timestamp = microtime(true);
        $this->db_query("UPDATE $DB[items] SET ".
                "timestamp=$timestamp ".
                "WHERE item_id=$this->iid");
    }

    public function exec() {
        $this->checkItemBelongs();
        $this->setItemProps();
        return null;
    }
}
?>
