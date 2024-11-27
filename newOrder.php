<?php require_once 'templates/header.php' ?>
<?php require_once 'templates/navbar.php' ?>

<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-blue-600 text-white p-4 rounded-t-lg">
                <h2 class="text-2xl font-semibold">New Order</h2>
            </div>
            <div class="p-6">
                <form id="get_order_data" onsubmit="return false">
                    <!-- Order Date -->
                    <div class="mb-4">
                        <label for="order_date" class="block text-gray-700 font-medium mb-2">Order Date</label>
                        <input type="text" id="order_date" name="order_date" readonly 
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               value="<?php echo date('Y-d-m'); ?>">
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-4">
                        <label for="cust_name" class="block text-gray-700 font-medium mb-2">Customer Name*</label>
                        <input type="text" id="cust_name" name="cust_name" required 
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter Customer Name">
                    </div>

                    <!-- Order List -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Make an Order List</h3>
                        <table class="table-auto w-full text-center border-collapse border border-gray-300">
                            <thead class="bg-blue-100 text-gray-700">
                                <tr>
                                    <th class="border border-gray-300 p-2">#</th>
                                    <th class="border border-gray-300 p-2">Item Name</th>
                                    <th class="border border-gray-300 p-2">Total Quantity</th>
                                    <th class="border border-gray-300 p-2">Quantity</th>
                                    <th class="border border-gray-300 p-2">Price</th>
                                    <th class="border border-gray-300 p-2">Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_item">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                        <div class="flex justify-center gap-4 mt-4">
                            <button id="add" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Add <i class="fa fa-plus ml-1"></i>
                            </button>
                            <button id="remove" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Remove <i class="fa fa-trash-alt ml-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Subtotal, GST, Discounts, and Total -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="sub_total" class="block text-gray-700 font-medium mb-2">Sub Total</label>
                            <input type="text" id="sub_total" name="sub_total" readonly 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="gst" class="block text-gray-700 font-medium mb-2">GST (10%)</label>
                            <input type="text" id="gst" name="gst" readonly 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="discount" class="block text-gray-700 font-medium mb-2">Discount</label>
                            <input type="text" id="discount" name="discount" 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="net_total" class="block text-gray-700 font-medium mb-2">Net Total</label>
                            <input type="text" id="net_total" name="net_total" readonly 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="paid" class="block text-gray-700 font-medium mb-2">Paid</label>
                            <input type="text" id="paid" name="paid" 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="due" class="block text-gray-700 font-medium mb-2">Due</label>
                            <input type="text" id="due" name="due" readonly 
                                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="payment_type" class="block text-gray-700 font-medium mb-2">Payment Method</label>
                            <select id="payment_type" name="payment_type" 
                                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option>Cash</option>
                                <option>Card</option>
                                <option>Draft</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button id="order_form" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Order
                        </button>
                        <button id="print_invoice" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 hidden">
                            Print Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php' ?>
