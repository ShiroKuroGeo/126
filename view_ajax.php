<?php
$conn = mysqli_connect("localhost", "root", "", "126motorparts");

$name = $_POST['name'];

$sql = "SELECT * FROM rpos_products WHERE CONCAT(prod_name,prod_name) LIKE '%$name%'";
$query = mysqli_query($conn, $sql);
$data = '';
while ($prod = mysqli_fetch_assoc($query)) {
    $data .=    "<tr>
                        <td>
                        <img src='pos/admin/assets/img/products/" . $prod['prod_img'] . "' style='height: 250px; width: 250px'>
                        </td>
                        <td>" . $prod['prod_name'] . "</td>
                        <td>₱" . $prod['prod_price'] . "</td>
                        <td>" . $prod['prod_desc'] . "</td>
                    </tr>";
}
echo $data;
