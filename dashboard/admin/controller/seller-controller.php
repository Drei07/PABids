<?php
include_once '../../../configuration/settings-configuration.php';
include_once __DIR__ . '/../../../database/dbconfig.php';
require_once '../authentication/admin-class.php';


// Create a new class for handling product insertion
class Seller
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

    public function acceptSeller($seller_id, $status)
    {
        $stmt = $this->admin->runQuery('UPDATE seller SET status=:status WHERE id=:id');
        $stmt->execute(array(
            ":id"        => $seller_id,
            ":status"   => $status,
        ));

        if ($stmt) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Seller Accept';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../pending-seller');
        exit();
    }

    public function declineSeller($seller_id, $status) {
        $stmt = $this->admin->runQuery('UPDATE seller SET status=:status WHERE id=:id');
        $stmt->execute(array(
            ":id" => $seller_id,
            ":status" => $status,
        ));
    
        $user_data = $this->getSellerData($seller_id);
        $email = $user_data['email'];
    
        if ($stmt) {
            $message = "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Decline</title>
        <style>
            /* Define your CSS styles here */
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
            }
            
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 30px;
                background-color: #ffffff;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            
            p {
                color: #666666;
                font-size: 16px;
                margin-bottom: 10px;
            }
            
            .button {
                display: inline-block;
                padding: 12px 24px;
                background-color: #0088cc;
                color: #ffffff;
                text-decoration: none;
                border-radius: 4px;
                font-size: 16px;
                margin-top: 20px;
            }
            
            .logo {
                display: block;
                text-align: center;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='logo'>
            <img src='cid:logo' alt='Logo' width='150'>
            </div>
            <h1>Congratulations! You're the Winning Bidder</h1>
            <p>Hello <strong>$email</strong>,</p>
            <p>We are here to inform you that your registration as a seller is declined. Thank you for using PABids:</p><br>
        </div>
    </body>
    </html>";
    
            $subject = "Decline Registration";
    
            $this->admin->send_mail($email, $message, $subject, $this->smtp_email, $this->smtp_password, $this->system_name);
    
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Seller Decline';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        }
        header('Location: ../pending-seller');
        exit();
    }
    

    private function getSellerData($seller_id)
    {
        $stmt = $this->admin->runQuery("SELECT * FROM seller WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $seller_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (isset($_POST['btn-accept-seller'])) {
    $seller_id = $_GET["id"];
    $status = "verify";

    $accept_seller = new Seller();
    $accept_seller->acceptSeller($seller_id, $status);
}

if (isset($_POST['btn-decline-seller'])) {
    $seller_id = $_GET["id"];
    $status = "not_verify";

    $decline_seller = new Seller();
    $decline_seller->declineSeller($seller_id, $status);
}
