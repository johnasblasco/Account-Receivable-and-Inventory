<?php
require_once 'config/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (
    empty($data['order_date']) || 
    empty($data['customer_name']) || 
    !isset($data['sub_total']) || 
    !isset($data['gst']) || 
    !isset($data['discount']) || 
    !isset($data['net_total']) || 
    !isset($data['paid']) || 
    !isset($data['due']) || 
    empty($data['payment_type'])
) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Extract data
$order_date = $data['order_date'];
$customer_name = $data['customer_name'];
$sub_total = $data['sub_total'];
$gst = $data['gst'];
$discount = $data['discount'];
$net_total = $data['net_total'];
$paid = $data['paid'];
$due = $data['due'];
$payment_type = $data['payment_type'];

// Insert data into invoice table
$query = "INSERT INTO invoice (customer_name, order_date, sub_total, gst, discount, net_total, paid, due, payment_type) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssdddddds', $customer_name, $order_date, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Invoice created successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to insert invoice data into database.']);
}

// Close the database connection
$conn->close();
?>
