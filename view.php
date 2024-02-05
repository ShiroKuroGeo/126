<?php
include('pos/admin/config/config.php');
require_once('pos/admin/partials/_head.php');

$conn = mysqli_connect("localhost", "root", "", "126motorparts")

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>126 Motor Parts Web Application </title>

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

</head>

<body class="bg-dark">

  <div class="container-fluid mt--8">

    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <a href="index.php" class="btn btn-outline-success px-4">
            <i class="fa fa-arrow-left"></i>
            Back
          </a>
        </div>
        <div class="col-1">
          <img src="pos/admin/assets/img/brand/repos0.png" class="w-100 bg-white rounded">
        </div>
      </div>
    </div>
    <div class="table-responsive bg-white rounded" style="overflow: auto; height: 430px">
      <div class="text-right mt-2 mx-2">
        <input type="text" id="getProd" class="py-2 px-2 border border-primary rounded" placeholder="Search Product">
      </div>
      <table class="table align-items-center table-flush">
        <thead>
          <tr>
            <th scope="col">Image</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Description</th>
          </tr>
        </thead>
        <tbody id="showdata">
          <?php
          $sql = "SELECT * FROM rpos_products";
          $query = mysqli_query($conn, $sql);
          while ($prod = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
              <td>
                <img src="pos/admin/assets/img/products/<?= $prod['prod_img']; ?>" style='height: 250px; width: 250px'>
              </td>
              <td><?= $prod['prod_name']; ?></td>
              <td>₱<?= $prod['prod_price']; ?></td>
              <td><?= $prod['prod_desc']; ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#getProd').on("keyup", function() {
        var getProd = $(this).val();
        $.ajax({
          method: 'POST',
          url: 'view_ajax.php',
          data: {
            name: getProd
          },
          success: function(response) {
            $("#showdata").html(response);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>

</body>

</html>