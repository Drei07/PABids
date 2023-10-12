<?php
include_once __DIR__ . '/../../../database/dbconfig.php';
include_once '../../../configuration/settings-configuration.php';
require_once '../authentication/user-class.php';

class Registration {
    private $user;
    private $main_url;
    private $smtp_email;
    private $smtp_password;
    private $system_name;


    public function __construct() {
        $this->user = new USER();
        $this->main_url = $this->user->mainUrl();
        $this->smtp_email = $this->user->smtpEmail();
        $this->smtp_password = $this->user->smtpPassword();
        $this->system_name = $this->user->systemName();
    }

    // add user
    public function registerUser($first_name, $middle_name, $last_name, $phone_number, $email, $hash_password, $tokencode, $user_type)
    {
        $stmt = $this->user->runQuery("SELECT * FROM users WHERE email=:email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            $_SESSION['status_title'] = "Oops!";
            $_SESSION['status'] = "Email already taken. Please try another one.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_timer'] = 100000;
            header('Location: ../../../');
            exit();
        } else {
            if ($this->user->register($first_name, $middle_name, $last_name, $phone_number, $email, $hash_password, $tokencode, $user_type)) {
                $id = $this->user->lasdID();
                $key = base64_encode($id);
                $id = $key;

                $message = 
                "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>Email Verification</title>
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
                        <h1>Email Verification</h1>
                        <p>Hello, <strong>$email</strong></p>
                        <p>Welcome to $this->system_name</p>
                        Email:<br />$email <br />
                        Temporary Password:<br />$hash_password
                        <p>To complete your account registration, please click the button below to verify your email address:</p>
                        <p><a class='button' href='$this->main_url/verify-account?id=$id&code=$tokencode'>Verify Email</a></p>
                        <p>If you did not sign up for an account for PABids, you can safely ignore this email.</p>
                        <p>Thank you!</p>
                    </div>
                </body>
                </html>
                ";
                $subject = "Verify Email";

                $this->user->send_mail($email, $message, $subject, $this->smtp_email, $this->smtp_password, $this->system_name);
                $_SESSION['status_title'] = "Success!";
                $_SESSION['status'] = "Please check the Email to verify the account.";
                $_SESSION['status_code'] = "success";
                $_SESSION['status_timer'] = 40000;
                header('Location: ../../../');
                exit();
            } else {
                // Error reporting
                $error = $this->user->getLastError();
                echo "Error: ".$error;

                $_SESSION['status_title'] = "Sorry !";
                $_SESSION['status'] = "Something went wrong, please try again!";
                $_SESSION['status_code'] = "error";
                $_SESSION['status_timer'] = 10000000;
                header('Location: ../../../');
                exit();
            }
        }
    }

}

Class SellerRegistration{
    private $conn;

    public function __construct() 
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function sellerRegistration($user_id, $shop_name, $email, $phone_number, $region, $province, $municipality, $barangay, $street, $postal_code, $valid_id_front, $valid_id_back){
        $folderFront = "../../../src/valid_id/" . basename($valid_id_front);
        $folderBack = "../../../src/valid_id/" . basename($valid_id_back);
        
        // Check if both files were uploaded successfully
        if (move_uploaded_file($_FILES['valid_id_front']['tmp_name'], $folderFront) && move_uploaded_file($_FILES['valid_id_back']['tmp_name'], $folderBack)) {
            $stmt = $this->runQuery('INSERT INTO seller (user_id, shop_name, email, phone_number, region, province, municipality, barangay, street, postal_code, valid_id_front, valid_id_back) VALUES (:user_id, :shop_name, :email, :phone_number, :region, :province, :municipality, :barangay, :street, :postal_code, :valid_id_front, :valid_id_back)');
            $exec = $stmt->execute(array(
                ":user_id"      => $user_id,
                ":shop_name"    => $shop_name,
                ":email"        => $email,
                ":phone_number" => $phone_number,
                ":region"       => $region,
                ":province"     => $province,
                ":municipality" => $municipality,
                ":barangay"     => $barangay,
                ":street"       => $street,
                ":postal_code"  => $postal_code,
                ":valid_id_front" => $valid_id_front,
                ":valid_id_back"  => $valid_id_back,
            ));
    
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Successfully registered. Please wait for an email to confirm your registration. Thank you for using PABids';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong. Please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            // Handle file upload error here
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'File upload failed. Please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }
    
        header('Location: ../on-boarding');
    }
    

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

}

    //registration the details
    if (isset($_POST['btn-registration'])) {
        $first_name     = trim($_POST['first_name']);
        $middle_name    = trim($_POST['middle_name']);
        $last_name      = trim($_POST['last_name']);
        $phone_number   = trim($_POST['phone_number']);
        $email          = trim($_POST['email']);

        $user_type          = 2;
        $tokencode          = md5(uniqid(rand()));
    
    
        // Generate Password
        $varchar            = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $shuffle            = str_shuffle($varchar);
        $hash_password      = substr($shuffle,0,8);
    

        $registration = new Registration();
        $registration->registerUser($first_name, $middle_name, $last_name, $phone_number, $email, $hash_password, $tokencode, $user_type);
    }

    //seller registration
    if(isset($_POST['btn-seller-registration'])){
        $user_id       = $_SESSION['userSession'];
        $shop_name     = trim($_POST['shop_name']);
        $email         = trim($_POST['email']);
        $phone_number  = trim($_POST['phone_number']);
        $region        = trim($_POST['region_text']);
        $province      = trim($_POST['province_text']);
        $municipality  = trim($_POST['municipality_text']);
        $barangay      = trim($_POST['barangay_text']);
        $street        = trim($_POST['street']);
        $postal_code   = trim($_POST['postal_code']);
        $valid_id_front      = $_FILES['valid_id_front']['name'];
        $valid_id_back     = $_FILES['valid_id_back']['name'];


        $seller_registration = new SellerRegistration();
        $seller_registration->sellerRegistration($user_id, $shop_name, $email, $phone_number, $region, $province, $municipality, $barangay, $street, $postal_code, $valid_id_front, $valid_id_back);
    }