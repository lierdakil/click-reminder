<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getItemPropsAction extends ItemAction {
    protected $props = '^(';

    function  __construct($message) {
        parent::__construct($message);
        for ($i=0; $i<count($message['props']); $i++) {
            $this->props .= htmlspecialchars($message['props'][$i],ENT_QUOTES).
                    ($i<count($message['props'])-1?'|':')$');
        }
    }

    public function exec() {
        global $DB;
        $result = $this->db_query("SELECT prop_name,prop_value
            FROM $DB[item_props],$DB[items],$DB[sessions]
            WHERE $DB[items].item_id=$this->iid
            AND $DB[item_props].item_id=$this->iid
            AND $DB[items].user_id=$DB[sessions].user_id
            AND session_id='$this->sid'
            AND prop_name REGEXP '$this->props'");
        foreach($result as $row) {
            $props[$row['prop_name']] = $row['prop_value'];
        }
        return $props;
    }
}

?>
