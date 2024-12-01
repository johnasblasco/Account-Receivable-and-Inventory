<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'templates/header.php';
require_once 'templates/navbar.php';
use App\classes\Session;
use App\classes\Database;

// Ensure user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('location:login.php');
    exit;
}

// Initialize Database
$db = Database::db();

// Variables to store the report results
$outstandingReceivables = [];
$paymentHistory = [];
$monthlySummary = [];
$quarterlySummary = [];
$annualSummary = [];

// Fetch Outstanding Receivables by Members
$outstandingQuery = "
    SELECT m.name, SUM(i.amount - p.amount) AS outstanding
    FROM members m
    LEFT JOIN invoices i ON m.id = i.member_id
    LEFT JOIN payments p ON i.id = p.invoice_id
    WHERE i.status = 'unpaid'
    GROUP BY m.name
";

$outstandingResult = mysqli_query($db, $outstandingQuery);

// Fetch Payment History
$paymentHistoryQuery = "
    SELECT p.payment_date, p.amount, m.name, i.invoice_number
    FROM payments p
    JOIN invoices i ON p.invoice_id = i.id
    JOIN members m ON i.member_id = m.id
    ORDER BY p.payment_date DESC
";

$paymentHistoryResult = mysqli_query($db, $paymentHistoryQuery);

// Fetch Monthly Summary
$monthlySummaryQuery = "
    SELECT MONTH(i.created_at) AS month, SUM(i.amount) AS total_income, SUM(p.amount) AS total_payment
    FROM invoices i
    LEFT JOIN payments p ON i.id = p.invoice_id
    WHERE i.status = 'paid' AND YEAR(i.created_at) = YEAR(CURDATE())
    GROUP BY MONTH(i.created_at)
";

$monthlySummaryResult = mysqli_query($db, $monthlySummaryQuery);

// Fetch Quarterly Summary
$quarterlySummaryQuery = "
    SELECT QUARTER(i.created_at) AS quarter, SUM(i.amount) AS total_income, SUM(p.amount) AS total_payment
    FROM invoices i
    LEFT JOIN payments p ON i.id = p.invoice_id
    WHERE i.status = 'paid' AND YEAR(i.created_at) = YEAR(CURDATE())
    GROUP BY QUARTER(i.created_at)
";
$quarterlySummaryResult = mysqli_query($db, $quarterlySummaryQuery);

// Fetch Annual Summary
$annualSummaryQuery = "
    SELECT YEAR(i.created_at) AS year, SUM(i.amount) AS total_income, SUM(p.amount) AS total_payment
    FROM invoices i
    LEFT JOIN payments p ON i.id = p.invoice_id
    WHERE i.status = 'paid'
    GROUP BY YEAR(i.created_at)
";

$annualSummaryResult = mysqli_query($db, $annualSummaryQuery);

// If user clicks "Download Report"
if (isset($_GET['download'])) {
    // Prepare CSV
    $filename = "financial_report_" . date('Y-m-d') . ".csv";
    $output = fopen('php://output', 'w');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Output column headers
    fputcsv($output, ['Member Name', 'Outstanding Amount']);
    while ($row = mysqli_fetch_assoc($outstandingResult)) {
        fputcsv($output, [$row['name'], $row['outstanding'] ?? 0]);
    }

    fputcsv($output, []);
    fputcsv($output, ['Payment Date', 'Amount', 'Member Name', 'Invoice Number']);
    while ($row = mysqli_fetch_assoc($paymentHistoryResult)) {
        fputcsv($output, [date('F j, Y', strtotime($row['payment_date'])), $row['amount'], $row['name'], $row['invoice_number']]);
    }

    fputcsv($output, []);
    fputcsv($output, ['Month', 'Total Income', 'Total Payments']);
    while ($row = mysqli_fetch_assoc($monthlySummaryResult)) {
        fputcsv($output, [$row['month'], $row['total_income'] ?? 0, $row['total_payment'] ?? 0]);
    }

    fputcsv($output, []);
    fputcsv($output, ['Quarter', 'Total Income', 'Total Payments']);
    while ($row = mysqli_fetch_assoc($quarterlySummaryResult)) {
        fputcsv($output, [$row['quarter'], $row['total_income'] ?? 0, $row['total_payment'] ?? 0]);
    }

    fputcsv($output, []);
    fputcsv($output, ['Year', 'Total Income', 'Total Payments']);
    while ($row = mysqli_fetch_assoc($annualSummaryResult)) {
        fputcsv($output, [$row['year'], $row['total_income'] ?? 0, $row['total_payment'] ?? 0]);
    }

    fclose($output);
    exit;
}
?>

<div class="container mx-auto mt-6 px-4">
    <h1 class="text-2xl font-semibold text-blue-600">Generate Financial Report</h1>

    <!-- Outstanding Receivables Report -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold">Outstanding Receivables</h3>
        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Member Name</th>
                    <th class="px-4 py-2">Outstanding Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($outstandingResult)) { ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= $row['name'] ?></td>
                        <td class="px-4 py-2"><?= number_format($row['outstanding'] ?? 0, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Payment History -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold">Payment History</h3>
        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Payment Date</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Member Name</th>
                    <th class="px-4 py-2">Invoice Number</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($paymentHistoryResult)) { ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= date('F j, Y', strtotime($row['payment_date'])) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['amount'], 2) ?></td>
                        <td class="px-4 py-2"><?= $row['name'] ?></td>
                        <td class="px-4 py-2"><?= $row['invoice_number'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Monthly Summary -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold">Monthly Summary</h3>
        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Month</th>
                    <th class="px-4 py-2">Total Income</th>
                    <th class="px-4 py-2">Total Payments</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($monthlySummaryResult)) { ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= $row['month'] ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_income'] ?? 0, 2) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_payment'] ?? 0, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Quarterly Summary -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold">Quarterly Summary</h3>
        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Quarter</th>
                    <th class="px-4 py-2">Total Income</th>
                    <th class="px-4 py-2">Total Payments</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($quarterlySummaryResult)) { ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= $row['quarter'] ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_income'] ?? 0, 2) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_payment'] ?? 0, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Annual Summary -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold">Annual Summary</h3>
        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Year</th>
                    <th class="px-4 py-2">Total Income</th>
                    <th class="px-4 py-2">Total Payments</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($annualSummaryResult)) { ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= $row['year'] ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_income'] ?? 0, 2) ?></td>
                        <td class="px-4 py-2"><?= number_format($row['total_payment'] ?? 0, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Download Button -->
    <a href="?download=true" class="inline-block mt-6 bg-blue-600 text-white py-2 px-4 rounded">Download Report</a>
</div>


</div>

<?php require_once 'templates/footer.php'; ?>
