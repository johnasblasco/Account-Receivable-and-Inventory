<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
// require_once 'App/classes/Manage.php'; // No need for Manage.php when we're using demo data
?>

<div class="container mx-auto mt-6 px-4">
    <!-- Page Title -->
    <h1 class="text-3xl font-semibold text-blue-600 mb-6">Manage Payments</h1>

    <!-- Add Payment Section -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Payment</h2>
        <form id="addPaymentForm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="invoiceNo" class="block text-sm font-medium text-gray-700">Invoice No</label>
                    <input type="text" id="invoiceNo" name="invoiceNo" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Invoice No" required>
                </div>
                <div>
                    <label for="customerName" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" id="customerName" name="customerName" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Customer Name" required>
                </div>
                <div>
                    <label for="paymentDate" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" id="paymentDate" name="paymentDate" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label for="amountPaid" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                    <input type="number" id="amountPaid" name="amountPaid" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Amount Paid" required>
                </div>
                <div>
                    <label for="dueAmount" class="block text-sm font-medium text-gray-700">Due Amount</label>
                    <input type="number" id="dueAmount" name="dueAmount" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Due Amount" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Add Payment</button>
        </form>
    </div>

    <!-- Success Alert (Initially hidden) -->
    <div id="successAlert" class="hidden bg-green-500 text-white px-4 py-2 rounded-md mb-6">
        <strong>Success!</strong> Payment added successfully.
    </div>

    <!-- Payments Table Section -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Payments List</h2>
        <table class="min-w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Invoice No</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Customer Name</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Payment Date</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Amount Paid</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Due Amount</th>
                    <th class="border px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody id="paymentsList">
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
                                <button class="text-blue-600 hover:text-blue-800" onclick="editPayment(<?= $i ?>)">Edit</button>
                                <button class="ml-4 text-red-600 hover:text-red-800" onclick="deletePayment(<?= $i ?>)">Delete</button>
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

<script>
    // Function to handle adding a payment
    document.getElementById('addPaymentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Get form data
        const invoiceNo = document.getElementById('invoiceNo').value;
        const customerName = document.getElementById('customerName').value;
        const paymentDate = document.getElementById('paymentDate').value;
        const amountPaid = parseFloat(document.getElementById('amountPaid').value);
        const dueAmount = parseFloat(document.getElementById('dueAmount').value);
        
        // Add payment to table
        const paymentList = document.getElementById('paymentsList');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td class="border px-6 py-4">${paymentList.rows.length + 1}</td>
            <td class="border px-6 py-4">${invoiceNo}</td>
            <td class="border px-6 py-4">${customerName}</td>
            <td class="border px-6 py-4">${paymentDate}</td>
            <td class="border px-6 py-4">$${amountPaid.toFixed(2)}</td>
            <td class="border px-6 py-4">$${dueAmount.toFixed(2)}</td>
            <td class="border px-6 py-4">
                <button class="text-blue-600 hover:text-blue-800" onclick="editPayment(${paymentList.rows.length + 1})">Edit</button>
                <button class="ml-4 text-red-600 hover:text-red-800" onclick="deletePayment(${paymentList.rows.length + 1})">Delete</button>
            </td>
        `;
        
        paymentList.appendChild(newRow);
        
        // Show success alert
        const alertBox = document.getElementById('successAlert');
        alertBox.classList.remove('hidden');
        
        // Hide alert after 3 seconds
        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 3000);
        
        // Clear the form
        document.getElementById('addPaymentForm').reset();
    });
    
    // Dummy functions for Edit and Delete (to be implemented later)
    function editPayment(index) {
        console.log('Editing payment:', index);
    }

    function deletePayment(index) {
        console.log('Deleting payment:', index);
    }
</script>

<?php require_once 'templates/footer.php'; ?>
