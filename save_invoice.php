<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the data sent via POST
    $order_date = $_POST['order_date'];
    $cust_name = $_POST['cust_name'];
    $sub_total = $_POST['sub_total'];
    $gst = $_POST['gst'];
    $discount = $_POST['discount'];
    $net_total = $_POST['net_total'];
    $paid = $_POST['paid'];
    $due = $_POST['due'];
    $payment_type = $_POST['payment_type'];

    // Example of inserting data into a database (update with your actual database code)
    require_once 'config/database.php'; // Include your database connection

    $query = "INSERT INTO invoices (order_date, cust_name, sub_total, gst, discount, net_total, paid, due, payment_type) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    // Bind values to the prepared statement
    $stmt->bind_param('ssdddsdss', $order_date, $cust_name, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Invoice saved successfully!";
    } else {
        echo "Error saving invoice: " . $stmt->error;
    }

    $stmt->close();
}
?>
