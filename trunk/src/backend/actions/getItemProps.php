<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getItemPropsAction extends ItemAction {
    protected $props = '^(';

    function  __construct($message) {
        parent::__construct($message);
        $props = $this->getMessageParam('props', 'No props list', ERR_NO_PROPS);
        for ($i=0; $i<count($props); $i++) {
            $this->props .= htmlspecialchars($props[$i],ENT_QUOTES).
                    ($i<count($props)-1?'|':'');
        }
        $this->props .= ')$';
    }

    public function exec() {
        global $DB;
        $result = $this->db_query("SELECT prop_name,prop_value ".
            "FROM $DB[item_props],$DB[items] ".
            "WHERE $DB[items].item_id=$this->iid ".
            "AND $DB[item_props].item_id=$this->iid ".
            "AND $DB[items].user_id=$this->uid ".
            "AND prop_name REGEXP '$this->props'");
        foreach($result as $row) {
            $props[$row['prop_name']] = $row['prop_value'];
        }
        return $props;
    }
}

?>
