<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
    $err = "Blank Values Not Accepted";
  } else {

    $pay_Code = $_POST['pay_code'];

    if (strlen($pay_Code) < 10) {
      $err = "Payment Code Verification Failed, Please Try Again";
    } elseif (strlen($pay_Code) > 10) {
      $err = "Payment Code Verification Failed, Please Try Again";
    } else {
      $customerCodesString = $_GET['customerCodes'];
      $customerCodes = explode(',', $customerCodesString);

      $cartpriceString = $_GET['cartprice'];
      $cartprices = explode(',', $cartpriceString);

      $productidString = $_GET['productid'];
      $productids = explode(',', $productidString);

      $productnameString = $_GET['productname'];
      $productnames = explode(',', $productnameString);

      $cartqrtString = $_GET['cartqrt'];
      $cartqrts = explode(',', $cartqrtString);

      $pay_code = $_POST['pay_code'];
      $pay_amt  = $_POST['pay_amt'];
      $pay_method = $_POST['pay_method'];
      $customer_id = $_GET['customerId'];
      $customer_name = $_GET['customer_name'];

      $order_status = $_GET['orderStatus'];

      // Ensure all arrays have the same length
      if (count($customerCodes) == count($cartprices) && count($customerCodes) == count($cartqrts)) {
        // Prepare and execute statements within the loop
        foreach ($customerCodes as $index => $code) {
          // Get the corresponding cart price and quantity
          $cart_price = $cartprices[$index];
          $quantity = $cartqrts[$index];
          $productName = $productnames[$index];
          $prod_id = $productids[$index];

          // Insert payment record
          $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, customer_name, pay_amt, pay_method, cart_price, quantity, prod_name, prod_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $postStmt = $mysqli->prepare($postQuery);
          $rc = $postStmt->bind_param('sssssssssss', $code, $pay_code, $code, $customer_id, $customer_name, $pay_amt, $pay_method, $cart_price, $quantity, $productName, $prod_id);
          $postStmt->execute();

          // Update order status
          $upQry = "UPDATE rpos_orders SET order_status = ? WHERE order_code = ?";
          $upStmt = $mysqli->prepare($upQry);
          $rc = $upStmt->bind_param('ss', $order_status, $code);
          $upStmt->execute();

          // Delete cart items
          $deleteQtr = "DELETE FROM rpos_cart WHERE cart_code = ?";
          $deleteIds = $mysqli->prepare($deleteQtr);
          $deleteIds->bind_param('s', $code);
          $deleteIds->execute();
        }
      } else {
        // Handle mismatch in array lengths
        echo "Error: Array lengths do not match.";
      }

      if ($upStmt && $postStmt) {
        $success = "Paid";
        header("refresh:1; url=payments_reports.php");
      } else {
        $err = "Please Try Again Or Try Later";
      }
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
    $order_status = $_GET['orderStatus'];
    $customer_name = $_GET['customer_name'];
    $ret = "SELECT * FROM rpos_cart WHERE cart_status ='$order_status' and customer_name = '$customer_name'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();

    $total = 0;

    while ($order = $res->fetch_object()) {
      $total += ($order->prod_price * $order->prod_qty);
    }
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
                    <label>Payment ID</label>
                    <input type="text" readonly value="Serves as Null" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-12" id="paymentCodeField">

                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Total Amount (₱)</label>
                    <input type="text" name="pay_amt" readonly value="<?php echo $total; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Payment Method</label>
                    <select class="form-control" name="pay_method" id="paymentMethod">
                      <option hidden selected>Selected</option>
                      <option value="Cash">Cash</option>
                      <option value="Gcash">Gcash</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="pay" value="Pay Order" class="btn btn-success" value="">
                  </div>
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
  ?>
</body>
<script>
  document.getElementById('paymentMethod').addEventListener('change', function() {
    var paymentMethod = this.value;
    var paymentCodeField = document.getElementById('paymentCodeField');

    // Remove any existing input field
    paymentCodeField.innerHTML = '';

    // Create new input field based on the selected payment method
    if (paymentMethod == 'Cash') { // Cash
      var inputHtml = '<label>Payment Code = <?php echo $mpesaCode; ?></label><br><small class="text-danger"> Type 10 Digits Alpha-Code If Payment Method Is In Cash</small>' +
        '<input type="text" limit="11" name="pay_code" placeholder="<?php echo $mpesaCode; ?>" class="form-control" value="">';
      paymentCodeField.innerHTML = inputHtml;
    } else if (paymentMethod == 'Gcash') { // Gcash
      var inputHtml = '<a href="assets/gcash.jpg" target="_blank">Scan Now</a>' +
        '<input type="file" id="fileInput" name="file" class="form-control">' +
        'Payment Code = Payment Code = <?php echo $mpesaCode; ?> <br><input type="text" id="payCodeInput" name="pay_code" class="form-control" style="display:none;" placeholder="<?php echo $mpesaCode; ?>">';
      paymentCodeField.innerHTML = inputHtml;

      // Get the file input element
      var fileInput = document.getElementById('fileInput');

      // Get the pay_code input element
      var payCodeInput = document.getElementById('payCodeInput');

      // Add event listener for change event on file input
      fileInput.addEventListener('change', function() {
        // Check if files are selected
        if (this.files && this.files.length > 0) {
          // Files are selected, show the pay_code input field
          payCodeInput.style.display = 'block';
        } else {
          // No files selected, hide the pay_code input field
          payCodeInput.style.display = 'none';
        }
      });
    }
  });
</script>

</html>