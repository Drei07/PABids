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
					<section class="data-table">
						<div class="searchBx">
							<input type="text" id="search-product-number" placeholder="Search Product No. . . . . . ." class="search">
							<button class="searchBtn" type="button" onclick="searchProduct()"><i class="bx bx-search icon"></i></button>
						</div>
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


								$stmt2 = $user->runQuery("SELECT * FROM users WHERE id=:id");
								$stmt2->execute(array(":id" => $product_data['user_id']));
								$user_data = $stmt2->fetch(PDO::FETCH_ASSOC);
						?>
								<div class="post">
									<div class="post-header">
										<img src="../../src/img/<?php echo $user_data['profile'] ?>" alt="User 1" class="profile-pic">
										<span class="username"><?php echo $user_data['first_name'] ?></span>
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
											<button class="view-post" onclick="setSessionValues(<?php echo $product_data['id'] ?>)">View Post</button>
										</div>
										<span class="price">PHP <?php echo number_format($product_data['product_price'], 0, '.', ',') ?></span>
									</div>
									<div class="like-count">
										<p>Product No. #<?php  echo $product_data['product_number']?></p>
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

    function updateRelativeTime() {
        const timestampElements = document.querySelectorAll('.time[data-timestamp]');

        timestampElements.forEach((element) => {
            const timestamp = new Date(element.getAttribute('data-timestamp'));
            const now = new Date();

            const timeDifferenceInSeconds = Math.floor((now - timestamp) / 1000);

            if (timeDifferenceInSeconds < 60) {
                element.textContent = timeDifferenceInSeconds + ' seconds ago';
            } else if (timeDifferenceInSeconds < 3600) {
                const minutes = Math.floor(timeDifferenceInSeconds / 60);
                element.textContent = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
            } else if (timeDifferenceInSeconds < 86400) {
                const hours = Math.floor(timeDifferenceInSeconds / 3600);
                element.textContent = hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
            } else {
                const days = Math.floor(timeDifferenceInSeconds / 86400);
                element.textContent = days + ' day' + (days > 1 ? 's' : '') + ' ago';
            }
        });
    }

    // Call the function initially and set up an interval to update the relative time every minute
    updateRelativeTime();
    setInterval(updateRelativeTime, 60000); // Update every minute


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
				var initialImageSrc = listItem.find("img").attr("src");

				// Function to show the current image
				function showCurrentImage() {
					listItem.find("img").attr("src", "../../src/product_images/" + imageFilenames[currentIndex]);
				}

				// Show the first image initially
				showCurrentImage();

				// Function to show the next image
				function showNextImage() {
					currentIndex = (currentIndex + 1) % imageFilenames.length;
					showCurrentImage();
					updateIndicators();
				}

				// Function to show the previous image
				function showPrevImage() {
					currentIndex = (currentIndex - 1 + imageFilenames.length) % imageFilenames.length;
					showCurrentImage();
					updateIndicators();
				}

				// Function to update the indicators
				function updateIndicators() {
					$(".image-flow-indicator").removeClass("active");
					$("#indicator-" + currentIndex).addClass("active");
				}

				// Event listener for next button click
				listItem.find(".next-button").on("click", function() {
					showNextImage();
				});

				// Event listener for previous button click
				listItem.find(".prev-button").on("click", function() {
					showPrevImage();
				});

				// Initialize indicators
				updateIndicators();
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