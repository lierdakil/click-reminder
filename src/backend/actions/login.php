<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class loginAction extends BaseAction {
    protected $user = null;
    protected $pass = null;
    protected $uid = null;

    function  __construct() {
        global $message;
        parent::__construct(false);
        $this->user = htmlspecialchars($message['user'],ENT_QUOTES);
        $this->pass = htmlspecialchars($message['pass'],ENT_QUOTES);
    }

    private function uidFromUserPass()
    {
        global $DB;
        $result=$this->db_query(
            "SELECT user_id FROM $DB[users] WHERE username='$this->user'
            AND password_md5='$this->pass' LIMIT 1");
        if(!empty($result)){
            $this->uid = $result[0][0];
        } else {
            #No such user
            throw new Exception("User/Pass do not match", ERR_LOGIN);
        }
    }

    private function cleanOldSid() {
         //lifetime of a session is 6 hours.
        global $DB;
        $this->db_query("DELETE FROM $DB[sessions]
                WHERE user_id=$this->uid AND
                ADDTIME(last_activity, '06:00:00:00')<NOW()");
    }

    private function makeSID() {
        global $DB;
        $this->sid = sha1(uniqid($this->uid,true));
        $this->db_query("INSERT INTO $DB[sessions]
            (session_id,user_id,last_activity)
            VALUES ('$this->sid','$this->uid', NOW())");
    }

    public function exec() {
        $this->uidFromUserPass();
        $this->cleanOldSid();
        $this->makeSID();
        return $this->sid;
    }
}
?>
