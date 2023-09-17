<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include_once '../../configuration/header.php';
	?>
	<title>PABids</title>
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
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a class="active" href="./">Home</a>
						</li>
						<li>|</li>
						<li>
							<a href="">Dashboard</a>
						</li>
					</ul>
				</div>
			</div>

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
				</div>
			</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<?php
	include_once '../../configuration/footer.php';
	?>

	<script>
		function setSessionValues(eventId) {
			fetch('more-info.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'product_id=' + encodeURIComponent(eventId),
				})
				.then(response => {
					window.location.href = "more-info";
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