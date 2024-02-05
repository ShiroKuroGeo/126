<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost","root","","126motorparts");

require_once('partials/_head.php');
?>
<!-- View Modal -->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="viewModalLabel">Order Details</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="view_data">


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View Modal -->

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
        <div style="background-image: url(assets/img/theme/restro01.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                            Orders Details
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Customer</th>
                                        <th class="text-success" scope="col">Product</th>
                                        <th class="text-success" scope="col">Qty</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $query = "SELECT * FROM  rpos_orders ORDER BY `created_at` DESC ";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $order)
                                        {
                                            $total = $order['prod_price'] * $order['prod_qty'];

                                            ?>
                                            <tr>
                                                <th class="order_id" hidden scope="row"><?= $order['order_id']; ?></th>
                                                <td><?= $order['customer_name']; ?></td>
                                                <td class="text-success"><?= $order['prod_name']; ?></td>
                                                <td class="text-success"><?= $order['prod_qty']; ?></td>
                                                <td><?= $total; ?></td>
                                                
                                                <td>
                                                    <a href="#" class="btn-sm btn-info viewbtn">View</a>
                                                </td>
                                            </tr>
                                            <?php

                                        }
                                    }
                                    
                                    ?>

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

    <script>
        
        $(document).ready(function () {

            $('.viewbtn').click(function (e) {
                e.preventDefault();

                
                var order_id =  $(this).closest('tr').find('.order_id').text();
                // console.log(order_id);

                $.ajax({
                    method: "POST",
                    url: "view_order.php",
                    data: {
                        'click_view_btn': true,
                        'order_id':order_id,
                    },
                    success: function (response) {
                        console.log(response);

                        $('.view_data').html(response);
                        $('#viewModal').modal('show');

                    }
                });

            });
        });
    </script>
</body>

</html>