<?php
include_once 'header.php';

$seller_id = $_GET['id'];

$stmt = $user->runQuery("SELECT * FROM seller WHERE id=:id");
$stmt->execute(array(":id" => $seller_id));
$seller_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once '../../configuration/header.php';
    ?>
    <title>Seller Verification</title>
</head>

<body>

    <div class="class-modal">
        <div class="modal fade" id="editModal" aria-labelledby="classModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="header"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="classModalLabel"><i class='bx bxs-store-alt'></i> Seller Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="history.back()"></button>
                    </div>
                    <div class="modal-body">
                        <section class="data-form-modals">
                            <div class="registration">
                                <form action="controller/seller-controller.php?id=<?php echo $seller_id ?>" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
                                    <div class="row gx-5 needs-validation">
                                    <div class="col-md-12">
												<label for="shop_name" class="form-label">Shop Name</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" name="shop_name" value="<?php echo $seller_data['shop_name']?>" id="shop_name" required>
												<div class="invalid-feedback">
													Please provide a Shop Name.
												</div>
											</div>

											<div class="col-md-12">
												<label for="email" class="form-label">Email</label>
												<input type="email" disabled class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['email'] ?>" required>
												<div class="invalid-feedback">
													Please provide a Email.
												</div>
											</div>

											<div class="col-md-12">
												<label for="phone_number" class="form-label">Phone Number</label>
												<div class="input-group flex-nowrap">
													<span class="input-group-text" id="addon-wrapping">+63</span>
													<input type="text" disabled class="form-control numbers" autocapitalize="off" inputmode="numeric" autocomplete="off" value="<?php echo $seller_data['phone_number'] ?>" required minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="10-digit number">
												</div>
											</div>
											

											<legend>Address Information</legend>

                                            <div class="col-md-6">
												<label for="phone_number" class="form-label">Region</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['region'] ?>" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>
                                            <div class="col-md-6">
												<label for="phone_number" class="form-label">Province</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['province'] ?>" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>
                                            <div class="col-md-6">
												<label for="phone_number" class="form-label">City / Municipality</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['municipality'] ?>" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>
                                            <div class="col-md-6">
												<label for="phone_number" class="form-label">Barangay</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['barangay'] ?>" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>

											<div class="col-md-6">
												<label for="street" class="form-label">Street (Optional)</label>
												<input disabled type="text" class="form-control" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['province'] ?>" name="street" id="street">
												<div class="invalid-feedback">
													Please provide a Street.
												</div>
											</div>

											<div class="col-md-6">
												<label for="postal_code" class="form-label">Postal Code</label>
												<input disabled type="text" class="form-control numbers"  inputmode="numeric" autocapitalize="on" autocomplete="off" value="<?php echo $seller_data['postal_code'] ?>" name="postal_code" id="postal_code" required>
												<div class="invalid-feedback">
													Please provide a Postal Code.
												</div>
											</div>

                                            <legend>Documents</legend>

                                            <div class="col-md-12">
                                                <label for="postal_code" class="form-label">Front ID</label>
                                                <img src="../../src/valid_id/<?php echo $seller_data['valid_id_front'] ?>" alt="" style="max-width: 50%; margin-top: 10px;">
											</div>

                                            <div class="col-md-12">
                                                <label for="postal_code" class="form-label">Back ID</label>
                                                <img src="../../src/valid_id/<?php echo $seller_data['valid_id_back'] ?>" alt="" style="max-width: 50%; margin-top: 10px;">
											</div>

                                    </div>

                                    <div class="addBtn">
                                        <button type="submit" class="btn-danger" name="btn-decline-seller" id="btn-add" onclick="return IsEmpty(); sexEmpty();">Decline</button>
                                        <button type="submit" class="btn-success" name="btn-accept-seller" id="btn-add" onclick="return IsEmpty(); sexEmpty();">Accept</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once '../../configuration/footer.php';
    ?>
    <script>
        //Load Modal
        $(window).on('load', function() {
            $('#editModal').modal('show');
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