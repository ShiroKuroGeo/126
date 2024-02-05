<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$con = mysqli_connect("localhost","root","","126motorparts");

$inputNumber = $_POST['inputNumber'];

// Assuming you have a table named 'your_table' with columns 'column1' and ''
// Replace these with your actual table and column names
$query = "SELECT pay_amt  FROM rpos_payments";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch the data
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Perform subtraction on the retrieved data using user input
    $resultArray = array();
    foreach ($data as $item) {
        $resultArray[] = $item['pay_amt'] - $inputNumber;
    }

    // Print or use the result as needed
    print_r($resultArray);
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();

?>