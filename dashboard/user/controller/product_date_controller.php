<?php
include_once __DIR__ . '/../../../database/dbconfig.php';
include_once '../../../configuration/settings-configuration.php';
require_once '../authentication/user-class.php';

class Products
{
    private $user;

    public function __construct()
    {
        $this->user = new USER();
    }

    public function closeBiddingForExpiredProducts()
    {
        $currentDateTime = date("Y-m-d H:i:s");

        // 1. Fetch products that are still open for bidding
        $stmt = $this->user->runQuery("SELECT * FROM product WHERE bidding_end_date < :currentDateTime AND bidding_status = 'open'");
        $stmt->bindParam(':currentDateTime', $currentDateTime);
        $stmt->execute();
        $productsToClose = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Update the status of these products to 'closed'
        foreach ($productsToClose as $product) {
            $productId = $product['id'];
            $this->closeBiddingForProduct($productId);
        }

        // 3. Notify users about closed bidding
        $this->notifyUsersAboutClosedBidding($productsToClose);

        // 4. Log the execution for monitoring (optional)
        $this->logExecution(count($productsToClose));
    }

    private function closeBiddingForProduct($productId)
    {
        $stmt = $this->user->runQuery("UPDATE product SET bidding_status = 'closed' WHERE id = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
    }

    private function notifyUsersAboutClosedBidding($productsToClose)
    {
        // Implement code to send notifications to users about closed bidding, e.g., by email.
    }

    private function logExecution($closedProductCount)
    {
        $logMessage = "Closed bidding for $closedProductCount products at " . date("Y-m-d H:i:s");
        file_put_contents('bidding_closure.log', $logMessage . PHP_EOL, FILE_APPEND);
    }
}

// Usage
$productsHandler = new Products();
$productsHandler->closeBiddingForExpiredProducts();
?>
