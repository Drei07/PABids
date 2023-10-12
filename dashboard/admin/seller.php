<?php
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once '../../configuration/header.php';
    ?>
    <title>PABids | Seller</title>
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
                <a href="user">
                    <i class='bx bxs-user-account'></i>
                    <span class="text">User</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu top">
            <li>
                <a href="settings">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="audit-trail">
                    <i class='bx bxl-blogger'></i>
                    <span class="text">Audit Trail</span>
                </a>
            </li>
            <li>
                <a href="authentication/admin-signout" class="btn-signout">
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
                    <h1>Users</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="./">Home</a>
                        </li>
                        <li>|</li>
                        <li>
                            <a href="">Seller</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="dashboard_data">
                <li onclick="location.href='user'">
                    <i class='bx bxs-user-account'></i>
                    <span class="text">
                        <?php

                        $stmt = $user->runQuery("SELECT * FROM users WHERE user_type = :user_type");
                        $stmt->execute(array(":user_type" => 2));
                        $user_count = $stmt->rowCount();

                        echo
                        "
                            <h3>$user_count</h3>
                        ";
                        ?>
                        <p>Users</p>
                    </span>
                </li>
                <li onclick="location.href='seller'">
                    <i class='bx bxs-store-alt'></i>
                    <span class="text">
                    <?php

                        $stmt = $user->runQuery("SELECT * FROM seller WHERE status = :status");
                        $stmt->execute(array(":status" => "verify"));
                        $seller_count = $stmt->rowCount();

                        echo
                        "
                            <h3>$seller_count</h3>
                        ";
                        ?>
                        <p>Seller</p>
                    </span>
                </li>
                <li onclick="location.href='pending-seller'">
                    <i class='bx bxs-hourglass-top'></i>
                    <span class="text">
                    <?php

                        $stmt = $user->runQuery("SELECT * FROM seller WHERE status = :status");
                        $stmt->execute(array(":status" => "not_verify"));
                        $seller_count = $stmt->rowCount();

                        echo
                        "
                            <h3>$seller_count</h3>
                        ";
                        ?>
                        <p>Pending Seller</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3><i class='bx bxs-user-account'></i> List of Seller Account</h3>
                    </div>
                    <!-- BODY -->
                    <section class="data-table">
                        <div class="searchBx">
                            <input type="input" placeholder="search . . . . . ." class="search" name="search_box" id="search_box"><button class="searchBtn"><i class="bx bx-search icon"></i></button>
                        </div>

                        <div class="table">
                            <div id="dynamic_content">
                            </div>

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
        //live search---------------------------------------------------------------------------------------//
        $(document).ready(function() {

            load_data(1);

            function load_data(page, query = '') {
                $.ajax({
                    url: "tables/seller-table.php",
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