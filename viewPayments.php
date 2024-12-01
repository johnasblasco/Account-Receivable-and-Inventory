<?php
require_once 'templates/header.php'; 
require_once 'templates/navbar.php'; 
require_once 'App/classes/Database.php';

$db = new Database();

// Get invoice_id from the query string
$invoiceId = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : null;

if (!$invoiceId) {
    echo "<p class='text-red-500'>Invoice ID is missing!</p>";
    exit;
}

// Fetch payments for the specified invoice
$query = "SELECT * FROM payments WHERE invoice_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $invoiceId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-semibold mb-4">Payments for Invoice #<?= htmlspecialchars($invoiceId) ?></h2>
    <table class="table-auto border-collapse w-full border border-gray-300">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Payment Date</th>
                <th class="border border-gray-300 px-4 py-2">Amount</th>
                <th class="border border-gray-300 px-4 py-2">Payment Method</th>
                <th class="border border-gray-300 px-4 py-2">Note</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($payment = $result->fetch_assoc()) { ?>
                <tr>
                    <td class="border border-gray-300 px-4 py-2"><?= $payment['id'] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $payment['payment_date'] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $payment['amount'] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $payment['payment_method'] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $payment['note'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php require_once 'templates/footer.php'; ?>
