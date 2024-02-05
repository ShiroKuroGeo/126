<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addCart'])) {
    $prod_id = $_GET['prod_id'];
    $customer_id = $_SESSION['customer_id'];

    $postQuery = "SELECT * FROM `rpos_cart` WHERE `prod_id` = ? AND `customer_id` = ?";
    $postStmt = $mysqli->prepare($postQuery);
    $postStmt->bind_param('ss', $prod_id, $customer_id);
    $postStmt->execute();
    $result = $postStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $cart_id = $_POST['cart_id'];
        $cart_code  = $_POST['cart_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id  = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        $postQuery = "UPDATE `rpos_cart` SET `customer_id` = ?,`customer_name` = ?, `prod_id` = ?,`prod_name` = ?, `prod_price` = ?, `prod_qty` = `prod_qty` + ? WHERE `prod_id` = ? AND `customer_id` = ?";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('ssssssss', $customer_id, $customer_name, $prod_id, $prod_name, $prod_price, $prod_qty, $prod_id, $customer_id);
        $postStmt->execute();
        if ($postStmt) {
            $success = "Cart Submitted" && header("refresh:1; url=cart.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } else {
        $cart_id = $_POST['cart_id'];
        $cart_code  = $_POST['cart_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id  = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        $postQuery = "INSERT INTO rpos_cart (prod_qty, cart_id, cart_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('ssssssss', $prod_qty, $cart_id, $cart_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
        $postStmt->execute();
        if ($postStmt) {
            $success = "Cart Submitted" && header("refresh:1; url=cart.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }

    // if (empty($_POST["prod_qty"])) {
    //     $err = "Blank Values Not Accepted";
    // } else {

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
                            <h3>Please Fill All Fields</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <label>Customer Name</label>
                                        <?php
                                        $customer_id = $_SESSION['customer_id'];
                                        $ret = "SELECT * FROM  rpos_customers WHERE customer_id = '$customer_id' ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($cust = $res->fetch_object()) {
                                        ?>
                                            <input class="form-control" readonly name="customer_name" value="<?php echo $cust->customer_name; ?>">
                                        <?php } ?>
                                        <input type="hidden" name="cart_id" value="<?php echo $cartid; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cart Code</label>
                                        <input type="text" readonly name="cart_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <?php
                                $prod_id = $_GET['prod_id'];
                                $ret = "SELECT * FROM  rpos_products WHERE prod_id = '$prod_id'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Product Price (₱)</label>
                                            <input type="text" readonly name="prod_price" value="₱ <?php echo $prod->prod_price; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Product Quantity</label>
                                            <input type="text" name="prod_qty" class="form-control" value="1">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="addCart" value="Add to Cart" class="btn btn-success" <?php echo $prod->prod_quantity == null ? 'disabled ' : ''; ?>>
                                        </div>
                                    </div>
                                <?php } ?>
                            </form>
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