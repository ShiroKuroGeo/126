<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost","root","","126motorparts");

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
                             
                <form action="" method="GET">
                  <div class="input-group">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="py-2 pl-2 pr-7 bc-primary border border-primary rounded" required placeholder="Search Product">
                    <button class="btn btn-outline-primary ml-2" type="submit">Search</button>
                    </div>
                </form>  
              
            </div>
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
                  $con = mysqli_connect("localhost","root","","126motorparts");

                  if(isset($_GET['search']))
                  {
                    $filtervalues = $_GET['search'];
                    $query = "SELECT * FROM rpos_products WHERE CONCAT(prod_img,prod_code,prod_name,prod_desc,prod_price) LIKE '%$filtervalues%' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                      foreach($query_run as $items)
                      {
                        ?>
                          <tr>
                            <td>
                            <img src="../admin/assets/img/products/<?= $items['prod_img']; ?>" style='height: 60px; width: 60px' >
                            </td>
                            <td><?= $items['prod_code']; ?></td>
                            <td><?= $items['prod_name']; ?></td>
                            <td><?= $items['prod_desc']; ?></td>
                            <td><?= $items['prod_price']; ?></td>
                            <td>
                            <a href="make_order.php?prod_id=<?= $items['prod_id']; ?>&prod_name=<?= $items['prod_name']; ?>&prod_price=<?= $items['prod_price']; ?>">
                                <button class="btn btn-sm btn-warning">
                                  <i class="fas fa-cart-plus"></i>
                                  Place Order
                                </button>
                          </a>
                            </td>
                            
                          </tr>
                        <?php
                      }
                    }
                    else
                    {
                      ?>
                        <tr>
                          <td>No Product Found</td>
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
</body>

</html>