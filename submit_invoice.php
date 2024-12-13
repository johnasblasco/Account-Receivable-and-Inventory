<?php
require_once 'config/db.php'; // Update this with your database configuration file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $customer_name = $_POST['cust_name'];
    $order_date = $_POST['order_date'];
    $sub_total = $_POST['sub_total'];
    $gst = $_POST['gst'];
    $discount = $_POST['discount'];
    $net_total = $_POST['net_total'];
    $paid = $_POST['paid'];
    $due = $_POST['due'];
    $payment_type = $_POST['payment_type'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "inventory"); // Update credentials

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the invoice table
    $sql = "INSERT INTO invoice (customer_name, order_date, sub_total, gst, discount, net_total, paid, due, payment_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdddddds", $customer_name, $order_date, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type);

    if ($stmt->execute()) {
        echo "Invoice created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
