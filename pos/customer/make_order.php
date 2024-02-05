<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
    $prod_id = $_GET['prod_id'];
    $customer_id = $_SESSION['customer_id'];

    $postQuery = "SELECT * FROM `rpos_orders` WHERE `prod_id` = ? AND `customer_id` = ?";
    $postStmt = $mysqli->prepare($postQuery);
    $postStmt->bind_param('ss', $prod_id, $customer_id);
    $postStmt->execute();
    $result = $postStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $order_id = $_POST['order_id'];
        $order_code = $_POST['order_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        $postQuery = "UPDATE `rpos_orders` SET `order_code`= ?,`customer_id`=?,`customer_name`=?,`prod_id`=?,`prod_name`=?,`prod_price`=?,`prod_qty`= `prod_qty` + ?  WHERE `prod_id` = ? AND `customer_id` = ?";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('sssssssss', $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price, $prod_qty, $prod_id, $customer_id);
        $postStmt->execute();

        // Update the product quantity
        $update = "UPDATE `rpos_products` SET `prod_quantity` = `prod_quantity` - ? WHERE `prod_id` = ?;";
        $updateNew = $mysqli->prepare($update);
        $updateQty = $updateNew->bind_param('ss', $prod_qty, $prod_id);
        $updateNew->execute();

        if ($postStmt && $updateNew) {
            $success = "Order Updated";
            header("refresh:1; url=payments.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } else {
        $order_id = $_POST['order_id'];
        $order_code = $_POST['order_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
        $postStmt->execute();

        $update = "UPDATE `rpos_products` SET `prod_quantity` = `prod_quantity` - ? WHERE `prod_id` = ?;";
        $updateNew = $mysqli->prepare($update);
        $updateQty = $updateNew->bind_param('ss', $prod_qty, $prod_id);
        $updateNew->execute();

        if ($postStmt && $updateNew) {
            $success = "Order Submitted";
            header("refresh:1; url=payments.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}
require_once('partials/_head.php');
?>

<body>
    <?php
    require_once('partials/_sidebar.php');
    ?>

    <div class="main-content">

        <?php
        require_once('partials/_topnav.php');
        ?>

        <div style="background-image: url(../admin/assets/img/theme/restro01.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>

        <div class="container-fluid mt--8">

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
                                        <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Order Code</label>
                                        <input type="text" readonly name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
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
                                        <div class="col-md-4">
                                            <label>Product Name</label>
                                            <input type="text" readonly name="prod_name" value="<?php echo $prod->prod_name; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Product Price (₱)</label>
                                            <input type="text" readonly name="prod_price" value="₱ <?php echo $prod->prod_price; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Product Quantity</label>
                                            <input type="text" name="prod_qty" class="form-control" value="1">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="make" value="Make Order" class="btn btn-success" value="" <?php echo $prod->prod_quantity == null ? 'disabled' : ''; ?>>
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