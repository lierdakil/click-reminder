<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

class deleteUserAction extends UserAction {
    protected $user = null;
    protected $email = null;
    protected $pass = null;

    function  __construct($message) {
        parent::__construct($message);
        $this->user = $this->getMessageParam('user',
                "No username provided", ERR_NO_USER);
        $this->email = $this->getMessageParam('email',
                "No e-mail provided", ERR_NO_EMAIL);
        $this->pass = md5($this->getMessageParam('pass',
                "No password provided", ERR_NO_PASS));
    }

    private function deleteUser() {
        global $DB;
        $result = $this->db_query(
                "DELETE FROM $DB[users] ".
                "USING $DB[sessions] NATURAL JOIN $DB[users] ".
                "WHERE session_id='$this->sid' AND username='$this->user' ".
                "AND password_md5='$this->pass' AND email='$this->email'");
        if(!$result)
            throw new Exception("Delete failed!",ERR_DELE_FAIL);
    }

    public function exec() {
        $this->deleteUser();
        return null;
    }
}
?>
