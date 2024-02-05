<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Delete Staff
$con = mysqli_connect("localhost","root","","126motorparts");

if(isset($_POST['delete']))
{
    $customer_id = mysqli_escape_string($con, $_POST['delete']);

    $query = "DELETE FROM rpos_customers WHERE customer_id='$customer_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
          $success = "Deleted" && header("refresh:1; url=cust_search.php");
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
                             
                <form action="" method="GET">
                  <div class="input-group">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="py-2 pl-2 pr-7 bc-primary border border-primary rounded" required placeholder="Search Customer">
                    <button class="btn btn-outline-primary ml-2" type="submit">Search</button>
                    </div>
                </form>  
              
            </div>
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
                  $con = mysqli_connect("localhost","root","","126motorparts");

                  if(isset($_GET['search']))
                  {
                    $filtervalues = $_GET['search'];
                    $query = "SELECT * FROM rpos_customers WHERE CONCAT(customer_name,customer_phoneno,customer_email) LIKE '%$filtervalues%' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                      foreach($query_run as $items)
                      {
                        ?>
                          <tr>
                            <td><?= $items['customer_name']; ?></td>
                            <td><?= $items['customer_phoneno']; ?></td>
                            <td><?= $items['customer_email']; ?></td>
                            <td>
                                <a href="update_customer.php?update=<?= $items['customer_id']; ?>">
                                  <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Update
                                  </button>
                                </a>


                                <form method="POST" class="d-inline">
                                  <button type="submit" name="delete" value="<?= $items['customer_id'];?>" class="btn btn-sm btn-danger">
                                  <i class="fas fa-trash"></i>
                                  Delete</button>
                                </form>
                              

                            </td>
                            
                        </tr>
                        <?php
                      }
                    }
                    else
                    {
                      ?>
                        <tr>
                          <td>No Customer Found</td>
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