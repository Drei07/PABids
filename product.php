<?php
require_once __DIR__ . '/database/dbconfig2.php';
include_once 'configuration/settings-configuration.php';

$config = new SystemConfig();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="src/img/<?php echo $config->getSystemFavicon() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="src/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="src/css/landing-page.css?v=<?php echo time(); ?>">
    <title>PintaDukit | Product</title>

</head>
<style>

/* post */

#content main .table-data {
    display: flex;
    flex-wrap: wrap;
    grid-gap: 24px;
    margin-top: 24px;
    width: 100%;
    color: #0000;
}
  /* events poster */
  #content main .table-data  .box-info {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
	grid-gap: 24px;
	margin-top: 36px;
}
#content main .table-data  .box-info li {
	border-radius: 5px;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	width: 180px;
	grid-gap: 19px;
	background-color: transparent;
	margin: 0 auto;

}

#content main .table-data  .box-info li:hover {
	box-shadow: none;
}
#content main .table-data .box-info li img {
	width: 180px;
	height: 210px;
	border-radius: 10px;
	font-size: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
	
}
#content main .table-data  .box-info li img:hover{
	box-shadow: 7px 5px 10px 1px rgba(0, 0, 0, 0.242);
}
#content main .box-info li .bx {
	width: 180px;
	height: 210px;
	border-radius: 10px;
	font-size: 90px;
	display: flex;
	background: #eee;
	color: #AAAAAA;	justify-content: center;
	align-items: center;
}
#content main .table-data  .box-info li  h4 {
	font-size: 12px;
	font-weight: 600;
	color: #0000;
	letter-spacing: normal;
	height: 40px;
	margin-top: 20px;
	text-align: center;

}
#content main .table-data  .box-info li  p {
	font-size: 11px;
	color: #0000;	
}

#content main .table-data  .box-info li .more {
	padding: 9px;
	border: none;
	letter-spacing: 1.5px;
	width: 90px;
	border-radius: 7px;
	font-weight: 600;
	font-size: 9px;
	
}

/* event details */
#content main .events-details {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
	grid-gap: 24px;
	margin-top: 36px;

}
#content main .events-details li {
	padding: 30px;
	background: var(--light);
	border-radius: 10px;
	display: flex;
	align-items: center;
	cursor: pointer;
	grid-gap: 24px;
	margin: 0 auto;

}

#content main .events-details li:hover {
	box-shadow: 7px 5px 10px 1px rgba(0,0,0,0.15);
}

#content main .events-details li img {
	width: 260px;
	height: 380px;
	border-radius: 10px;
	font-size: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
	
}
#content main .events-details li .details {
	padding: 40px;
	display: block;
	justify-content: flex-start;
	align-items: flex-start;
}
#content main .events-details li .details h1{
	font-size: 20px;
	font-weight: 700;
	text-align: left;
	padding: 10px 10px 10px 0px;
	font-family: inherit;
	text-transform: uppercase;

}
#content main .events-details li .details h2{
	font-size: 17px;
	font-weight: 700;
	text-align: left;
	padding: 10px 10px 10px 0px;
	font-family: inherit;
	color: var(--green);
}

#content main .events-details li .details p{
	padding: 10px 10px 10px 0px;
	font-size: 13px;
	text-align: left;

}

#content main .events-details li .details p strong{
	font-size:15px;
}

#content main .events-details li .details .action .btn {
	padding: 10px 10px;
	width: 170px;
	border: none;
	border-radius: 7px;
	font-weight: 550;
	font-size: 15px;
	margin-right: 20px;	
	margin-bottom: 20px;
}

#content main .events-details li .details .action .btn a{
	text-decoration: none;
	color: var(--light);
}

#content main .events-details li .details .action .btn2 {
	padding: 10px 25px;
	width: 100%;
	border: none;
	border-radius: 7px;
	font-weight: 550;
	font-size: 15px;
	margin-right: 20px;	
	margin-bottom: 20px;
}

#content main .events-details li .details .action .btn2 a{
	text-decoration: none;
	color: var(--light);
}

@media screen and (max-width: 900px){
	#content main .events-details li {
		flex-direction: column;
		justify-content: center;
		align-items: center;

	}
	#content main .events-details li .details {
		padding: 10px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	#content main .events-details li .details h1{
		font-size: 18px;
		font-weight: 700;
		text-align: center;
	}
	#content main .events-details li .details p{
		text-align: center;
	}
	#content main .events-details li .details .action .btn {
		margin-bottom: 20px;
		margin-right: 0px;
		width: 100%;

	}
	#content main .events-details li .details .action .btn2 {
		margin-bottom: 20px;
		margin-right: 0px;
		width: 100%;

	}
}
@media screen and (max-width: 500px){
	#content main .events-details li img {
		width: 200px;
		height: 320px;
		
	}


}

@media screen and (max-width: 400px){
	#content main .table-data .box-info {
		grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));

	}
	#content main .table-data  .box-info li {
		align-items: center;
		justify-content: center;
		width: 140px;
	
	}

	#content main .table-data .box-info li img {
		width: 140px;
		height: 200px;
	}

	#content main .box-info li .bx{
		width: 140px;
		height: 200px;
		font-size: 60px;
	}

}

/* post */

.post {
	margin: 20px auto;
	max-width: 400px;
	padding: 10px;
	border-bottom: 1px solid #AAAAAA;
}

.post .post-header {
	display: flex;
	align-items: center;
	margin-bottom: 10px;
}

.post .profile-pic {
	width: 35px;
	height: 35px;
	border-radius: 50%;
}

.post .username {
	font-weight: bold;
	font-size: 12px;
	margin-left: 7px;
}

.post .dot{
	font-weight: bold;
	font-size: 12px;
	margin-left: 4px;
	margin-right: 4px;
	color: #727272;
}

.post .time{
	font-weight: bold;
	font-size: 12px;
	color: #727272;
}
.post .post-img {
	background-color: black;
	height:450px;
	border-radius: 5px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
.post .post-img img{
	max-width: 375px;
	max-height: 450px;
	min-width: 300px;
	min-height: 450px;
}

.post .post-actions {
	margin-top: 10px;
	text-align: left;
	display: flex;
    justify-content: space-between;
    align-items: center;
}


.post .left-actions {
    display: flex; /* Create a nested flex container for like-button and book-mark */
}

.post .view-post{
	background-color:blue;
	padding: 5px 10px;
	border-radius: 5px;
	border: none;
	color: white;
	margin-right: 4px;
	font-size: 13px;
}

.post .like-button {
	color: black;
}
.post .like-button .bx{
	font-size: 30px;
	cursor: pointer;
}
.post .like-button .bx:hover{
	color: #AAAAAA;
}

.post .book-mark {
	color: black;
	margin-left: 7px;
}
.post .book-mark .bx{
	font-size: 30px;
	cursor: pointer;
}
.post .book-mark .bx:hover{
	color: #AAAAAA;
}

.post .price{
    order: 3; /* This moves the "price" span to the right */
	font-size: 15px;
	font-weight: bold;

}

.post .like-count p{
	text-align: left;
	font-size: 15px;
	padding-top: 10px;
	font-weight: bold;
}
.post .post-description {
	text-align: left;
	margin-top: 10px;
	font-size: 12px;
	color: #AAAAAA;

}

/* Style for the image slider container */
.slideshow-item {
    position: relative;
    text-align: center;
}

/* Style for the image */
.slideshow-item img {
    max-width: 100%;
    height: auto;
}

/* Style for the "Previous" and "Next" buttons */
.prev-button,
.next-button {
    position: absolute;
	font-size: 35px;
	font-weight: 600;
	color:#eee;
	opacity: .8;
	background-color: transparent;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Style for the "Previous" button */
.prev-button {
    left: 10px;
}

/* Style for the "Next" button */
.next-button {
    right: 10px;
}

.image-flow {
    display: flex;
    justify-content: center;
    align-items: baseline;
	position: absolute;
    bottom: 20px; /* Position it at the bottom */
    width: 100%; /* Make it stretch across the entire width */
}

.image-flow-indicator {
    width: 8px;
    height: 8px;
    background-color: #bbbbbb75;
    border-radius: 50%;
    margin: 0 6px; /* Adjust the margin to control spacing between indicators */
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Style the active indicator */
.image-flow-indicator.active {
    background-color: rgb(211, 211, 211); /* Change to your desired active color */
}

</style>
<body>

    <header>

        <a href="" id="logo" class="delete"><img src="src/img/pabids-logo.png" alt="pabids"></a>
        <input type="checkbox" id="menu-bar">
        <label for="menu-bar" class="fas fa-bars"></label>

        <nav class="navbar">
            <a href="./" id="navbar">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="product" id="navbar">Products</a></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="about-us" id="navbar">About us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="signin" id="signin">Sign in</a>
        </nav>
    </header>
    <!-- Live queue Modal -->
    <section style="margin-bottom: 20rem;margin-top: 5rem; min-height: 90vh;">
        <main>
            <div class="table-data">
                <div class="order">
                    <section class="data-table">
                        <?php

                            $pdoQuery = "
								SELECT p.*
								FROM product p
								WHERE p.status = :status
								AND p.product_status <> 'sold'
								AND NOT EXISTS (
									SELECT 1
									FROM bidding b
									WHERE b.product_id = p.id
								)
								ORDER BY p.id DESC
							";
                            $pdoResult = $pdoConnect->prepare($pdoQuery);
                            $pdoExec = $pdoResult->execute(array(":status" => "active"));

                        if ($pdoResult->rowCount() >= 1) {
                            while ($product_data = $pdoResult->fetch(PDO::FETCH_ASSOC)) {
                                extract($product_data);
                                $image_filenames = explode(',', $product_data['product_image']);
                                $first_image = reset($image_filenames); // Get the first image filename


                                $pdoQuery = "SELECT * FROM users WHERE id=:id";
                                $pdoResult2 = $pdoConnect->prepare($pdoQuery);
                                $pdoExec2 = $pdoResult2->execute(array(":id" => $product_data['user_id']));
                                $user_data = $pdoResult2->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="post">
                                    <div class="post-header">
                                        <img src="src/img/<?php echo $user_data['profile'] ?>" alt="User 1" class="profile-pic">
                                        <span class="username"><?php echo $user_data['first_name'] ?></span>
                                        <span class="dot">•</span>
                                        <span class="time" data-timestamp="<?php echo $product_data['created_at'] ?>"><?php echo $product_data['created_at'] ?></span>
                                    </div>
                                    <div class="post-img slideshow-item" data-images="<?php echo implode(',', $image_filenames); ?>">
                                        <img src="src/product_images/<?php echo $first_image; ?>" alt="Post 1">
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
                                            <button class="view-post" data-bs-toggle="modal" data-bs-target="#pre-registration2" class="btn" >Bid Now!</button>
                                        </div>
                                        <span class="price">PHP <?php echo number_format($product_data['product_price'], 0, '.', ',') ?></span>
                                    </div>
                                    <div class="like-count">
                                        <p>Product No. #<?php echo $product_data['product_number'] ?></p>
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
    </section>

    <div class="pre-registration-modal">
        <div class="modal fade" id="pre-registration" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="" id="logo"><img src="src/img/pabids-logo.png" alt="PintaDukit" style="width: 100px;"></a>
                        <a href="" class="close" data-bs-dismiss="modal" aria-label="Close"><img src="src/img/caret-right-fill.svg" alt="close-btn" width="24" height="24"></a>
                    </div>
                    <div class="modal-body">
                        <div class="form-alert">
                            <span id="message"></span>
                        </div>
                        <form action="dashboard/user/controller/registration-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
                            <div class="row gx-5 needs-validation">
                                <input type="hidden" id="g-token" name="g-token">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="first_name" required>
                                    <div class="invalid-feedback">
                                        Please provide a First Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" name="middle_name" id="middle_name">
                                    <div class="invalid-feedback">
                                        Please provide a Middle Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" name="last_name" id="last_name" required>
                                    <div class="invalid-feedback">
                                        Please provide a Last Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">Phone No. <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></span></label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">+63</span>
                                        <input type="text" class="form-control numbers" inputmode="numeric" autocapitalize="off" autocomplete="off" name="phone_number" id="phone_number" minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required placeholder="eg. 9776621929">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span><span style="font-size: 10px; color: red;">(valid email)</span></label>
                                    <input type="email" class="form-control" autocapitalize="off" autocomplete="off" name="email" id="email" required placeholder="Ex. juan@email.com">
                                    <div class="invalid-feedback">
                                        Please provide a valid Email.
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="primary" name="btn-registration" id="btn-registration" onclick="return IsEmpty(); sexEmpty();">Submit</button>
                            </div>
                        </form>
                        <div class="terms">
                            <p>By registering, you will agree to the following <a href="" data-bs-toggle="modal" data-bs-target="#terms">Terms & Conditions</a> of PintaDukit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Pre-Registration Modal -->

    <div class="pre-registration-modal">
        <div class="modal fade" id="pre-registration2" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="" id="logo"><img src="src/img/pabids-logo.png" alt="PintaDukit" style="width: 100px;"></a>
                        <a href="" class="close" data-bs-dismiss="modal" aria-label="Close"><img src="src/img/caret-right-fill.svg" alt="close-btn" width="24" height="24"></a>
                    </div>
                    <div class="modal-body">
                        <div class="form-alert">
                            <span id="message"></span>
                            <h1 style="color: red; font-weight:bold;">Oopss! you need to register first to place your bid, Thank you.</h1>
                        </div>
                        <form action="dashboard/user/controller/registration-controller.php" method="POST" class="row gx-5 needs-validation" name="form" onsubmit="return validate()" novalidate style="overflow: hidden;">
                            <div class="row gx-5 needs-validation">
                                <input type="hidden" id="g-token" name="g-token">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" name="first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="first_name" required>
                                    <div class="invalid-feedback">
                                        Please provide a First Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" name="middle_name" id="middle_name">
                                    <div class="invalid-feedback">
                                        Please provide a Middle Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></label>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" autocapitalize="on" maxlength="15" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" name="last_name" id="last_name" required>
                                    <div class="invalid-feedback">
                                        Please provide a Last Name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">Phone No. <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span></span></label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">+63</span>
                                        <input type="text" class="form-control numbers" inputmode="numeric" autocapitalize="off" autocomplete="off" name="phone_number" id="phone_number" minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required placeholder="eg. 9776621929">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email <span style="font-size:17px; margin-top: 2rem; color:red; opacity:0.8;">*</span><span style="font-size: 10px; color: red;">(valid email)</span></label>
                                    <input type="email" class="form-control" autocapitalize="off" autocomplete="off" name="email" id="email" required placeholder="Ex. juan@email.com">
                                    <div class="invalid-feedback">
                                        Please provide a valid Email.
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="primary" name="btn-registration" id="btn-registration" onclick="return IsEmpty(); sexEmpty();">Register</button>
                            </div>
                        </form>
                        <div class="terms">
                        <p>By registering, you will agree to the following <a href="" data-bs-toggle="modal" data-bs-target="#terms">Terms & Conditions</a> of PintaDukit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Pre-Registration Modal -->


    <footer>

        <div class="pre-registration">
            <h3>REGISTERED NOW!<br>
                <p>Elevate Your Art Experience with PintaDukit</p>
            </h3>
            <a href="#" data-bs-toggle="modal" data-bs-target="#pre-registration" class="btn">Register</a>

        </div>
        <h1 class="credit"> <?php echo $config->getSystemCopyright() ?></h1>
    </footer>
    <button id="scrollToTop" onclick="scrolltop();"><img src="src/img/icons8-slide-up-30.png"></button>

    <script src="src/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="src/js/landing-page.js"></script>
    <script src="src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>
        //navbar----------------------------------------------------------------------------------------------------->
        var navbar = document.querySelector('header')

        window.onscroll = function() {
            if (window.pageYOffset > 0) {
                navbar.classList.add('header-active')
            } else {
                navbar.classList.remove('header-active')
            }
        };


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
                listItem.find("img").attr("src", "src/product_images/" + imageFilenames[currentIndex]);
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