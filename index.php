<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
use App\classes\Session;

// Ensure user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('location:login.php');
    exit;
}

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    $userId = $_SESSION['userId']; // Assuming userId is stored in session

    // Initialize the Database class (Assuming you have a class for database interaction)
    require_once 'App/classes/Database.php';
    $db = new Database();

    // Update user profile in the database
    if (!empty($userPassword)) {
        // If new password is provided, hash it
        $userPassword = password_hash($userPassword, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $db->prepare($updateQuery);
        $stmt->bind_param("sssi", $userName, $userEmail, $userPassword, $userId);
    } else {
        // If no password is provided, update only name and email
        $updateQuery = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $db->prepare($updateQuery);
        $stmt->bind_param("ssi", $userName, $userEmail, $userId);
    }

    if ($stmt->execute()) {
        // Update session variables with new data
        $_SESSION['UserName'] = $userName;
        $_SESSION['UserEmail'] = $userEmail;
        
        // Add success message or redirect (optional)
        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "There was an error updating your profile. Please try again.";
    }
}
?>

<div class="container mx-auto mt-6 px-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex justify-center">
                <img src="images/user.png" alt="User Image" class="w-24 h-24 rounded-full">
            </div>
            <div class="text-center mt-4">
                <h2 class="text-lg font-semibold">Profile</h2>
                <p class="text-gray-600"><i class="fas fa-user"></i> <?= Session::get('UserName') ?></p>
                <p class="text-gray-600"><i class="fas fa-user-tag"></i> <?= Session::get('UserType') ?></p>
                <p class="text-gray-600"><i class="fas fa-clock"></i> Last login - <?= Session::get('UserTime') ?></p>
                
                <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition" data-toggle="modal" data-target="#editProfileModal">
                  <i class="fas fa-pencil-alt"></i> Edit Profile
                  </button>

                  <!-- CREATE MODAL -->
                   <!-- Edit Profile Modal -->
                  <!-- Edit Profile Modal -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="index.php" method="POST" id="editProfileForm">
                                    <div class="mb-4">
                                        <label for="userName" class="block text-gray-600">Name</label>
                                        <input type="text" name="userName" id="userName" class="w-full px-4 py-2 border rounded-lg" value="<?= Session::get('UserName') ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="userEmail" class="block text-gray-600">Email</label>
                                        <input type="email" name="userEmail" id="userEmail" class="w-full px-4 py-2 border rounded-lg" value="<?= Session::get('UserEmail') ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="userPassword" class="block text-gray-600">New Password</label>
                                        <input type="password" name="userPassword" id="userPassword" class="w-full px-4 py-2 border rounded-lg">
                                    </div>
                                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Welcome Section -->
        <div class="col-span-2 bg-blue-50 shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600">Welcome</h1>
            <p class="text-gray-700 mt-2">Have a nice day!</p>
            <div class="flex mt-6 space-x-4">
            <div class="flex-shrink-0">
                  <iframe src="http://free.timeanddate.com/clock/i7g347a5/n1940/szw160/szh160/hoc444/cf100/hnceee" frameborder="0" width="160" height="160" class="pointer-events-none"></iframe>
            </div>

                <div class="bg-white shadow-md rounded-lg p-4 flex-grow">
                    <h3 class="text-lg font-semibold">Orders</h3>
                    <p class="text-gray-600 mb-4">Manage your orders seamlessly.</p>
                    <div class="space-y-2">
                        <a href="newOrder.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition inline-block">
                            <i class="fas fa-plus"></i> New Order
                        </a>
                        <a href="manageOrder.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition inline-block">
                            <i class="fas fa-magic"></i> Manage Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-8">

    <!-- Category, Brand, and Product Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold">Category</h3>
            <p class="text-gray-600 mt-2">Manage your product categories efficiently.</p>
            <div class="mt-4 space-y-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition" data-toggle="modal" data-target="#categoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
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
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition" data-toggle="modal" data-target="#brandModal">
                    <i class="fas fa-plus"></i> Add Brand
                </button>
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
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition" data-toggle="modal" data-target="#productModal">
                    <i class="fas fa-plus"></i> Add Product
                </button>
                <a href="manageProduct.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition inline-block">
                    Manage Product
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/categoryModal.php';?>
<?php require_once 'templates/brandModal.php';?>
<?php require_once 'templates/productModal.php';?>
<?php require_once 'templates/footer.php';?>
