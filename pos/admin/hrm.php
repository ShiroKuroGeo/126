<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Delete Staff

$con = mysqli_connect("localhost","root","","126motorparts");

if(isset($_POST['delete']))
{
    $staff_id = mysqli_escape_string($con, $_POST['delete']);

    $query = "DELETE FROM rpos_staff WHERE staff_id='$staff_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
          $success = "Deleted" && header("refresh:1; url=hrm.php");
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
              <a href="add_staff.php" class="btn btn-outline-success">
                <i class="fas fa-user-plus"></i>
                 Add New Staff
                </a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Staff Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $query = "SELECT * FROM  rpos_staff ";
                  $query_run = mysqli_query($con, $query);

                  while($staff = mysqli_fetch_assoc($query_run))
                  {
                      
                      
                        ?>
                        <tr>
                            <td><?= $staff['staff_number']; ?></td>
                            <td><?= $staff['staff_name']; ?></td>
                            <td><?= $staff['staff_email']; ?></td>
                            <td>
                                <a href="update_staff.php?update=<?= $staff['staff_id']; ?>">
                                  <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Update
                                  </button>
                                </a>


                                <form method="POST" class="d-inline">
                                  <button type="submit" name="delete" value="<?= $staff['staff_id'];?>" class="btn btn-sm btn-danger">
                                  <i class="fas fa-trash"></i>
                                  Delete</button>
                                </form>
                              

                            </td>
                            
                        </tr>

                        
                        <?php
                      
                  } ?>


                  <!-- <?php
                  $ret = "SELECT * FROM  rpos_staff ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($staff = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $staff->staff_number; ?></td>
                      <td><?php echo $staff->staff_name; ?></td>
                      <td><?php echo $staff->staff_email; ?></td>
                      <td>
                        
                        <a href="update_staff.php?update=<?php echo $staff->staff_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-user-edit"></i>
                            Update
                          </button>
                        </a>

                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delModal">
                              <i class="fas fa-trash"></i>
                              Delete
                            </button>
                      </td>

                      <div class="modal fade" id="delModal" role="dialog">
                          <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <p>Confirm Delete Customer?</p>
                              </div>
                              <div class="modal-footer">
                                <a href="hrm.php?delete=<?php echo $staff->staff_id; ?>">
                                  <button class="btn btn-md btn-success">Yes</button>
                                </a>
                                <button class="btn btn-md btn-danger" data-dismiss="modal">No</button>
                              </div>  
                            </div>  
                          </div>    
                        </div>

                    </tr>
                  <?php } ?> -->
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