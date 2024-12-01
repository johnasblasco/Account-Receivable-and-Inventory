<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
use App\classes\Database;  // Import the Database class

// Ensure user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('location:login.php');
    exit;
}

// Fetch financial data from the database (example query)
$query = "SELECT * FROM financial_reports ORDER BY report_date DESC";
$result = Database::connect($query);  // Use the connect method of the Database class
?>

<div class="container mx-auto mt-6 px-4">
    <h1 class="text-2xl font-semibold text-blue-600">Financial Reporting</h1>
    <p class="text-gray-600 mt-2">View your financial reports, including income, expenses, and net profit.</p>

    <!-- Financial Report Table -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2 text-left">Report Date</th>
                    <th class="px-4 py-2 text-left">Receivables (Income)</th>
                    <th class="px-4 py-2 text-left">Payments (Expenses)</th>
                    <th class="px-4 py-2 text-left">Net Outstanding</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?> <!-- Fetching rows from result -->
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= date('F j, Y', strtotime($row['report_date'])) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_receivables'], 2) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_payments'], 2) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['net_outstanding'], 2) ?></td>
                        <td class="px-4 py-2">
                            <a href="viewReport.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700">View</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add New Report Button -->
    <div class="mt-6">
        <a href="generateReport.php" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus"></i> Generate New Report
        </a>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
