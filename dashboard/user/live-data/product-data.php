<?php
include_once '../header.php';

$stmt = $user->runQuery("
                        SELECT p.*
                        FROM product p
                        WHERE p.user_id <> :user_id
                        AND p.status = :status
                        AND p.product_status <> 'sold'
                        AND NOT EXISTS (
                            SELECT 1
                            FROM bidding b
                            WHERE b.user_id = :user_id
                            AND b.product_id = p.id
                        )
                        ORDER BY p.id DESC
                    ");
$stmt->execute(array(":user_id" => $user_id, ":status" => "active"));

if ($stmt->rowCount() >= 1) {
    while ($product_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($product_data);
        $image_filenames = explode(',', $product_data['product_image']);
        $first_image = reset($image_filenames); // Get the first image filename
?>
        <div class="post">
            <div class="post-header">
                <img src="../../src/img/profile.png" alt="User 1" class="profile-pic">
                <span class="username">Drei_07</span>
                <span class="dot">•</span>
                <span class="time" data-timestamp="<?php echo $product_data['created_at']?>"><?php echo $product_data['created_at']?></span>
            </div>
            <div class="post-img slideshow-item" data-images="<?php echo implode(',', $image_filenames); ?>">
                <img src="../../src/product_images/<?php echo $first_image; ?>" alt="Post 1">
                <div class="image-flow">
                    <?php
                    $imageCount = count($image_filenames);
                    for ($i = 0; $i < $imageCount; $i++) {
                        echo '<span id="indicator-' . $i . '" class="image-flow-indicator" onclick="currentSlide(' . $i . ')"></span>';
                    }
                    ?>
                </div>
                <button class="prev-button"><i class='bx bxs-chevron-left'></i></button>
                <button class="next-button"><i class='bx bxs-chevron-right'></i></button>
            </div>
            <div class="post-actions">
                <div class="left-actions">
                    <span class="like-button"><i class='bx bx-heart'></i></span>
                    <span class="book-mark"><i class='bx bx-bookmark'></i></span>
                </div>
                <span class="price">PHP 1,000</span>
            </div>
            <div class="like-count">
                <p>10,000 likes</p>
            </div>
            <div class="post-description">
                <p>Add a comment...</p>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <h5 class="no-data">No product found</h5>
<?php
}
?>
