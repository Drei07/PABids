<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../src/node_modules/boxicons/css/boxicons.min.css">
    <title>Instagram News Feed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

    <div class="post">
        <div class="post-header">
            <img src="src/img/profile.png" alt="User 1" class="profile-pic">
            <span class="username">Drei_07</span>
            <span class="dot">•</span>
            <span class="time"> 15h</span>
        </div>
        <div class="post-img">
        <img src="src/product_images/beautiful-Painting-Home-Decor-before-the-celebration-Colorful-oil-paintings-Canvas-Abstract-Fine-Art-High-quality.jpeg" alt="Post 1">
        </div>
        <div class="post-actions">
            <span class="like-button"><i class='bx bx-heart'></i></span>
            <span class="comment-button">💬 5 comments</span>
        </div>
        <div class="post-description">
            <p>This is a sample post on Instagram.</p>
        </div>
    </div>

    <!-- More posts go here -->
    <section class="data-table">
						<div class="searchBx">
							<input type="text" id="search-product-number" placeholder="Search Product No. . . . . . ." class="search">
							<button class="searchBtn" type="button" onclick="searchProduct()"><i class="bx bx-search icon"></i></button>
						</div>
						<ul class="box-info" id="product">
							<?php
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

									<li onclick="setSessionValues(<?php echo $product_data['id'] ?>)" class="slideshow-item" data-images="<?php echo implode(',', $image_filenames); ?>">
										<img src="../../src/product_images/<?php echo $first_image; ?>" alt="">
										<h4><?php echo $product_data['product_name'] ?></h4>
										<p>#Product No. <?php echo $product_data['product_number'] ?></p>
										<button type="button" onclick="setSessionValues(<?php echo $product_data['id'] ?>)" class="more btn-warning">More Info</button>
									</li>

								<?php
								}
							} else {
							?>
                                <h5 class="no-data">No product found</h5>
							<?php
							}
							?>
						</ul>

					</section>
</body>
</html>
