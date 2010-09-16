<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class getItemPropsAction extends BaseAction {
    protected $iid = null;
    protected $props = '^(';

    function  __construct() {
        parent::__construct();
        if(array_key_exists('iid', $_POST))
            $this->iid = htmlspecialchars($_POST['iid'],ENT_QUOTES);
        else
            throw new Exception ('No item id provided', ERR_NO_IID);
        for ($i=0; $i<count($_POST['props']); $i++) {
            $this->props .= htmlspecialchars($_POST['props'][$i],ENT_QUOTES).
                    ($i<count($_POST['props'])-1?'|':')$');
        }
    }

    function exec() {
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
        return json_encode($props);
    }
}

?>
