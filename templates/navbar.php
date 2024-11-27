<nav class="bg-blue-500 text-white">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">
        <a href="./index.php" class="text-xl font-bold">Account Receivable System</a>
        <!-- Toggle button for mobile view -->
        <button 
            class="lg:hidden text-white focus:outline-none" 
            type="button" 
            data-collapse-toggle="navbarNav"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
        <!-- Navbar Links -->
        <div id="navbarNav" class="hidden lg:flex lg:items-center">
            <ul class="flex flex-col lg:flex-row lg:space-x-4">
                <li>
                    <a 
                        href="./logout.php" 
                        onclick="return confirm('Are you sure?')" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition flex items-center"
                    >
                        Logout <i class="fa fa-key ml-2"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
