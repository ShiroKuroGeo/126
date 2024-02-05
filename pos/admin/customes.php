<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Delete Customer

$con = mysqli_connect("localhost","root","","126motorparts");

if(isset($_POST['delete']))
{
    $customer_id = mysqli_escape_string($con, $_POST['delete']);

    $query = "DELETE FROM rpos_customers WHERE customer_id='$customer_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
          $success = "Deleted" && header("refresh:1; url=customes.php");
    } 
    else 
    {
          $err = "Try Again Later";
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
              
                <a href="add_customer.php" class="btn btn-outline-success">
                  <i class="fas fa-user-plus"></i>
                  Add New Customer
                </a>
                <a href="cust_search.php" class="btn btn-outline-primary">
                  <i class="fa fa-search"></i>
                  Search Customer
                </a>
              
            </div>

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $query = "SELECT * FROM  rpos_customers ";
                  $query_run = mysqli_query($con, $query);

                  while($cust = mysqli_fetch_assoc($query_run))
                  {
                        ?>
                        <tr>
                            <td><?= $cust['customer_name']; ?></td>
                            <td><?= $cust['customer_phoneno']; ?></td>
                            <td><?= $cust['customer_email']; ?></td>
                            <td>
                                <a href="update_customer.php?update=<?= $cust['customer_id']; ?>">
                                  <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Update
                                  </button>
                                </a>


                                <form method="POST" class="d-inline">
                                  <button type="submit" name="delete" value="<?= $cust['customer_id'];?>" class="btn btn-sm btn-danger">
                                  <i class="fas fa-trash"></i>
                                  Delete</button>
                                </form>
                              

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