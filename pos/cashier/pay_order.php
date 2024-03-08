<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
    $err = "Blank Values Not Accepted";
  } else {

    $pay_code = $_POST['pay_code'];
    $order_code = $_GET['order_code'];
    $customer_id = $_GET['customer_id'];
    $pay_amt  = $_POST['pay_amt'];
    $pay_method = $_POST['pay_method'];
    $pay_id = $_POST['pay_id'];
    $staff_id = $_SESSION['staff_id'];
    $customerNames = $_GET['customerName'];
    $prodid = $_GET['prodid'];
    $proname = $_GET['proname'];

    $order_status = $_GET['order_status'];

    $ret = "SELECT * FROM rpos_payments WHERE order_code ='$order_code' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
      $pqty = $order->quantity;
    }
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO `rpos_orders`(`order_id`, `order_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`, `order_status`) VALUES (?,?,?,?,?,?,?,?,?)";
    $upQry = "UPDATE rpos_payments SET staff_id = ? WHERE order_code = ?";

    $postStmt = $mysqli->prepare($postQuery);
    $upStmt = $mysqli->prepare($upQry);
    //bind paramaters

    $rc = $postStmt->bind_param('sssssssss', $pay_id, $order_code, $customer_id, $customerNames, $prodid, $proname, $pay_amt, $pqty, $order_status);
    $rc = $upStmt->bind_param('ss', $staff_id, $order_code);

    $postStmt->execute();
    $upStmt->execute();
    //declare a varible which will be passed to alert function
    if ($upStmt && $postStmt) {
      $success = "Paid" && header("refresh:1; url=receipts.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
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

    $order_code = $_GET['order_code'];
    $ret = "SELECT * FROM rpos_payments WHERE order_code ='$order_code' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
      $price = $order->cart_price;
      $paymentMethod = $order->pay_method;
      $pqty = $order->quantity;
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
                <h3>Please Fill All Fields </h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">

                    <!-- <div class="col-md-4">
                    <label>Customer Name</label>
                    <select class="form-control" name="staff_name" id="staffName" onChange="getstaff(this.value)">
                      <option value="">Select Cashier Name</option>
                      <?php
                      //Load All Customers
                      $ret = "SELECT * FROM rpos_staff ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($cust = $res->fetch_object()) {
                      ?>
                        <option><?php echo $cust->staff_name; ?></option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="staff_id" value="<?php echo $staffid; ?>" class="form-control">
                  </div> -->

                    <div class="col-md-6">
                      <label>Payment ID </label>
                      <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Payment Code</label>
                      <input type="text" name="pay_code" readonly value="<?php echo $mpesaCode; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Amount (₱)</label>
                      <input type="text" name="pay_amt" readonly value="<?php echo $price; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Payment Method</label>
                      <select class="form-control" name="pay_method" readonly value="<?php echo $paymentMethod;?>">
                        <option selected value="<?php echo $paymentMethod;?>"><?php echo $paymentMethod;?></option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="pay" value="Pay Order" class="btn btn-success" value="">
                    </div>
                  </div>
                  <!-- <div class="form-row">
                  <div class="col-md-6">
                      <button class="btn btn btn-success" data-toggle="modal" data-target="#delModal">
                            Pay Order
                      </button>
                    <input type="submit" name="pay" value="Pay Order" class="btn btn-success" value="">
                  </div>
                </div> -->
                  <!-- <div class="modal fade" id="delModal" role="dialog">
                          <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <label for="inputNumber">Input Amount</label>
                                
                                      <input type="number" class="form-control" id="inputNumber" name="inputNumber" required>
                                      <button type="submit" class="btn btn-info form-control">Subtract</button>
                                      <input type="text" name="pay_amt" readonly value="<?php echo $total; ?>" class="form-control">
                                      <input type="text" name="change" readonly value="change" class="form-control">

                                
                              </div>
                              <div class="modal-footer">
                                    <input type="submit" name="pay" value="Pay Order" class="btn btn-success" >
                                </div>
                                
                              </div>  
                            </div>  
                          </div>     -->
              </div>
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
    }
?>
</body>

</html>