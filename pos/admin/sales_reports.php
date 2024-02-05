<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>
<style>
  table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
  }

  th,
  td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }
</style>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <div class="main-content">
    <?php
    require_once('partials/_topnav.php');
    ?>
    <div style="background-image: url(assets/img/theme/restro01.jpg); background-size: cover;" class="header pt-5 pt-md-9">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <a href="customes.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-3 col-lg-6">
              <a href="products.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fas fa-wrench"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-3 col-lg-6">
              <a href="orders_reports.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Orders</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-shopping-cart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-3 col-lg-6">
              <a href="sales_reports.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                        <span class="h2 font-weight-bold mb-0">₱<?php echo $sales; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                          <i class="fas fa-wallet"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro01.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">

      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header">
              <h2>Sales Report</h2>
            </div>
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <a href="sales_reports_selecteddate.php?date=<?php echo date('Y-m', strtotime('last month')); ?>" class="btn btn-sm btn-primary px-4 text-white"><?php echo date('F', strtotime('last month')); ?></a>
                      <a href="sales_reports_selecteddate.php?date=<?php echo date('Y-m'); ?>" class="btn btn-sm btn-primary px-4 text-white"><?php echo date('F'); ?></a>
                    </div>
                    <div class="table-responsive" style="overflow: auto; height: 430px">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">Customer</th>
                            <th class="text-success" scope="col">Product</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $ret = "SELECT * FROM  rpos_orders WHERE order_status = 'Paid' ORDER BY `rpos_orders`.`created_at` DESC ";
                          $stmt = $mysqli->prepare($ret);
                          $stmt->execute();
                          $res = $stmt->get_result();
                          while ($order = $res->fetch_object()) {
                            $total = ($order->prod_price * $order->prod_qty);
                          ?>
                            <tr>
                              <td><?php echo $order->customer_name; ?></td>
                              <td><?php echo $order->prod_name; ?></td>
                              <td><span class='badge badge-success'><?php echo $order->order_status; ?></td>
                              <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <tr>
                          <td colspan="2"><span class='badge badge-danger'></td>
                          <td>
                            <h3><b>Total Sales</b></h3>
                          </td>
                          <td>
                            <h3><b>₱<?php echo $sales; ?></b></h3>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <?php
  require_once('partials/_scripts.php');
  ?>
  <?php
  ?>
</body>

</html>