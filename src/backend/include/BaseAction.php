<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class BaseAction {
    protected $mysql = null;

    function __construct() {
        global $CONFIG;
        $this->mysql = new mysqli($CONFIG['mysql_server'],$CONFIG['mysql_user'],
                $CONFIG['mysql_password'],$CONFIG['mysql_database']);
        if($this->mysql->connect_error) {
            $message=$this->mysql->error;
            throw new Exception($message,ERR_DB);
        }
    }

    /* returns true on successful call without result if affected rows>0
     * returns result on successful call with result
     * returns false on successful call without result if affected rows=0
     * throws exception on unsuccessfull call.
     */
    protected function db_query($query) {
        $query=str_replace("\n","",$query);
        $query=ereg_replace(" +"," ",$query);
        $result = $this->mysql->query($query);
        if ($result === true) {
            if($this->mysql->affected_rows>0)
                return true;
            else
                return false;
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

class UserAction extends BaseAction {
    protected $sid = null;

    private function checkSIDValid() {
        global $DB;
        $result = $this->db_query("SELECT session_id FROM $DB[sessions]
                WHERE session_id='$this->sid' AND
                ADDTIME(last_activity, '06:00:00:00')>NOW() LIMIT 1");
        if(empty($result)) {
           throw new Exception("No such SID $this->sid or expired", ERR_NO_SID);
        }
    }

    private function updateLastActivity() {
        global $DB;
        $this->db_query("UPDATE $DB[sessions] SET
            last_activity=NOW() WHERE session_id='$this->sid'");
    }

    function  __construct() {
        global $message;
        parent::__construct();
        if(array_key_exists('sid', $message))
            $this->sid = htmlspecialchars($message['sid'],ENT_QUOTES);
        else
            throw new Exception("No SID provided", ERR_NO_SID);
        $this->checkSIDValid();
        $this->updateLastActivity();
    }
}

class ItemAction extends UserAction {
    protected $iid = null;

    protected function checkItemBelongs() {
        global $DB;
        $result=$this->db_query("SELECT sessions.user_id
            FROM $DB[sessions], $DB[items]
            WHERE sessions.user_id=items.user_id
                AND item_id=$this->iid
                AND session_id='$this->sid'
            LIMIT 1");
        if(empty($result))
            throw new Exception("Item does not belong to user or invalid item",
                    ERR_NO_IID);
    }

    function  __construct() {
        global $message;
        parent::__construct();
        if(array_key_exists('iid', $message))
            $this->iid = htmlspecialchars($message['iid'],ENT_QUOTES);
        else
            throw new Exception("No IID provided", ERR_NO_IID);
    }
}
?>
