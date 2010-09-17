<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class loginAction extends BaseAction {
    protected $user = null;
    protected $pass = null;

    function  __construct($message) {
        parent::__construct($message);
        $this->user = $this->getMessageParam('user',
                "No username provided", ERR_NO_USER);
        $this->pass = md5($this->getMessageParam('pass',
                "No password provided", ERR_NO_PASS));
    }

    private function uidFromUserPass()
    {
        global $DB;
        $result=$this->db_query(
            "SELECT user_id FROM $DB[users] WHERE username='$this->user'
            AND password_md5='$this->pass' LIMIT 1");
        if(!empty($result)){
            return $result[0][0];
        } else {
            #No such user
            throw new Exception("User/Pass do not match", ERR_LOGIN);
        }
    }

    private function cleanOldSid($uid) {
         //lifetime of a session is 6 hours.
        global $DB;
        $this->db_query("DELETE FROM $DB[sessions]
                WHERE user_id=$uid AND
                ADDTIME(last_activity, '06:00:00:00')<NOW()");
    }

    private function makeSID($uid) {
        global $DB;
        $sid = sha1(uniqid($uid,true));
        $this->db_query("INSERT INTO $DB[sessions]
            (session_id,user_id,last_activity)
            VALUES ('$sid','$uid', NOW())");
        return $sid;
    }

    public function exec() {
        $uid = $this->uidFromUserPass();
        $this->cleanOldSid($uid);
        $sid = $this->makeSID($uid);
        return $sid;
    }
}
?>
