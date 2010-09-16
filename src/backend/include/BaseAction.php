<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class BaseAction {
    protected $mysql = null;
    protected $sid = null;

    function __construct($sid_required=true) {
        global $CONFIG;
        $this->mysql = new mysqli($CONFIG['mysql_server'],$CONFIG['mysql_user'],
                $CONFIG['mysql_password'],$CONFIG['mysql_database']);
        if($this->mysql->connect_error) {
            $message=$this->mysql->error;
            throw new Exception($message,ERR_DB);
        }
        if(array_key_exists('sid', $_POST))
            $this->sid = htmlspecialchars($_POST['sid'],ENT_QUOTES);
        else if($sid_required)
            throw new Exception("No SID provided", ERR_NO_SID);
    }

    /* returns true or result array on successful call,
     * throws exception on unsuccessfull call.
     */
    function db_query($query) {
        $result = $this->mysql->query($query);
        if ($result === true) {
            return true;
        } else if ($result === false){
            $message='Error #'.$this->mysql->errno.' when executing "'.
                $query.'": "'.$this->mysql->error.'"';
            throw new Exception($message,ERR_DB);
        } else {
            $ret = $result->fetch_all(MYSQLI_BOTH);
            $result->close();
            return $ret;
        }
    }
}
?>
