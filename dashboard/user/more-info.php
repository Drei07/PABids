<?php
include_once 'header.php';

// Check if the session value is null, and include the header accordingly
if (empty($_SESSION['product_id'])) {
    include_once 'product';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the values from the POST request
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

    // Store the values in session variables
    $_SESSION['product_id'] = $product_id;
}

// Retrieve the values from session variables
$product_id = isset($_SESSION['product_id']) ? $_SESSION['product_id'] : '';

$stmt = $user->runQuery("SELECT * FROM product WHERE id=:id");
$stmt->execute(array(":id" => $product_id));
$product_data = $stmt->fetch(PDO::FETCH_ASSOC);

$image_filenames = explode(',', $product_data['product_image']);
$first_image = reset($image_filenames); // Get the first image filename


$base_url = '../../src/product_images/'; // Define the base URL for product images

$existing_images_html = ''; // Initialize the HTML string for existing images

foreach ($image_filenames as $filename) {
    // Create the full image URL by concatenating the base URL and filename
    $image_url = $base_url . $filename;

    // Append the HTML for the image to the existing_images_html string
    $existing_images_html .= '<div class="upload__img-box"><div style="background-image: url(' . $image_url . ')" data-filename="' . $filename . '" class="img-bg"><div class="upload__img-close"></div></div></div>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once '../../configuration/header.php';
    ?>
    <title>PABids | Product Details</title>
</head>

<body>

    <!-- Loader -->
    <div class="loader"></div>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="" class="brand">
            <img src="../../src/img/<?php echo $config->getSystemFavicon() ?>" alt="logo">
            <span class="text">PABids<br>
                <p>PAMPANGA ARTISTIC BIDS</p>
            </span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="./">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="bids">
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">Bids</span>
                </a>
            </li>
            <li>
                <a href="product">
                    <i class='bx bxs-cart-alt'></i>
                    <span class="text">Product</span>
                </a>
            </li>
            <?php
            if (empty($seller_data['status']) || $seller_data['status'] == "not_verify") {

            ?>
                <li>
                    <a href="on-boarding">
                        <i class='bx bxs-store-alt'></i>
                        <span class="text">Start Selling</span>
                    </a>
                </li>
            <?php
            } else if ($seller_data['status'] == "verify") {
            ?>
            <?php
            }
            ?>
            <li>
                <a href="my-favorite">
                    <i class='bx bxs-star'></i>
                    <span class="text">My Favorite</span>
                </a>
            </li>
            <li>
                <a href="my-rating">
                    <i class='bx bxs-bar-chart-alt-2'></i>
                    <span class="text">My Rating</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu top">
            <li>
                <a href="authentication/user-signout" class="btn-signout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Signout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <div class="username">
                <span>Hello, <label for=""><?php echo $user_fname ?></label></span>
            </div>
            <a href="profile" class="profile" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Profile">
                <img src="../../src/img/<?php echo $user_profile ?>">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Product Details</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="./">Home</a>
                        </li>
                        <li>|</li>
                        <li>
                            <a href="">Product Details</a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="events-details">
                <li class="slideshow-item" data-images="<?php echo implode(',', $image_filenames); ?>">
                    <img src="../../src/product_images/<?php echo $first_image ?>" alt="">
                    <div class="details">
                        <h1><?php echo $product_data['product_name'] ?></h1>
                        <p><strong>Product No:</strong> #<?php echo $product_data['product_number'] ?></p>
                        <p><strong>Product Description:</strong> PHP <?php echo $product_data['product_description'] ?></p>
                        <p><strong>Starting Bidding Amount:</strong> PHP <?php echo number_format($product_data['product_price'], 0, '.', ',') ?></p>
                        <p><strong>Bidding Start Date/Time: </strong> <?php echo  date('m/d/y h:i A', strtotime($product_data['bidding_start_date'])); ?></p>
                        <p><strong>Bidding End Date/Time: </strong> <?php echo  date('m/d/y h:i A', strtotime($product_data['bidding_end_date'])); ?></p>
                        <div class="action">
                            <?php
                            $stmt = $user->runQuery("SELECT * FROM favorite WHERE user_id=:user_id AND product_id=:product_id");
                            $stmt->execute(array(":user_id" => $_SESSION['userSession'], ":product_id" => $product_id));

                            if ($stmt->rowCount() >= 1) { ?>

                            <?php } else { ?>
                                <button type="button" class="btn btn-success"><a href="controller/product-controller?id=<?php echo $product_data['id'] ?>&favorite_product=1" class="favorite"><i class='bx bxs-heart-circle'></i> Save</a></button>
                            <?php } ?>


                            <?php
                            $stmt = $user->runQuery("SELECT * FROM bidding WHERE user_id=:user_id AND product_id=:product_id");
                            $stmt->execute(array(":user_id" => $_SESSION['userSession'], ":product_id" => $product_id));

                            if ($product_data['bidding_status'] == "open") {
                                if ($stmt->rowCount() >= 1) {
                                    $bidding_data = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                                    <h2><strong>Your Bid:</strong> PHP <?php echo number_format($bidding_data['bid_price'], 0, '.', ',') ?></h2>
                                <?php } else { ?>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#classModal" class="btn btn-primary"><a><i class='bx bxs-dollar-circle'></i> Place your Bid</a></button>
                                <?php }
                            } else { ?>
                                <h2 style="color: red;"><strong>Bidding Status : </strong> Closed</h2>
                            <?php } ?>

                        </div>
                    </div>
                </li>
            </ul>
        </main>
        <!-- MAIN -->

        <div class="class-modal">
            <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="header"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="classModalLabel"><i class='bx bxs-dollar-circle'></i> Place your Bid</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <section class="data-form-modals">
                                <div class="registration">
                                    <form action="controller/product-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" enctype="multipart/form-data" novalidate style="overflow: hidden;">
                                        <div class="row gx-5 needs-validation">
                                            <input type="hidden" value="<?php echo $product_id ?>" name="product_id">
                                            <input type="hidden" value="<?php echo $product_data['product_price'] ?>" name="product_price">

                                            <?php
                                            $stmt = $user->runQuery("SELECT MAX(bid_price) as highest_bid FROM bidding WHERE product_id=:product_id");
                                            $stmt->execute(array(":product_id" => $product_id));
                                            $current_highest_bid = $stmt->fetch(PDO::FETCH_ASSOC);

                                            ?>
                                            <input type="hidden" value="<?php echo $current_highest_bid['highest_bid'] ?>" name="highest_bid">


                                            <div class="col-md-12">
                                                <label for="product_bidd_price" class="form-label">Enter your Bid<span> (Note: Please Enter the amount higher than <?php echo number_format($product_data['product_price'], 0, '.', ',') ?> or current high bid)</span></label>
                                                <label for="product_bidd_price" class="form-label">CURRENT HIGH BID: ₱<?php echo number_format($current_highest_bid['highest_bid'], 0, '.', ',') ?></label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">₱</span>
                                                    <input type="text" class="form-control numbers" autocapitalize="off" inputmode="numeric" autocomplete="off" name="product_bid_price" id="product_bid_price" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="addBtn">
                                            <button type="submit" class="btn-dark" name="btn-place-bid" id="btn-add" onclick="return IsEmpty(); sexEmpty();">Place My Bid</button>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- CONTENT -->

    <?php
    include_once '../../configuration/footer.php';
    ?>

    <script>
        $(document).ready(function() {
            $(".slideshow-item").each(function() {
                var listItem = $(this);
                var imageFilenames = listItem.data("images").split(",");
                var currentIndex = 0;
                var slideshowDelay = 2000; // 2 seconds

                function showNextImage() {
                    listItem.find("img").attr("src", "../../src/product_images/" + imageFilenames[currentIndex]);

                    currentIndex = (currentIndex + 1) % imageFilenames.length;

                    setTimeout(showNextImage, slideshowDelay);
                }

                showNextImage();
            });
        });

        editImgUpload('<?php echo $existing_images_html; ?>');
    </script>
    <!-- SWEET ALERT -->
    <?php

    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['status_title']; ?>",
                text: "<?php echo $_SESSION['status']; ?>",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                button: false,
                timer: <?php echo $_SESSION['status_timer']; ?>,
            });
        </script>
    <?php
        unset($_SESSION['status']);
    }
    ?>
</body>

</html>