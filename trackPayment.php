<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
// require_once 'App/classes/Manage.php'; // No need for Manage.php when we're using demo data
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
                // Demo data to simulate payments
                $payments = [
                    [
                        'invoice_no' => 'INV001',
                        'customer_name' => 'John Doe',
                        'payment_date' => '2024-11-01',
                        'amount_paid' => 200.00,
                        'due_amount' => 50.00
                    ],
                    [
                        'invoice_no' => 'INV002',
                        'customer_name' => 'Jane Smith',
                        'payment_date' => '2024-11-05',
                        'amount_paid' => 300.00,
                        'due_amount' => 0.00
                    ],
                    [
                        'invoice_no' => 'INV003',
                        'customer_name' => 'Alice Johnson',
                        'payment_date' => '2024-11-10',
                        'amount_paid' => 150.00,
                        'due_amount' => 100.00
                    ],
                    [
                        'invoice_no' => 'INV004',
                        'customer_name' => 'Bob Lee',
                        'payment_date' => '2024-11-15',
                        'amount_paid' => 500.00,
                        'due_amount' => 200.00
                    ],
                ];

                if (count($payments) > 0):
                    $i = 0;
                    foreach ($payments as $payment): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-6 py-4"><?= ++$i ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['invoice_no']) ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['customer_name']) ?></td>
                            <td class="border px-6 py-4"><?= htmlspecialchars($payment['payment_date']) ?></td>
                            <td class="border px-6 py-4">$<?= number_format($payment['amount_paid'], 2) ?></td>
                            <td class="border px-6 py-4">$<?= number_format($payment['due_amount'], 2) ?></td>
                            <td class="border px-6 py-4">
                                <?php if ($payment['due_amount'] == 0): ?>
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
