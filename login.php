<?php require_once 'templates/header.php'; ?>
<?php
use App\classes\Session;

// Redirect if already logged in
if (isset($_SESSION['loginSuccess'])) {
    header('location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Account Receivable System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="text-center py-8 bg-blue-600 text-white shadow-lg">
        <h1 class="text-4xl font-bold">Welcome to Account Receivable System</h1>
    </header>

    <!-- Main Section -->
    <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between mt-10 space-y-8 lg:space-y-0 lg:space-x-8">

        <!-- Slideshow Section -->
        <div class="w-full lg:w-1/2">
            <div class="relative overflow-hidden rounded-lg shadow-lg">
                <!-- Slideshow -->
                <div class="mySlides hidden">
                    <img src="images/1.JPG" alt="Slide 1" class="w-full rounded-lg">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded">
                        Invoice Management
                    </div>
                </div>
                <div class="mySlides hidden">
                    <img src="images/2.JPG" alt="Slide 2" class="w-full rounded-lg">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded">
                        Financial Reporting
                    </div>
                </div>
                <div class="mySlides hidden">
                    <img src="images/3.JPG" alt="Slide 3" class="w-full rounded-lg">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded">
                        Payment Tracking
                    </div>
                </div>

                <!-- Navigation Dots -->
                <div class="flex justify-center space-x-2 mt-4">
                    <span class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></span>
                    <span class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></span>
                    <span class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></span>
                </div>
            </div>
        </div>

        <!-- Login Form -->
        <div class="w-full lg:w-1/2 bg-white shadow-lg p-8 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Login</h2>

            <!-- Display Message -->
            <?php if (isset($_GET["msg"]) && !empty($_GET["msg"])) { ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= $_GET["msg"]; ?>
                    <?= \App\classes\Session::get('UserId'); ?>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
            <?php } ?>

            <!-- Login Form -->
            <form action="" method="post" id="login_form" onsubmit="return false" autocomplete="off">
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <small id="e_error" class="form-text text-red-500"></small>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-600 font-medium">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <small id="p_error" class="form-text text-red-500"></small>
                </div>
                <button type="submit" id="login" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fa fa-lock mr-2"></i> Log In
                </button>
            </form>

            <!-- Registration Button -->
            <div class="mt-4 text-center">
                <a href="registration.php" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300 inline-block">
                    <i class="fa fa-user mr-2"></i> Register Here
                </a>
            </div>

            <!-- Forgot Password -->
            <div class="text-center mt-4">
                <a href="#" class="text-blue-500 hover:underline"><i class="fa fa-key mr-2"></i> Forgot Password?</a>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Slide Logic
        let slideIndex = 0;
        const showSlides = () => {
            const slides = document.querySelectorAll(".mySlides");
            const dots = document.querySelectorAll(".dot");

            slides.forEach((slide, index) => {
                slide.style.display = "none";
                dots[index].classList.remove("bg-blue-600");
            });

            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].style.display = "block";
            dots[slideIndex].classList.add("bg-blue-600");
        };

        setInterval(showSlides, 3000);
        showSlides();
    </script>
</body>
</html>
<?php require_once 'templates/footer.php'; ?>
