<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include_once '../../configuration/header.php';
	?>
	<title>PABids | Bids</title>
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
			<li class="active">
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
				}
				else if($seller_data['status'] == "verify"){
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
					<h1>Bids</h1>
					<ul class="breadcrumb">
						<li>
							<a class="active" href="./">Home</a>
						</li>
						<li>|</li>
						<li>
							<a href="">Bids</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="dashboard_data">
                <li>
					<i class='bx bx-dollar-circle'></i>
					<span class="text">
                        <h3>20</h3>
						<p>My Bids</p>
					</span>
				</li>
                <li>
					<i class='bx bx-hourglass'></i>
					<span class="text">
                        <h3>20</h3>
						<p>Pending Bids</p>
					</span>
				</li>
                <li>
					<i class='bx bx-shield-x'></i>
					<span class="text">
                        <h3>20</h3>
						<p>Canceled Bids</p>
					</span>
				</li>
			</ul>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<?php
	include_once '../../configuration/footer.php';
	?>

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