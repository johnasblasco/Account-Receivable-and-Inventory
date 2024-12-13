<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Import necessary classes
use App\classes\Session;
use App\classes\Manage;
use App\classes\Database; // Add Database class to connect to DB

// Include header and navbar
require_once 'templates/header.php';
require_once 'templates/navbar.php';

// Database connection
require_once __DIR__ . '/app/classes/Database.php'; // Ensure the path is correct


// Database connection settings
$dsn = 'mysql:host=localhost;dbname=inventory'; // Set your DSN for MySQL
$username = 'root';
$password = ''; // Empty string for default MySQL user
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create a new database connection using PDO
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fetch payments from the invoice table
$query = "SELECT invoice_no, customer_name, order_date AS payment_date, paid AS amount_paid, due FROM invoice";
$stmt = $pdo->query($query);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mx-auto mt-6 px-4">
    <!-- Page Title -->
    <h1 class="text-3xl font-semibold text-blue-600 mb-6">Track Payments</h1>

    <!-- Earnings Chart Section -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Earnings Overview</h2>
        <canvas id="earningsChart" class="w-full h-96"></canvas>
    </div>

    <!-- Payments Table Section -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Payment History</h2>
        <table class="min-w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Invoice No</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Customer Name</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Payment Date</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Amount Paid</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Due Amount</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($payments) > 0):
                    $i = 0;
                    foreach ($payments as $payment): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-6 py-4"><?= ++$i ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['invoice_no']) ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['customer_name']) ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['payment_date']) ?></td>
                            <td class="border px-6 py-4">$<?= number_format($payment['amount_paid'], 2) ?></td>
                            <td class="border px-6 py-4">$<?= number_format($payment['due'], 2) ?></td>
                            <td class="border px-6 py-4">
                                <?php if ($payment['due'] == 0): ?>
                                    <span class="bg-green-500 text-white px-4 py-2 rounded-full text-xs">Paid</span>
                                <?php else: ?>
                                    <span class="bg-red-500 text-white px-4 py-2 rounded-full text-xs">Due</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center border px-6 py-4">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Demo Data for Earnings
    const earningsData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Earnings ($)',
            data: [2000, 1500, 2500, 3000, 2200, 3300, 2800, 4000, 3500, 5000, 4800, 5200], // Demo earnings data
            borderColor: '#4CAF50', // Green color
            backgroundColor: 'rgba(76, 175, 80, 0.2)', // Light green background
            fill: true,
            tension: 0.4,
            borderWidth: 2
        }]
    };

    // Chart Configuration
    const config = {
        type: 'line',
        data: earningsData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Earnings ($)'
                    },
                    beginAtZero: true
                }
            }
        }
    };

    // Create the chart
    const ctx = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(ctx, config);
</script>

<?php require_once 'templates/footer.php'; ?>
