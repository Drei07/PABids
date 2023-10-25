<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include_once '../../configuration/header.php';
	?>
	<title>PintaDukit Selling Center</title>

</head>

<body>

	<!-- Loader -->
	<div class="loader"></div>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="" class="brand">
			<img src="../../src/img/<?php echo $config->getSystemFavicon() ?>" alt="logo">
			<span class="text">PintaDukit<br>
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
				<a href="product">
					<i class='bx bxs-cart-alt'></i>
					<span class="text">Product</span>
				</a>
			</li>
			<li class="active">
				<a href="on-boarding">
					<i class='bx bxs-store-alt'></i>
					<span class="text">Start Selling</span>
				</a>
			</li>
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
					<h1>Seller Registration</h1>
					<ul class="breadcrumb">
						<li>
							<a class="active" href="./">Home</a>
						</li>
						<li>|</li>
						<li>
							<a href="">Registration</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<?php
						if (empty($seller_data['status'])) {
					?>
						<div class="welcome">
							<img src="../../src/img/Sales-consulting.svg" alt="">
							<h1>Welcome to PintaDukit!</h1>
							<p>To get started, register as a seller by providing the necessary information.</p>
							<button type="button" data-bs-toggle="modal" data-bs-target="#classModal" class="registration btn-dark"></i> Start Registration</button>
						</div>
					</div>
					<?php
						}else if($seller_data['status'] == "not_verify"){
					?>
						<div class="welcome">
							<img src="../../src/img/Push notifications-rafiki.svg" alt="">
							<h1>Thank you for Registration!</h1>
							<p>We will notify you via email once your information has been verified. Thank you for your cooperation.</p>
						</div>
					<?php
						}else if($seller_data['status'] == "verify"){
							header('Location: ./');
							exit;
						}
					?>
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
							<h5 class="modal-title" id="classModalLabel"><i class='bx bxs-store-alt'></i> Seller Registration</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<section class="data-form-modals">
								<div class="registration">
									<form action="controller/registration-controller" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" enctype="multipart/form-data" novalidate style="overflow: hidden;">
										<div class="row gx-5 needs-validation">

											<input hidden type="text" name="user_id" value="<?php echo $user_id?>">
											<input hidden type="text" name="email" value="<?php echo $user_email?>">
											<input hidden type="text" name="phone_number" value="<?php echo $user_phone_number?>">

											
											<div class="col-md-12">
												<label for="shop_name" class="form-label">Shop Name<span> *</span></label>
												<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="shop_name" id="shop_name" required>
												<div class="invalid-feedback">
													Please provide a Shop Name.
												</div>
											</div>

											<div class="col-md-12">
												<label for="email" class="form-label">Email<span> *</span></label>
												<input type="email" disabled class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $user_email ?>" required>
												<div class="invalid-feedback">
													Please provide a Email.
												</div>
											</div>

											<div class="col-md-12">
												<label for="phone_number" class="form-label">Phone Number<span> *</span></label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">+63</span>
													<input type="text" disabled class="form-control numbers" autocapitalize="off" inputmode="numeric" autocomplete="off" value="<?php echo $user_phone_number ?>" required minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="10-digit number">
												</div>
											</div>
											

											<legend>Address Information</legend>

											<div class="col-sm-6 mb-3">
												<label class="form-label">Region<span> *</span></label>
												<select name="region" class="form-control form-control-md" id="region" required></select>
												<input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
											</div>

											<div class="col-sm-6 mb-3">
												<label class="form-label">Province<span> *</span></label>
												<select name="province" class="form-control form-control-md" id="province" required></select>
												<input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
											</div>

											<div class="col-sm-6 mb-3">
												<label class="form-label">City / Municipality<span> *</span></label>
												<select name="municipality" class="form-control form-control-md" id="city" required></select>
												<input type="hidden" class="form-control form-control-md" name="municipality_text" id="municipality-text" required>
											</div>

											<div class="col-sm-6 mb-3">
												<label class="form-label">Barangay<span> *</span></label>
												<select name="barangay" class="form-control form-control-md" id="barangay" required></select>
												<input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
											</div>

											<div class="col-md-6">
												<label for="street" class="form-label">Street (Optional)</label>
												<input type="text" class="form-control" autocapitalize="on" autocomplete="off" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>

											<div class="col-md-6">
												<label for="postal_code" class="form-label">Postal Code<span> *</span></label>
												<input type="text" class="form-control numbers"  inputmode="numeric" autocapitalize="on" autocomplete="off" name="postal_code" id="postal_code" required>
												<div class="invalid-feedback">
													Please provide a Postal Code.
												</div>
											</div>

											<legend>Documents</legend>

											<div class="col-md-12">
												<label for="valid_id_front" class="form-label">Valid Id (front view)<span> *</span></label>
												<input type="file" class="form-control"  name="valid_id_front" id="valid_id_front" style="height: 33px ;" required  onchange="previewImage(event)">
												<div class="invalid-feedback">
													Please provide a Valid Id.
												</div>
											</div>

											<div class="col-md-12">
												<label for="event_poster" class="form-label">Preview</label>
												<img id="poster-preview" style="max-width: 50%; margin-top: 10px; display: none;">
											</div>

											<div class="col-md-12">
												<label for="valid_id_back" class="form-label">Valid Id (Back view)<span> *</span></label>
												<input type="file" class="form-control"  name="valid_id_back" id="valid_id_back" style="height: 33px ;" required  onchange="previewImage2(event)">
												<div class="invalid-feedback">
													Please provide a Valid Id.
												</div>
											</div>

											<div class="col-md-12">
												<label for="event_poster" class="form-label">Preview</label>
												<img id="poster-preview2" style="max-width: 50%; margin-top: 10px; display: none;">
											</div>
										</div>

										<div class="addBtn">
											<button type="submit" class="btn-dark" name="btn-seller-registration" id="btn-seller-registration" onclick="return IsEmpty(); sexEmpty();">Submit</button>
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