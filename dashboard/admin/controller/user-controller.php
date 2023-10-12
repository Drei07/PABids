<?php
include_once '../../../configuration/settings-configuration.php';
include_once __DIR__ . '/../../../database/dbconfig.php';
require_once '../authentication/admin-class.php';


// Create a new class for handling product insertion
class User
{
    private $admin;
    private $main_url;
    private $smtp_email;
    private $smtp_password;
    private $system_name;


    public function __construct()
    {
        $this->admin = new ADMIN();
        $this->main_url = $this->admin->mainUrl();
        $this->smtp_email = $this->admin->smtpEmail();
        $this->smtp_password = $this->admin->smtpPassword();
        $this->system_name = $this->admin->systemName();
    }

    public function disabledUser($user_id){

        $disabled = "disabled";
        $stmt = $this->admin->runQuery('UPDATE users SET account_status=:account_status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"               => $user_id,
            ":account_status"   => $disabled,
        ));

        if ($exec) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'User successfully disabled!';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../user');
        exit();

    }

    public function activateUser($user_id){

        $disabled = "active";
        $stmt = $this->admin->runQuery('UPDATE users SET account_status=:account_status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"               => $user_id,
            ":account_status"   => $disabled,
        ));

        if ($exec) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'User successfully activate!';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../user');
        exit();

    }

}

//disabled user
if (isset($_GET['disabled_user'])) {
    $user_id = $_GET["id"];

    $disabled_user = new User();
    $disabled_user->disabledUser($user_id);
}

//activate user
if (isset($_GET['activate_user'])) {
    $user_id = $_GET["id"];

    $activate_user = new User();
    $activate_user->activateUser($user_id);
}