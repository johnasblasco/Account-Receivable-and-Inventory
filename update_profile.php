<?php
// Include necessary files
require_once 'templates/header.php';
require_once 'templates/navbar.php';
require_once 'App/classes/Session.php';  // Assuming Session is used for session management
require_once 'App/classes/Database.php'; // Assuming Database class for DB interaction

// Ensure the user is logged in
if (!isset($_SESSION['loginSuccess'])) {
    header('Location: login.php');
    exit;
}

// Get the user ID from the session
$userId = $_SESSION['userId'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Initialize the Database class
    $db = new Database();

    // If a new password is provided, hash it
    if (!empty($userPassword)) {
        $userPassword = password_hash($userPassword, PASSWORD_BCRYPT);
        // Update query with password change
        $updateQuery = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    } else {
        // Update query without password change
        $updateQuery = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    }

    // Prepare and execute the update query
    if ($stmt = $db->prepare($updateQuery)) {
        // If password is provided, bind all parameters including password
        if (!empty($userPassword)) {
            $stmt->bind_param("sssi", $userName, $userEmail, $userPassword, $userId);
        } else {
            // If no password, bind only name, email, and userId
            $stmt->bind_param("ssi", $userName, $userEmail, $userId);
        }

        // Execute the query
        if ($stmt->execute()) {
            // Update session data with the new name and email
            $_SESSION['UserName'] = $userName;
            $_SESSION['UserEmail'] = $userEmail;

            // Redirect to the profile page with success message
            header('Location: profile.php?success=1');
            exit;
        } else {
            // Handle error
            $error = "Error updating profile. Please try again.";
        }
    } else {
        // Error preparing the query
        $error = "Error preparing query. Please try again.";
    }
}
?>

<!-- Profile update form (can be placed anywhere in the layout) -->
<div class="container mx-auto mt-6 px-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-center mt-4">
                <h2 class="text-lg font-semibold">Profile</h2>
                <p class="text-gray-600"><i class="fas fa-user"></i> <?= Session::get('UserName') ?></p>
                <p class="text-gray-600"><i class="fas fa-user-tag"></i> <?= Session::get('UserType') ?></p>
                <p class="text-gray-600"><i class="fas fa-clock"></i> Last login - <?= Session::get('UserTime') ?></p>

                <?php if (isset($error)): ?>
                    <div class="bg-red-500 text-white p-2 rounded-lg mt-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition" data-toggle="modal" data-target="#editProfileModal">
                  <i class="fas fa-pencil-alt"></i> Edit Profile
                  </button>
            </div>
        </div>
    </div>
</div>

<?php
// Include modals, footer, and other required templates
require_once 'templates/categoryModal.php';
require_once 'templates/brandModal.php';
require_once 'templates/productModal.php';
require_once 'templates/footer.php';
?>
