<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost", "root", "", "126motorparts");


require_once('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php
    require_once('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once('partials/_topnav.php');
        ?>
        <!-- Header -->
        <div style="background-image: url(../admin/assets/img/theme/restro01.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">

                            <a href="prod_search.php" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                                Search Product
                            </a>
                        </div>
                        <div class="table-responsive" style="overflow: auto; height: 430px">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Product Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "SELECT * FROM  rpos_products ";
                                    $query_run = mysqli_query($con, $query);

                                    while ($prod = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="../admin/assets/img/products/<?= $prod['prod_img']; ?>" style='height: 60px; width: 60px'>
                                            </td>
                                            <td><?= $prod['prod_code']; ?></td>
                                            <td><?= $prod['prod_name']; ?></td>
                                            <td><?= $prod['prod_desc']; ?></td>
                                            <td><?= $prod['prod_price']; ?></td>
                                            <td>
                                                <a href="update_product.php?update=<?= $prod['prod_id']; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php

                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php
            require_once('partials/_footer.php');
            ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>