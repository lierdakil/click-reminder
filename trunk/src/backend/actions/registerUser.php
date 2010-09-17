<?php

if(!defined('__IN_CLICK__'))
    die('Hacking attempt!');

require_once 'login.php';

class registerUserAction extends BaseAction {
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

    private function checkUserExists() {
        global $DB;
        $result = $this->db_query("SELECT user_id FROM $DB[users] ".
                "WHERE username='$this->user'");
        if(!empty($result))
            throw new Exception("Username '$this->user' already exists!",
                    ERR_USER_EXISTS);
    }

    private function checkEmailExists() {
        global $DB;
        $result = $this->db_query("SELECT user_id FROM $DB[users] ".
                "WHERE email='$this->email'");
        if(!empty($result))
            throw new Exception("Email '$this->email' already registered!",
                    ERR_USER_EXISTS);
    }

    private function registerUser() {
        global $DB;
        $this->db_query("INSERT INTO $DB[users] ".
                "(username, email, password_md5) ".
                "VALUES ('$this->user','$this->email','$this->pass')");
    }

    public function exec() {
        $this->checkUserExists();
        $this->checkEmailExists();
        $this->registerUser();
        mail($this->email, $LANG['mail_registered_subject'],
                $LANG['mail_registered_message']);
        //$login = new loginAction($message);
        //return $login->exec();
        return null;
    }
}
?>
