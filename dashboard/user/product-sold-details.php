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
            <li>
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
            <li class="active">
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
                            <a class="active" href="product">Product</a>
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
                        <?php if ($product_data['status'] == 'active') { ?>
                            <div class="action">
                                <!-- product Status -->
                                <?php
                                if ($product_data['product_status'] == "not_sold") { ?>
                                    <button type="button" class="btn btn-primary"><a href="controller/product-controller?id=<?php echo $product_data['id'] ?>&mark_as_sold_product=1" class="sold"><i class='bx bxs-purchase-tag-alt'></i> Mark as Sold</button><br>

                                <?php
                                } else if ($product_data['product_status'] == "sold") { ?>
                                    <button type="button" class="btn btn-secondary"><a><i class='bx bxs-purchase-tag-alt'></i> Sold</a></button><br>

                                <?php
                                }
                                ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#classModal" class="btn btn-info"><a><i class='bx bxs-edit'></i> Edit</a></button>
                                <button type="button" class="btn btn-danger"><a href="controller/product-controller?id=<?php echo $product_data['id'] ?>&remove_product=1" class="remove"><i class='bx bxs-trash'></i> Remove</a></button>
                            </div>
                        <?php } else if ($product_data['status'] == 'disabled') { ?>
                            <div class="action">
                                <!-- product Status -->
                                <?php
                                if ($product_data['product_status'] == "not_sold") { ?>
                                    <button type="button" class="btn btn-primary"><a href="controller/product-controller?id=<?php echo $product_data['id'] ?>&mark_as_sold_product=1" class="sold"><i class='bx bxs-purchase-tag-alt'></i> Mark as Sold</button><br>

                                <?php
                                } else if ($product_data['product_status'] == "sold") { ?>
                                    <button type="button" class="btn btn-secondary"><a href=""><i class='bx bxs-purchase-tag-alt'></i> Sold</a></button><br>

                                <?php
                                }
                                ?>
                                <button type="button" class="btn btn-success"><a href="controller/product-controller?id=<?php echo $product_data['id'] ?>&activate_product=1" class="activate"><i class='bx bxs-check-circle'></i> Activate</a></button>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3><i class='bx bxs-dollar-circle'></i> Bidding Result</h3>
                    </div>
                    <!-- BODY -->
                    <section class="data-table">
                        <div class="info-data">
                            <?php
                            $stmt = $user->runQuery("SELECT * FROM bidding WHERE product_id=:product_id ORDER BY bid_price DESC LIMIT 5");
                            $stmt->execute(array(":product_id" => $product_id));

                            $counter = 1; // Initialize the counter

                            if ($stmt->rowCount() >= 1) {
                            ?>
                                <div class="header">
                                    <h1><i class='bx bxs-trophy'></i> TOP 5 HIGHEST BIDS</h1>
                                </div>
                                <?php
                                while ($product_bidding_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($product_bidding_data);

                                    $stmt2 = $user->runQuery("SELECT * FROM users WHERE id=:id");
                                    $stmt2->execute(array(":id" => $product_bidding_data['user_id']));
                                    $user_data = $stmt2->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <div class="card">
                                        <div class="head2">
                                            <div class="number">
                                                <p><?php echo $counter; ?></p> <!-- Display the counter value -->
                                            </div>
                                            <div class="body">
                                                <img src="../../src/img/<?php echo $user_data['profile'] ?>" alt="department_logo">
                                                <h2>PHP <?php echo number_format($product_bidding_data['bid_price'], 0, '.', ',') ?><br>
                                                    <label for=""><?php echo $user_data['first_name'], ' ', $user_data['last_name'] ?></label>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $counter++; // Increment the counter
                                }
                                ?>
                            <?php
                            } else {
                            ?>
                                <h1 class="no-data">No Bid Found</h1>
                            <?php
                            }
                            ?>
                        </div>
                    </section>

                </div>
            </div>
        </main>
        <!-- MAIN -->

        <div class="class-modal">
            <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="header"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="classModalLabel"><i class='bx bxs-cart-add'></i> Edit Products</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <section class="data-form-modals">
                                <div class="registration">
                                    <form action="controller/product-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" enctype="multipart/form-data" novalidate style="overflow: hidden;">
                                        <div class="row gx-5 needs-validation">
                                            <input type="hidden" value="<?php echo $product_id ?>" name="product_id">
                                            <div class="col-md-12">
                                                <label for="product_name" class="form-label">Product Name<span> *</span></label>
                                                <input type="text" class="form-control" value="<?php echo $product_data['product_name'] ?>" autocapitalize="on" autocomplete="off" name="product_name" id="product_name" required>
                                                <div class="invalid-feedback">
                                                    Please provide a Product Name.
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="product_description" class="form-label">Product Description</label>
                                                <textarea class="form-control" autocapitalize="on" value="<?php echo $product_data['product_description'] ?>" autocomplete="off" name="product_description" id="product_description" rows="4" cols="40"><?php echo $product_data['product_description'] ?></textarea>
                                                <div class="invalid-feedback">
                                                    Please provide a Product Description.
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="product_price" class="form-label">Starting Bidding Amount<span> *</span></label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping">₱</span>
                                                    <input type="text" class="form-control numbers" value="<?php echo $product_data['product_price'] ?>" autocapitalize="off" inputmode="numeric" autocomplete="off" name="product_price" id="product_price" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="bidding_start_date" class="form-label">Bidding Start Date/Time<span> *</span></label>
                                                <input type="datetime-local" class="form-control" value="<?php echo $product_data['bidding_start_date'] ?>" autocomplete="off" name="bidding_start_date" id="bidding_start_date" required>
                                                <div class="invalid-feedback">
                                                    Please provide a Start Date.
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="bidding_end_date" class="form-label">Bidding End Date/Time<span> *</span></label>
                                                <input type="datetime-local" class="form-control" value="<?php echo $product_data['bidding_end_date'] ?>" autocomplete="off" name="bidding_end_date" id="bidding_end_date" required>
                                                <div class="invalid-feedback">
                                                    Please provide an End Date.
                                                </div>
                                            </div>

                                            <div class="upload__box">
                                                <div class="upload__btn-box">
                                                    <label class="upload__btn">
                                                        <p>Upload Product Images</p>
                                                        <input type="file" name="product_images[]" id="product_images" multiple="" data-max_length="20" class="upload__inputfile" required>
                                                    </label>
                                                </div>
                                                <div class="upload__img-wrap">

                                                </div>
                                            </div>

                                        </div>

                                        <div class="addBtn">
                                            <button type="submit" class="btn-dark" name="btn-edit-product" id="btn-add" onclick="return IsEmpty(); sexEmpty();">Submit</button>
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

        //live search---------------------------------------------------------------------------------------//
        $(document).ready(function() {

            load_data(1);

            function load_data(page, query = '') {
                $.ajax({
                    url: "tables/course-table.php",
                    method: "POST",
                    data: {
                        page: page,
                        query: query
                    },
                    success: function(data) {
                        $('#dynamic_content').html(data);
                    }
                });
            }

            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                var query = $('#search_box').val();
                load_data(page, query);
            });

            $('#search_box').keyup(function() {
                var query = $('#search_box').val();
                load_data(1, query);
            });

        });
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