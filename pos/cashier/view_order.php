<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost","root","","126motorparts");

if(isset($_POST['click_view_btn']))
{
    $order_id = $_POST['order_id'];

    // echo $id;
    $query = "SELECT * FROM  rpos_orders WHERE order_id='$order_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0)
    {
        foreach($query_run as $order)
        {
            $total = $order['prod_price'] * $order['prod_qty'];

            echo '
                <h4>Order ID : '.$order['order_id'].'</h4>
                <h4>Order Code : '.$order['order_code'].'</h4>
                <h4>Customer : '.$order['customer_name'].'</h4>
                <h4>Product : '.$order['prod_name'].'</h4>
                <h4>Price : '.$order['prod_price'].'</h4>
                <h4>Quantity : '.$order['prod_qty'].'</h4>
                <h4>Total Price : '.$total.'</h4>
            ';
            echo"Status : ";
            if ($order['order_status'] == '') 
                    {
                        echo "<span class='badge badge-danger'>Not Paid</span>";
                    } 
            else 
                    {
                        echo "<span class='badge badge-success'>Paid</span>";
                    } 
                    
            echo date('d/M/Y g:i',   strtotime($order['created_at']));
            
            
            
        }
    }
    
}
?>


