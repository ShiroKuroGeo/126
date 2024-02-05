<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost", "root", "", "126motorparts");
//Remove to Cart

if (isset($_POST['cancel'])) {
    $cart_id = mysqli_escape_string($con, $_POST['cancel']);

    $query = "DELETE FROM rpos_cart WHERE cart_id='$cart_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $success = "Deleted" && header("refresh:1; url=cart.php");
    } else {
        $err = "Try Again Later";
    }
}

if (isset($_POST['delete_all'])) {

    $cart_id = mysqli_escape_string($con, $_POST['delete_all']);
    // Execute the delete query
    $sql = "DELETE FROM rpos_cart WHERE cart_id='$cart_id'";
    if ($con->query($sql) === TRUE) {
        echo "All records deleted successfully";
    } else {
        echo "Error deleting records: " . $con->error;
    }
}


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
                            <a href="orders.php" class="btn btn-outline-success">
                                <i class="fas fa-cart-plus"></i>
                                Add more Items
                            </a>
                        </div>
                        <div class="table-responsive" style="overflow: auto; height: 430px">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $customer_id = $_SESSION['customer_id'];
                                    $ret = "SELECT * FROM rpos_cart WHERE cart_status ='' AND customer_id = '$customer_id'  ORDER BY `rpos_cart`.`created_at` DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();

                                    $overallTotal = 0;

                                    while ($cart = $res->fetch_object()) {
                                        $productTotal = $cart->prod_qty * $cart->prod_price;
                                        $overallTotal += $productTotal;

                                    ?>
                                        <tr>

                                            <th class="text-success" scope="row"><?php echo $cart->cart_code; ?></th>
                                            <td><?php echo $cart->customer_name; ?></td>
                                            <td><?php echo $cart->prod_name; ?></td>
                                            <td><?php echo $cart->prod_price; ?></td>
                                            <td><?php echo $cart->prod_qty; ?></td>
                                            <td>₱ <?php echo $cart->prod_price * $cart->prod_qty; ?></td>
                                            <td>
                                                <a href="make_order.php?prod_id=<?php echo $cart->prod_id; ?>&prod_name=<?php echo $cart->prod_name; ?>&prod_price=<?php echo $cart->prod_price; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-cart-plus"></i>
                                                        Place Order
                                                    </button>
                                                </a>
                                                <form method="POST" class="d-inline">
                                                    <button type="submit" name="cancel" value="<?php echo $cart->cart_id; ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-trash"></i>
                                                        Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td><strong>Total Price</strong></td>
                                        <td><b>₱ <?php echo $overallTotal ?></b></td>
                                        <td>
                                            <a href="">
                                                <button class="btn btn-sm btn-success ">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    Check Out
                                                </button>
                                            </a>
                                            <form method="post" action="" class="d-inline">
                                                <button type="submit" name="delete_all" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                    Delete All
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
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