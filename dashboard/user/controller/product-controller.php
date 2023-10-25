<?php
include_once '../../../configuration/settings-configuration.php';
include_once __DIR__ . '/../../../database/dbconfig.php';
require_once '../authentication/user-class.php';


// Create a new class for handling product insertion
class Products
{
    private $user;
    private $main_url;
    private $smtp_email;
    private $smtp_password;
    private $system_name;


    public function __construct()
    {
        $this->user = new USER();
        $this->main_url = $this->user->mainUrl();
        $this->smtp_email = $this->user->smtpEmail();
        $this->smtp_password = $this->user->smtpPassword();
        $this->system_name = $this->user->systemName();
    }
    public function addProduct($user_id, $product_name, $product_description, $product_price, $bidding_start_date, $bidding_end_date, $product_images)
    {
        // Generate a unique product_number
        $product_number = $this->generateProductNumber();
        $product_price_in_php = number_format($product_price, 0, '.', ',');

        // Get the seller's email
        $seller_data = $this->getUserData($user_id);
        $seller_email = $seller_data['email'];

        // Get seller's details
        $seller_user_data = $this->getSellerData($user_id);
        $seller_name = $seller_data['first_name'] . ' ' . $seller_data['last_name'];
        $seller_address = $this->getFormattedSellerAddress($seller_user_data);
        $seller_contact_number = $seller_data['phone_number'];
        $product_url = "https://pabids.store/dashboard/user/";

        // Get emails of all users except the seller
        $user_emails = $this->getAllUserEmailsExceptSeller($seller_email);

        // Handle product insertion and image filenames
        $image_filenames = [];

        if (isset($product_images) && is_array($product_images['tmp_name'])) {
            foreach ($product_images['tmp_name'] as $key => $tmp_name) {
                $file_name = $product_images['name'][$key];
                $file_size = $product_images['size'][$key];
                $file_tmp = $product_images['tmp_name'][$key];

                // Check if the file is an image (you can add more image file types as needed)
                $file_info = pathinfo($file_name);
                $valid_extensions = array("jpg", "jpeg", "png", "gif");

                if (in_array(strtolower($file_info['extension']), $valid_extensions)) {
                    $new_file_name = uniqid() . "." . strtolower($file_info['extension']);
                    $target_dir = "../../../src/product_images/";
                    $target_file = $target_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $image_filenames[] = $new_file_name;
                    }
                }
            }
        }

        // Insert product data and image filenames into the database
        $stmt = $this->user->runQuery('INSERT INTO product (user_id, product_name, product_price, product_description, bidding_start_date, bidding_end_date, product_image, product_number) VALUES (:user_id, :product_name, :product_price, :product_description, :bidding_start_date, :bidding_end_date, :product_image, :product_number)');

        $image_filenames_str = implode(",", $image_filenames); // Convert image filenames to a comma-separated string

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_description', $product_description);
        $stmt->bindParam(':bidding_start_date', $bidding_start_date);
        $stmt->bindParam(':bidding_end_date', $bidding_end_date);
        $stmt->bindParam(':product_image', $image_filenames_str);
        $stmt->bindParam(':product_number', $product_number);

        try {
            if ($stmt->execute()) {
                foreach ($user_emails as $email) {
                    // Create and send the email
                    $message =
                        "
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <meta charset='UTF-8'>
                                <title>New Product</title>
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
                                    <h1>New Product Added</h1>
                                    <p>We are excited to inform you that a new product has been added to our platform:</p><br>
                                    <p>Product Name: $product_name</p>
                                    <p>Product Number: #$product_number</p>
                                    <p>Product Description: $product_description</p>
                                    <p>Product Price: PHP $product_price_in_php</p><br>
                    
                                    <p>Seller Name: $seller_name</p>
                                    <p>Seller Address: $seller_address</p><br>
                                    <p>Seller Contact Number: +63$seller_contact_number</p>
                    
                                    <p>This is a great opportunity to explore our latest offerings. Click the button below to view the product:</p>
                                    <a href='$product_url' class='button'>View Product</a><br>
                            
                                    <p>Thank you for being a valued member of our platform. We look forward to serving you with more exciting products in the future.</p><br>
                    
                                </div>
                            </body>
                            </html>
                            ";
                    $subject = "New Product Added: $product_name";
                    $this->user->send_mail($email, $message, $subject, $this->smtp_email, $this->smtp_password, $this->system_name);
                }
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Product successfully added!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            $_SESSION['status_title'] = 'Database Error';
            $_SESSION['status'] = 'An error occurred while adding the product. Please try again later.';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product');
    }

    public function editProduct($product_id, $product_name, $product_description, $product_price, $bidding_start_date, $bidding_end_date, $product_images)
    {
        // Handle product image filenames
        $image_filenames = [];

        if (isset($product_images) && is_array($product_images['tmp_name'])) {
            foreach ($product_images['tmp_name'] as $key => $tmp_name) {
                $file_name = $product_images['name'][$key];
                $file_size = $product_images['size'][$key];
                $file_tmp = $product_images['tmp_name'][$key];

                // Check if the file is an image (you can add more image file types as needed)
                $file_info = pathinfo($file_name);
                $valid_extensions = array("jpg", "jpeg", "png", "gif");

                if (in_array(strtolower($file_info['extension']), $valid_extensions)) {
                    $new_file_name = uniqid() . "." . strtolower($file_info['extension']);
                    $target_dir = "../../../src/product_images/";
                    $target_file = $target_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $image_filenames[] = $new_file_name;
                    }
                }
            }
        }

        // Update product data and image filenames in the database
        $stmt = $this->user->runQuery('UPDATE product SET product_name = :product_name, product_price = :product_price, product_description = :product_description, bidding_start_date = :bidding_start_date, bidding_end_date = :bidding_end_date, product_image = :product_image WHERE id = :id');

        $image_filenames_str = implode(",", $image_filenames); // Convert image filenames to a comma-separated string

        $stmt->bindParam(':id', $product_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_description', $product_description);
        $stmt->bindParam(':bidding_start_date', $bidding_start_date);
        $stmt->bindParam(':bidding_end_date', $bidding_end_date);
        $stmt->bindParam(':product_image', $image_filenames_str);

        if ($stmt->execute()) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Successfully updated the product!';
            $_SESSION['status_code'] = 'Product updated!';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }
        header('Location: ../product-details');
    }


    private function generateProductNumber()
    {
        // Generate a unique product_number
        $product_number = rand(1000000000, 9999999999);

        // Check if the product_number already exists in the database
        $stmt = $this->user->runQuery('SELECT COUNT(*) FROM product WHERE product_number = :product_number');
        $stmt->execute(array(":product_number" => $product_number));
        $count = $stmt->fetchColumn();

        // If the product_number is not unique, regenerate it
        while ($count > 0) {
            $product_number = rand(1000000000, 9999999999);
            $stmt->execute(array(":product_number" => $product_number));
            $count = $stmt->fetchColumn();
        }

        return $product_number;
    }

    public function removeProduct($product_id, $status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET status=:status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"        => $product_id,
            ":status"   => $status,
        ));

        if ($exec) {
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Product successfully remove!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product');
        exit();
    }

    public function activateProduct($product_id, $status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET status=:status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"        => $product_id,
            ":status"   => $status,
        ));

        if ($exec) {
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Product successfully activate!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product-archive');
        exit();
    }

    public function closeBidding($product_id, $bidding_status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET bidding_status=:bidding_status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"        => $product_id,
            ":bidding_status"   => $bidding_status,
        ));

        if ($exec) {
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Bidding is now officially closed!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product-details');
        exit();
    }

    public function openBidding($product_id, $bidding_status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET bidding_status=:bidding_status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"        => $product_id,
            ":bidding_status"   => $bidding_status,
        ));

        if ($exec) {
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'Bidding is now officially opened!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product-details');
        exit();
    }

    public function markSoldProduct($product_id, $product_status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET product_status=:product_status WHERE id=:id');
        $exec = $stmt->execute(array(
            ":id"        => $product_id,
            ":product_status"   => $product_status,
        ));

        if ($exec) {
            if ($exec) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'This product is now sold!';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../product');
        exit();
    }

    public function placeBidd($user_id, $product_id, $product_price, $product_bid_price, $highest_bid)
    {
        // Check if the user has already placed a bid for this product
        if ($this->hasUserPlacedBid($user_id, $product_id)) {
            // User has already placed a bid for this product, show an error message
            $_SESSION['status_title'] = 'Error!';
            $_SESSION['status'] = 'You have already placed a bid on this product.';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        } elseif ($product_bid_price > $product_price && $product_bid_price > $highest_bid) {
            // User has not placed a bid for this product, and bid price is valid

            $stmt = $this->user->runQuery('INSERT INTO bidding (user_id, product_id, bid_price) VALUES (:user_id, :product_id, :bid_price)');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':bid_price', $product_bid_price);

            if ($stmt->execute()) {
                $_SESSION['status_title'] = 'Success!';
                $_SESSION['status'] = 'You have successfully placed your bid! We will notify you via email if you win the bid. Thank you for using PintaDukit.';
                $_SESSION['status_code'] = 'success';
                $_SESSION['status_timer'] = 40000;
            } else {
                $_SESSION['status_title'] = 'Oops!';
                $_SESSION['status'] = 'Something went wrong, please try again!';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_timer'] = 100000;
            }
        } else {
            // Bidding price is not higher than the product price or current high bid, show an error message
            $_SESSION['status_title'] = 'Error!';
            $_SESSION['status'] = 'Your bid price must be higher than the product price and the current high bid.';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }

        header('Location: ../more-info');
    }

    // Function to check if the user has already placed a bid for a specific product
    private function hasUserPlacedBid($user_id, $product_id)
    {
        $stmt = $this->user->runQuery("SELECT COUNT(*) FROM bidding WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0;
    }


    public function addtoFavorites($product_id, $user_id)
    {
        $stmt = $this->user->runQuery('INSERT INTO favorite (user_id, product_id) VALUES (:user_id, :product_id)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Successfully add to your Favorites!';
            $_SESSION['status_code'] = 'Product updated!';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
        }
        header('Location: ../my-favorite');
    }

    public function removeFromFavorites($product_id, $user_id)
    {
        $stmt = $this->user->runQuery('UPDATE favorite SET status=:status WHERE product_id=:product_id AND user_id = :user_id');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':user_id', $user_id);

        $status = "disabled"; // Set the status value

        if ($stmt->execute()) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Successfully removed from your Favorites!';
            $_SESSION['status_code'] = 'success'; // Set the status code to 'success'
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error'; // Set the status code to 'error'
            $_SESSION['status_timer'] = 100000;
        }
        header('Location: ../my-favorite');
    }

    public function cancelBids($bidding_id, $user_id)
    {
        $stmt = $this->user->runQuery('UPDATE bidding SET status=:status WHERE id=:bidding_id AND user_id = :user_id');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':bidding_id', $bidding_id);
        $stmt->bindParam(':user_id', $user_id);

        $status = "disabled"; // Set the status value

        if ($stmt->execute()) {
            $_SESSION['status_title'] = 'Success!';
            $_SESSION['status'] = 'Successfully cancel your bid!';
            $_SESSION['status_code'] = 'success'; // Set the status code to 'success'
            $_SESSION['status_timer'] = 40000;
        } else {
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error'; // Set the status code to 'error'
            $_SESSION['status_timer'] = 100000;
        }
        header('Location: ../bids');
    }

    public function selectBiddingWinner($product_id)
    {
        // Query to get the highest bid price for the product
        $stmt = $this->user->runQuery("SELECT MAX(bid_price) as max_bid_price FROM bidding WHERE product_id=:product_id AND status=:status");
        // Define the parameters as variables
        $product_id = $product_id;
        $status = "active"; // Assuming status is a string

        // Use these variables in the bindParam method
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT); // Assuming product_id is an integer
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        $max_bid_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($max_bid_data && isset($max_bid_data['max_bid_price'])) {
            $max_bid_price = $max_bid_data['max_bid_price'];

            $bidd_amount = number_format($max_bid_data['max_bid_price'], 0, '.', ',');


            // Update bid_status for the highest bidder as 'winner'
            $this->updateBidStatusForWinner($product_id, $max_bid_price);

            // Update bid_status for all other users as 'loss'
            $this->updateBidStatusForLoss($product_id, $max_bid_price);

            // Fetch user data for the winner
            $winner_user_id = $this->getWinnerUserId($product_id);
            $user_data = $this->getUserData($winner_user_id);
            $email = $user_data['email'];
            $user_name = $user_data['first_name'] . ' ' . $user_data['last_name'];

            // Fetch product data
            $product_data = $this->getProductData($product_id);
            $product_seller_id = $product_data['user_id'];
            $product_name = $product_data['product_name'];
            $product_number = $product_data['product_number'];

            // Fetch seller data
            $seller_data = $this->getSellerData($product_seller_id);
            $seller_id = $seller_data['user_id'];
            $seller_address = $this->getFormattedSellerAddress($seller_data);
            $seller_contact_number = $seller_data['phone_number'];

            // Fetch seller user data
            $seller_user_data = $this->getUserData($seller_id);
            $seller_name = $seller_user_data['first_name'] . ' ' . $seller_user_data['last_name'];

            $message =
                "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Congratulations</title>
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
                    <p>Hello <strong>$user_name</strong>,</p>
                    <p>We are excited to inform you that you have won the bidding for the following item:</p><br>
                    <p>Product Name: $product_name</p>
                    <p>Product Number: #$product_number</p>
                    <p>Your Bid Amount: PHP $bidd_amount</p><br>

                    <p>Seller Name: $seller_name</p>
                    <p>Seller Address: $seller_address</p><br>
                    <p>Seller Contact Number: +63$seller_contact_number</p>


                    <p>Congratulations on your successful bid! We will now proceed with the following steps:</p><br>

                    <p><strong>Payment:</strong></p>
                    <ul>
                        <li>Please make the payment for the winning bid amount of PHP $bidd_amount.</li>
                        <li>Payment must be made within 5 days to secure your purchase.</li>
                    </ul>

                    <p><strong>Contact Information:</strong></p>
                    <ul>
                        <li>Please ensure your contact details are up to date for smooth communication.</li>
                    </ul>
                                    
                    <p>Thank you for participating in our bidding process. We appreciate your business and look forward to delivering your winning item.</p><br>

                </div>
            </body>
            </html>
            ";
            $subject = "Bidding for item #$product_number";

            $this->user->send_mail($email, $message, $subject, $this->smtp_email, $this->smtp_password, $this->system_name);
            $this->soldProduct($product_id, 'sold');
            $this->closeBidProduct($product_id, 'closed');

            $_SESSION['status_title'] = "Success!";
            $_SESSION['status'] = "An email will sent to the winner of this bidding! Thank you for using PintaDukit.";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_timer'] = 40000;
            header('Location: ../product');
            exit;
        } else {
            // Handle the case where no bidding data was found
            $_SESSION['status_title'] = 'Oops!';
            $_SESSION['status'] = 'Something went wrong, please try again!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_timer'] = 100000;
            header('Location: ../product-details');
        }
    }

    // Helper function to get user data by ID
    private function getUserData($user_id)
    {
        $stmt = $this->user->runQuery("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getAllUserEmailsExceptSeller($seller_email)
    {
        $user_emails = [];

        $stmt = $this->user->runQuery("SELECT email FROM users WHERE email != :seller_email");
        $stmt->bindParam(':seller_email', $seller_email, PDO::PARAM_STR);

        try {
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user_emails[] = $row['email'];
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }

        return $user_emails;
    }


    // Helper function to get product data by ID
    private function getProductData($product_id)
    {
        $stmt = $this->user->runQuery("SELECT * FROM product WHERE id=:id");
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Helper function to get seller data by user ID
    private function getSellerData($user_id)
    {
        $stmt = $this->user->runQuery("SELECT * FROM seller WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Helper function to format seller address
    private function getFormattedSellerAddress($seller_data)
    {
        return $seller_data['street'] . ', ' . $seller_data['barangay'] . ', ' . $seller_data['municipality'] . ', ' . $seller_data['province'] . ', ' . $seller_data['region'] . ', ' . $seller_data['postal_code'];
    }

    public function soldProduct($product_id, $product_status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET product_status=:product_status WHERE id=:id');
        $stmt->execute(array(
            ":id"        => $product_id,
            ":product_status"   => $product_status,
        ));
    }

    public function closeBidProduct($product_id, $bidding_status)
    {
        $stmt = $this->user->runQuery('UPDATE product SET bidding_status=:bidding_status WHERE id=:id');
        $stmt->execute(array(
            ":id"        => $product_id,
            ":bidding_status"   => $bidding_status,
        ));
    }

    // Add a function to update bid_status for the highest bidder as 'winner'
    private function updateBidStatusForWinner($product_id, $max_bid_price)
    {
        $stmt = $this->user->runQuery('UPDATE bidding SET bid_status=:bid_status WHERE product_id=:product_id AND bid_price=:max_bid_price');
        $stmt->execute(array(
            ":product_id" => $product_id,
            ":max_bid_price" => $max_bid_price,
            ":bid_status" => 'winner'
        ));
    }

    // Add a function to update bid_status for all other users as 'loss'
    private function updateBidStatusForLoss($product_id, $max_bid_price)
    {
        $stmt = $this->user->runQuery('UPDATE bidding SET bid_status=:bid_status WHERE product_id=:product_id AND bid_price!=:max_bid_price');
        $stmt->execute(array(
            ":product_id" => $product_id,
            ":max_bid_price" => $max_bid_price,
            ":bid_status" => 'loss'
        ));
    }

    // Add a function to get the user ID of the highest bidder
    private function getWinnerUserId($product_id)
    {
        $stmt = $this->user->runQuery("SELECT user_id FROM bidding WHERE product_id=:product_id AND bid_status='winner'");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $winner_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $winner_data['user_id'];
    }
}

// Add Product
if (isset($_POST['btn-add-product'])) {
    $user_id       = $_SESSION['userSession'];
    $product_name = trim($_POST['product_name']);
    $product_description = trim($_POST['product_description']);
    $product_price = trim($_POST['product_price']);
    $bidding_start_date = trim($_POST['bidding_start_date']);
    $bidding_end_date = trim($_POST['bidding_end_date']);
    $product_images = $_FILES['product_images'];

    $add_product = new Products();
    $add_product->addProduct($user_id, $product_name, $product_description, $product_price, $bidding_start_date, $bidding_end_date, $product_images);
}

// edit Product
if (isset($_POST['btn-edit-product'])) {
    $product_id = trim($_POST['product_id']);
    $product_name = trim($_POST['product_name']);
    $product_price = trim($_POST['product_price']);
    $bidding_start_date = trim($_POST['bidding_start_date']);
    $bidding_end_date = trim($_POST['bidding_end_date']);
    $product_images = $_FILES['product_images'];

    $edit_product = new Products();
    $edit_product->editProduct($product_id, $product_name, $product_description, $product_price, $bidding_start_date, $bidding_end_date, $product_images);
}

//remove
if (isset($_GET['remove_product'])) {
    $product_id = $_GET["id"];
    $status = "disabled";

    $remove_product = new Products();
    $remove_product->removeProduct($product_id, $status);
}

//activate
if (isset($_GET['activate_product'])) {
    $product_id = $_GET["id"];
    $status = "active";

    $activate_product = new Products();
    $activate_product->activateProduct($product_id, $status);
}

//close bidding
if (isset($_GET['close_bidding_product'])) {
    $product_id = $_GET["id"];
    $bidding_status = "closed";

    $close_bidding_product = new Products();
    $close_bidding_product->closeBidding($product_id, $bidding_status);
}

//open bidding
if (isset($_GET['open_bidding_product'])) {
    $product_id = $_GET["id"];
    $bidding_status = "open";

    $open_bidding_product = new Products();
    $open_bidding_product->openBidding($product_id, $bidding_status);
}

//sold
if (isset($_GET['mark_as_sold_product'])) {
    $product_id = $_GET["id"];
    $product_status = "sold";

    $mark_as_sold_product = new Products();
    $mark_as_sold_product->markSoldProduct($product_id, $product_status);
}

//place_bidd
if (isset($_POST['btn-place-bid'])) {
    $user_id       = $_SESSION['userSession'];
    $product_id = trim($_POST['product_id']);
    $product_price = trim($_POST['product_price']);
    $product_bid_price = trim($_POST['product_bid_price']);
    $highest_bid = trim($_POST['highest_bid']);


    $place_bid = new Products();
    $place_bid->placeBidd($user_id, $product_id, $product_price, $product_bid_price, $highest_bid);
}

//favorite
if (isset($_GET['favorite_product'])) {
    $product_id = $_GET["id"];
    $user_id  = $_SESSION['userSession'];

    $favorite_product = new Products();
    $favorite_product->addtoFavorites($product_id, $user_id);
}

if (isset($_GET['remove_favorite_product'])) {
    $product_id = $_GET["id"];
    $user_id  = $_SESSION['userSession'];

    $remove_favorite_product = new Products();
    $remove_favorite_product->removeFromFavorites($product_id, $user_id);
}

if (isset($_GET['cancel_bid'])) {
    $bidding_id = $_GET["id"];
    $user_id  = $_SESSION['userSession'];

    $cancel_bids = new Products();
    $cancel_bids->cancelBids($bidding_id, $user_id);
}

// //favorite
// if (isset($_POST["product_id"]) && isset($_POST["user_id"])) {
//     $product_id = $_POST["product_id"];
//     $user_id = $_POST["user_id"];

//     $favorite_product = new Products();
//     $favorite_product->addtoFavorites($product_id, $user_id);
// }

//select bidding winner
if (isset($_GET['select_bidding_winner'])) {
    $product_id = $_GET["product_id"];

    $select_bidding_winner = new Products();
    $select_bidding_winner->selectBiddingWinner($product_id);
}
