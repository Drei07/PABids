<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include_once '../../configuration/header.php';
	?>
	<title>PABids | Products</title>
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
					<h1>Product</h1>
					<ul class="breadcrumb">
						<li>
							<a class="active" href="./">Home</a>
						</li>
						<li>|</li>
						<li>
							<a href="">Product</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="dashboard_data">
				<li onclick="location.href='product'">
					<i class='bx bx-cart-alt'></i>
					<span class="text">
						<?php

						$stmt = $user->runQuery("SELECT * FROM product WHERE user_id=:user_id AND product_status = :product_status AND status = :status");
						$stmt->execute(array(":user_id" => $user_id, ":product_status" => "not_sold", ":status" => "active"));
						$product_count = $stmt->rowCount();

						echo
						"
									<h3>$product_count</h3>
								";
						?>
						<p>My Products</p>
					</span>
				</li>
				<li onclick="location.href='product-sold'">
					<i class='bx bx-wallet-alt' ></i>
					<span class="text">
						<?php

						$stmt = $user->runQuery("SELECT * FROM product WHERE user_id=:user_id AND product_status = :product_status AND status = :status");
						$stmt->execute(array(":user_id" => $user_id, ":product_status" => "sold", ":status" => "active"));
						$product_sold_count = $stmt->rowCount();

						echo
						"
									<h3>$product_sold_count</h3>
								";
						?>
						<p>Products Sold</p>
					</span>
				</li>
				<li onclick="location.href='product-archive'">
					<i class='bx bx-archive'></i>
					<span class="text">
						<?php

						$stmt = $user->runQuery("SELECT * FROM product WHERE user_id=:user_id AND status = :status");
						$stmt->execute(array(":user_id" => $user_id, ":status" => "disabled"));
						$product_archive_count = $stmt->rowCount();

						echo
						"
									<h3>$product_archive_count</h3>
								";
						?>
						<p>Archive Products</p>
					</span>
				</li>
				<li data-bs-toggle="modal" data-bs-target="#classModal">
					<i class='bx bx-cart-add'></i>
					<span class="text">
						<p>Add New Products</p>
					</span>
				</li>
			</ul>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3><i class='bx bxs-cart'></i>Product List</h3>
					</div>
					<!-- BODY -->
					<section class="data-table">
						<div class="searchBx">
							<input type="text" id="search-product-number" placeholder="Search Product No. . . . . . ." class="search">
							<button class="searchBtn" type="button" onclick="searchProduct()"><i class="bx bx-search icon"></i></button>
						</div>
						<ul class="box-info" id="product">
							<?php
							$stmt = $user->runQuery("SELECT * FROM product WHERE user_id=:user_id AND product_status = :product_status AND status = :status ORDER BY id DESC");
							$stmt->execute(array(":user_id" => $user_id, ":product_status" => "not_sold", ":status" => "active"));

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
							}
							?>

							<li data-bs-toggle="modal" data-bs-target="#classModal">
								<i class='bx bxs-cart-add'></i>
							</li>
						</ul>
					</section>
				</div>
			</div>

		</main>

		<div class="class-modal">
			<div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="header"></div>
						<div class="modal-header">
							<h5 class="modal-title" id="classModalLabel"><i class='bx bxs-cart-add'></i> Add Products</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<section class="data-form-modals">
								<div class="registration">
									<form action="controller/product-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" enctype="multipart/form-data" novalidate style="overflow: hidden;">
										<div class="row gx-5 needs-validation">
											<div class="col-md-12">
												<label for="product_name" class="form-label">Product Name<span> *</span></label>
												<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="product_name" id="product_name" required>
												<div class="invalid-feedback">
													Please provide a Product Name.
												</div>
											</div>

											<div class="col-md-12">
												<label for="product_description" class="form-label">Product Description</label>
												<textarea class="form-control" autocapitalize="on" autocomplete="off" name="product_description" id="product_description" rows="4" cols="40"></textarea>
												<div class="invalid-feedback">
													Please provide a Product Description.
												</div>
											</div>

											<div class="col-md-12">
												<label for="product_price" class="form-label">Starting Bidding Amount<span> *</span></label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">₱</span>
													<input type="text" class="form-control numbers" autocapitalize="off" inputmode="numeric" autocomplete="off" name="product_price" id="product_price" required>
												</div>
											</div>

											<div class="col-md-12">
												<label for="bidding_start_date" class="form-label">Bidding Start Date/Time<span> *</span></label>
												<input type="datetime-local" class="form-control" autocomplete="off" name="bidding_start_date" id="bidding_start_date" required>
												<div class="invalid-feedback">
													Please provide a Start Date.
												</div>
											</div>

											<div class="col-md-12">
												<label for="bidding_end_date" class="form-label">Bidding End Date/Time<span> *</span></label>
												<input type="datetime-local" class="form-control" autocomplete="off" name="bidding_end_date" id="bidding_end_date" required>
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
												<div class="upload__img-wrap"></div>
											</div>

										</div>

										<div class="addBtn">
											<button type="submit" class="btn-dark" name="btn-add-product" id="btn-add" onclick="return IsEmpty(); sexEmpty();">Add</button>
										</div>
									</form>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="class-modal">
			<div class="modal fade" id="notregisteredModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="btn-close" onclick="goBack()" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<section class="data-form-modals">
								<div class="registration">
									<div class="welcome">
										<img src="../../src/img/Sales-consulting.svg" alt="">
										<h1>Oops! You Need to Register as Seller!</h1>
										<p>To get started, register as a seller by providing the necessary information.</p>
										<button type="button" onclick="location.href='on-boarding'" class="registration btn-dark"></i> Start Registration</button>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<?php
	include_once '../../configuration/footer.php';
	?>

	<script>
		window.onload = function() {
			// Check if seller_data is empty or status is "not_verify"
			<?php if (empty($seller_data['status']) || $seller_data['status'] == "not_verify") { ?>
				// Show the modal when conditions are met
				$('#notregisteredModal').modal('show');
			<?php } ?>
		};


		function setSessionValues(eventId) {
			fetch('product-details.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'product_id=' + encodeURIComponent(eventId),
				})
				.then(response => {
					window.location.href = 'product-details';
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}

		function searchProduct() {
			var searchInput = document.getElementById('search-product-number').value.trim();
			var eventItems = document.querySelectorAll('#product li');

			eventItems.forEach(function(item) {
				var eventName = item.querySelector('p').innerText;

				if (eventName.toLowerCase().includes(searchInput.toLowerCase())) {
					item.style.display = 'block';
				} else {
					item.style.display = 'none';
				}
			});

			var noResultsMsg = document.getElementById('no-results-msg-mandatory');
			if (document.querySelectorAll('#product li[style="display: block;"]').length === 0) {
				noResultsMsg.style.display = 'block';
			} else {
				noResultsMsg.style.display = 'none';
			}

			if (searchInput === '') {
				eventItems.forEach(function(item) {
					item.style.display = 'block';
				});
				noResultsMsg.style.display = 'none';
			}
		}

		$(document).ready(function() {
			$(".slideshow-item").each(function() {
				var listItem = $(this);
				var imageFilenames = listItem.data("images").split(",");
				var currentIndex = 0;
				var slideshowDelay = 1000; // 2 seconds
				var intervalId; // To store the interval ID
				var initialImageSrc = listItem.find("img").attr("src"); // Store the initial image src

				// Function to show the next image
				function showNextImage() {
					listItem.find("img").attr("src", "../../src/product_images/" + imageFilenames[currentIndex]);
					currentIndex = (currentIndex + 1) % imageFilenames.length;
				}

				// Start slideshow on mouseenter
				listItem.on("mouseenter", function() {
					showNextImage(); // Show the first image immediately
					intervalId = setInterval(showNextImage, slideshowDelay); // Start slideshow
				});

				// Stop slideshow and return to initial image on mouseleave
				listItem.on("mouseleave", function() {
					clearInterval(intervalId); // Stop the slideshow
					listItem.find("img").attr("src", initialImageSrc); // Return to the initial image
				});
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