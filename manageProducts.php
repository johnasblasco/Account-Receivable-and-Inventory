<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
use App\classes\Session;

// Ensure user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('location:login.php');
    exit;
}

// Handle Product Addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productBrand = $_POST['productBrand'];
    $productPrice = $_POST['productPrice'];

    // Initialize the Database
    require_once 'App/classes/Database.php';
    $db = new Database();

    // Insert product into the database
    $insertQuery = "INSERT INTO products (name, category_id, brand_id, price) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($insertQuery);
    $stmt->bind_param("siid", $productName, $productCategory, $productBrand, $productPrice);

    if ($stmt->execute()) {
        $successMessage = "Product added successfully!";
    } else {
        $errorMessage = "Error adding product. Please try again.";
    }
}
?>

<div class="container mx-auto mt-8 px-6">
    <!-- Page Heading -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Product Management</h1>
        <p class="text-gray-600">Create, view, and manage products for your invoices.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Card -->
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold">Category</h3>
            <p class="text-gray-600 mt-2">Manage your product categories efficiently.</p>
            <div class="mt-4 space-y-2">

                <a href="managecategory.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition inline-block">
                    Manage Category
                </a>
            </div>
        </div>

        <!-- Brand Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold">Brand</h3>
            <p class="text-gray-600 mt-2">Manage product brands seamlessly.</p>
            <div class="mt-4 space-y-2">
                <a href="manageBrand.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition inline-block">
                    Manage Brand
                </a>
            </div>
        </div>

        <!-- Product Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold">Product</h3>
            <p class="text-gray-600 mt-2">Manage your products effectively.</p>
            <div class="mt-4 space-y-2">
                <a href="manageProduct.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition inline-block">
                    Manage Product
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="productName" class="block text-gray-600 font-medium">Product Name</label>
                        <input type="text" name="productName" id="productName" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter product name" required>
                    </div>
                    <!-- Category -->
                    <div class="mb-4">
                        <label for="productCategory" class="block text-gray-600 font-medium">Category</label>
                        <select name="productCategory" id="productCategory" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            <?php
                            $categories = $db->query("SELECT id, name FROM categories");
                            while ($row = $categories->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Brand -->
                    <div class="mb-4">
                        <label for="productBrand" class="block text-gray-600 font-medium">Brand</label>
                        <select name="productBrand" id="productBrand" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Brand</option>
                            <?php
                            $brands = $db->query("SELECT id, name FROM brands");
                            while ($row = $brands->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Price -->
                    <div class="mb-4">
                        <label for="productPrice" class="block text-gray-600 font-medium">Price</label>
                        <input type="number" name="productPrice" id="productPrice" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter product price" required>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
