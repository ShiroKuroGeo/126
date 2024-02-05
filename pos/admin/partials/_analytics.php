<?php
//1. Customers
$query = "SELECT COUNT(*) FROM `rpos_customers` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();

//2. Orders
$query = "SELECT COUNT(*) FROM `rpos_orders` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Orders
$query = "SELECT COUNT(*) FROM `rpos_products` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

//4.Sales
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();

//5. This Month
$currentMonth = date('Y-m');
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` WHERE DATE_FORMAT(`created_at`, '%Y-%m') = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $currentMonth);
$stmt->execute();
$stmt->bind_result($monthNow);
$stmt->fetch();
$stmt->close();

//6. Last Month
$lastMonth = date('Y-m', strtotime('last month'));
$query = "SELECT SUM(pay_amt) FROM `rpos_payments` WHERE DATE_FORMAT(`created_at`, '%Y-%m') = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $lastMonth);
$stmt->execute();
$stmt->bind_result($monthLast);
$stmt->fetch();
$stmt->close();
