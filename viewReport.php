<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
use App\classes\Database;  // Import the Database class

// Ensure user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('location:login.php');
    exit;
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the selected report from the database
    $query = "SELECT * FROM financial_reports WHERE id = $id";
    $result = Database::connect($query);  // Use the connect method of the Database class
    
    // Check if the report was found
    if (mysqli_num_rows($result) == 0) {
        echo "No report found with the provided ID.";
        exit;
    }
    
    // Fetch the data for the report
    $report = mysqli_fetch_assoc($result);
} else {
    echo "Invalid report ID.";
    exit;
}
?>

<div class="container mx-auto mt-6 px-4">
    <h1 class="text-2xl font-semibold text-blue-600">Financial Report Details</h1>
    <p class="text-gray-600 mt-2">Details of the selected financial report.</p>

    <!-- Financial Report Details -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-blue-500">Report Information</h2>
        <p class="mt-2"><strong>Report Date:</strong> <?= date('F j, Y', strtotime($report['report_date'])) ?></p>
        <p><strong>Total Receivables:</strong> $<?= number_format($report['total_receivables'], 2) ?></p>
        <p><strong>Total Payments:</strong> $<?= number_format($report['total_payments'], 2) ?></p>
        <p><strong>Net Outstanding:</strong> $<?= number_format($report['net_outstanding'], 2) ?></p>
        <p><strong>Period:</strong> <?= $report['period'] ?></p>
        <p><strong>Created At:</strong> <?= date('F j, Y', strtotime($report['created_at'])) ?></p>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="financialReporting.php" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
            <i class="fas fa-arrow-left"></i> Back to Financial Reports
        </a>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
