<?php
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
    <link rel="stylesheet" href="src/css/landing-page.css?v=<?php echo time(); ?>">
    <title>PABids</title>

</head>

<body>

    <header>

    <a href="" id="logo" class="delete"><img src="src/img/pabids-logo.png" alt="pabids"></a>
        <input type="checkbox" id="menu-bar">
        <label for="menu-bar" class="fas fa-bars"></label>

        <nav class="navbar">
            <a href="" id="navbar">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" id="navbar">Products</a></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="about-us" id="navbar">About us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="signin"  id="signin">Sign in</a>

        </nav>
    </header>
    <!-- Live queue Modal -->
    <section class="home" id="homes">
        <div class="content">
            <h3>WELCOME TO PABids<span> Your Gateway to Pampanga's Art Scene</span></h3>
            <p>Our transparent and secure bidding system empowers you to engage with art in a dynamic way. With every bid, you're not just participating; you're shaping the destiny of exceptional artworks. Join our community of passionate bidders and become a part of the art legacy.</p>
            <a href="" class="btn" data-bs-toggle="modal" data-bs-target="#pre-registration">Register Now!</a>
        </div>&nbsp;&nbsp;

        <div class="image">
            <img src="src/img/Auction-pana.svg" alt="Auction">
        </div>
    </section>
    <section class="covid" id="cov">

        <h1 class="heading" data-aos-once="false"> Join the <span>PABids</span> Community Today, Your Trusted Art Auction Partner </h1>

        <div class="column" id="column1">

            <div class="image">
                <img src="src/img/Mobile login-pana.svg" alt="enter-otp">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/icons8-otp-64.png"></object>
                    <h3>Register for an Account</h3>
                </div>
                <p data-aos="fade-in">On the PABids website's homepage, you should see "Register." Click on this option to complete the registration form by providing your valid email address.</p>
            </div>

        </div>
        <div class="column" id="column2">

            <div class="image">
                <img src="src/img/Exploring-cuate.svg" alt="access-token">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/icons8-access-50.png"></object>
                    <h3>Explore the Auctions</h3>
                </div>
                <p data-aos="fade-in">Once you've registered and set up your profile, you can start exploring the art auctions available on PABids. Browse through the listings to find artwork that interests you.</p>
            </div>

        </div>
        <div class="column" id="column3">

            <div class="image">
                <img src="src/img/Auction-amico.svg" alt="choose-event">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/icons8-events-58.png"></object>
                    <h3>Place Bids</h3>
                </div>
                <p data-aos="fade-in">If you find an artwork you'd like to bid on, follow the instructions provided on the auction listing to place your bids. Typically, you'll need to specify your bid amount.</p>
            </div>


        </div>
        <div class="column" id="column4">

            <div class="image">
                <img src="src/img/Auction-bro.svg" alt="get-ticket">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/icons8-ticket-64.png"></object>
                    <h3>Participate in Auctions</h3>
                </div>
                <p data-aos="fade-in">Attend auctions or participate in online bidding, depending on the format offered by PABids. You may need to follow specific bidding rules and guidelines provided for each auction.</p>
            </div>

        </div>
        <div class="column" id="column5">

            <div class="image">
                <img src="src/img/Winners-cuate.svg" alt="Barcode-scanning">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/icons8-barcode-reader-50.png"></object>
                    <h3>Winning and Payment</h3>
                </div>
                <p data-aos="fade-in">
                If you win an auction, follow the platform's instructions for payment and completing the transaction. Be sure to provide accurate payment information and follow any deadlines for payment.</p>
            </div>

        </div>
        <div class="column" id="column6">

            <div class="image">
                <img src="src/img//Art lover-pana.svg" alt="chat-customers.svg">
            </div>

            <div class="content">
                <div class="ic">
                    <object data="src/img/enjoy-event-icon.png"></object>
                    <h3>Enjoy Your Artwork</h3>
                </div>
                <p data-aos="fade-in">Once the payment is processed and the auction is complete, you can enjoy your newly acquired artwork.</p>
            </div>

        </div>
    </section>

    <!-- modals -->
    <!-- Pre-Registration Modal -->
    <div class="pre-registration-modal">
        <div class="modal fade" id="pre-registration" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="" id="logo"><img src="src/img/pabids-logo.png" alt="PABids" style="width: 100px;"></a>
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
                            <p>By registering, you will agree to the following <a href="" data-bs-toggle="modal" data-bs-target="#terms">Terms & Conditions</a> of PABids.</p>
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
                <p>Elevate Your Art Experience with PABids</p>
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