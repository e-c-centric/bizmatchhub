<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>BizMatch Hub - Cart</title>
    <style>
        .cart-container {
            padding: 50px 20px;
        }

        .cart-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .finalise-button {
            width: 100%;
            padding: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <header>
        <!-- Top Navbar -->
        <nav class="p-0 fixed-top text-white" id="top-nav">
            <div class="top-nav row mx-auto my-auto pt-3 pb-3 w-100 container-fluid text-white">
                <div class="toggle-btn col-auto text-white text-start p-0 d-md-none" style="cursor: pointer;"
                    id="nav-toggler">
                    <span class="bi bi-list fs-2 text-start ms-0 me-auto"></span>
                </div>
                <a href="index.php" class="nav-logo col-sm col-8 mx-auto mx-sm-0 text-sm-start text-center my-auto">
                    <div style="width: fit-content;" class="mx-auto mx-sm-0">
                        <img class="nav-logo-white d-block" src="./assets/svg/logo.png" alt="BizMatch Hub">
                        <img class="nav-logo-black d-none" src="./assets/svg/logo.png" alt="BizMatch Hub">
                    </div>
                </a>
                <ul class="d-none d-md-flex text-white col-auto row fw-semibold my-auto">
                    <li class="col-auto"><a href="#">BizMatch Hub Business</a></li>
                    <li class="col-auto"><a href="people.php">Explore</a></li>
                    <li class="col-auto d-none d-lg-block">
                        <svg width="18" height="18" fill="white" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="..."></path>
                        </svg>
                        English
                    </li>
                    <li class="col-auto d-none d-lg-block">GHS</li>
                    <li class="col-auto"><a href="#">Become a Seller</a></li>
                </ul>
                <a href="#" class="d-none d-sm-block text-white col-auto my-auto text-end fs-6 fw-semibold">Sign In</a>
                <a href="#"
                    class="join-btn col-auto my-auto text-white text-end fs-6 px-3 py-1 fw-semibold border border-1 border-white rounded-2">Join</a>
            </div>
        </nav>
        <!-- Options Nav -->
        <nav class="nav-options border-top border-bottom border-1 p-0 fixed-top d-none" id="nav-options">
            <div
                class="nav-options-content bg-white row d-flex mx-auto align-items-center align-middle my-auto px-4 w-100 container-fluid">
                <ul class="d-flex justify-content-between align-items-center my-auto flex-nowrap">
                    <li><a href="#">Graphics & Design</a></li>
                    <li><a href="#">Digital Marketing</a></li>
                    <li><a href="#">Writing & Translation</a></li>
                    <li><a href="#">Video & Animation</a></li>
                    <li><a href="#">Music & Audio</a></li>
                    <li><a href="#">Programming & Tech</a></li>
                    <li><a href="#">Business</a></li>
                    <li><a href="#">Lifestyle</a></li>
                    <li><a href="#">Trending</a></li>
                </ul>
            </div>
        </nav>
        <!-- Mobile Sidebar -->
        <nav class="mobile-nav text-nowrap" id="mobile-nav">
            <div class="fixed-top text-muted bg-white vh-100 px-3 pt-3" id="sidebar">
                <ul class="fw-normal d-flex flex-column mx-auto">
                    <li class="join-btn col-auto mt-2 mb-3 fs-6 px-3 w-80 py-2 fw-semibold text-white border rounded-2"
                        style="background-color: var(--primary--color-p);">
                        Join BizMatch Hub
                    </li>
                    <li class="col-auto my-2 fs-6"><a href="#">Sign in</a></li>
                    <li class="col-auto my-2 fs-6"><a href="people.php">Browse Categories</a></li>
                    <li class="col-auto my-2 fs-6"><a href="people.php">Explore</a></li>
                    <li class="col-auto my-2 fs-6" style="color: var(--primary--color);">
                        <a href="#">BizMatch Hub Business</a>
                    </li>
                </ul>
                <p class="fw-semibold text-black mt-4">General</p>
                <hr>
                <ul class="fw-normal d-flex flex-column mx-auto">
                    <li class="col-auto my-2 fs-6"><a href="#">Sign in</a></li>
                    <li class="col-auto my-2 fs-6" style="color: grey;">
                        <svg width="18" height="18" fill="grey" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="..."></path>
                        </svg>
                        English
                    </li>
                    <li class="col-auto my-2 fs-6"><a href="#">GHS</a></li>
                </ul>
            </div>
            <div class="mobile-nav-overlay d-none"></div>
        </nav>
    </header>

    <main class="mt-5 pt-5">
        <!-- Cart Section -->
        <section class="cart-container container">
            <h2 class="mb-4 text-center">Your Selected Freelancers</h2>
            <div id="cart-items">
                <!-- Cart items will be dynamically injected here -->
            </div>
            <button class="btn btn-success finalise-button" onclick="finaliseList()">Finalise List</button>
        </section>
    </main>

    <footer class="footer pt-5 pb-3 px-3 px-sm-4 px-md-5 border-top border-1 border-opacity-10 text-muted">
        <div class="footer-links d-flex flex-wrap justify-content-lg-between" style="column-gap: 15px;">
            <div class="mb-4 links-categories" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Categories</p>
                <ul>
                    <li><a href="#">Graphics & Design</a></li>
                    <li><a href="#">Digital Marketing</a></li>
                    <li><a href="#">Writing & Translation</a></li>
                    <li><a href="#">Video & Animation</a></li>
                    <li><a href="#">Music & Audio</a></li>
                    <li><a href="#">Programming & Tech</a></li>
                </ul>
            </div>
            <div class="mb-4 links-about" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">About</p>
                <ul>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press & News</a></li>
                    <li><a href="#">Partnerships</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="mb-4 links-support" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Support</p>
                <ul>
                    <li><a href="#">Help & Support</a></li>
                    <li><a href="#">Trust & Safety</a></li>
                    <li><a href="#">Selling on BizMatch Hub</a></li>
                    <li><a href="#">Buying on BizMatch Hub</a></li>
                </ul>
            </div>
            <div class="mb-4 links-community" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Community</p>
                <ul>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Forum</a></li>
                    <li><a href="#">Community Standards</a></li>
                    <li><a href="#">Podcast</a></li>
                </ul>
            </div>
            <div class="mb-4 links-more" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">More From BizMatch Hub</p>
                <ul>
                    <li><a href="#">BizMatch Hub Business</a></li>
                    <li><a href="#">BizMatch Hub Pro</a></li>
                    <li><a href="#">BizMatch Hub Studios</a></li>
                    <li><a href="#">BizMatch Hub Guides</a></li>
                    <li><a href="#">Get Inspired</a></li>
                    <li><a href="#">BizMatch Hub Select</a></li>
                </ul>
            </div>
        </div>
        <div
            class="footer-rights-wrapper py-3 my-auto border-top border-1 border-opacity-10 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between align-items-center">
            <div class="footer-rights d-flex flex-column flex-md-row justify-content-center align-items-center"
                style="gap: 18px;">
                <img src="./assets/svg/logo.png" alt="BizMatch Hub">
                <div class="text-center align-middle my-auto">© BizMatch Hub</div>
            </div>
            <div class="footer-social d-flex flex-column flex-md-row justify-content-center align-items-center"
                style="column-gap: 15px;">
                <ul class="d-flex align-items-center my-auto" style="gap: 10px;">
                    <li class="py-2 px-2">
                        <svg width="20" height="17" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path d="..."></path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path d="..."></path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="21" height="20" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path d="..."></path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path d="..."></path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path d="..."></path>
                            <path d="..."></path>
                            <path d="..."></path>
                        </svg>
                    </li>
                </ul>
                <ul class="d-flex align-items-center my-auto">
                    <li class="p-2">
                        <a href="#">
                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"
                                fill="grey">
                                <path d="..."></path>
                            </svg>
                            English
                        </a>
                    </li>
                    <li class="p-2">
                        <a href="#">GHS</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Custom Scripts -->
    <script src="./assets/utils/content.js"></script>
    <script src="./assets/script.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <!-- Cart Script -->
<script>
    // Define the people array with User 1
    window.people = [
      {
        id: 1,
        name: "Gideon Boakye",
        startingPrice: "$50",
        rating: 4.5,
        image: "img/silhouette.png",
        profileLink: "profile.php?id=1",
        phone: "+233 123 456 789",
        email: "gideon.boakye@example.com",
        numberOfJobs: 25,
        description: "Experienced graphic designer with a passion for creating stunning visuals. I have worked with numerous clients to bring their visions to life."
      }
      // Add other freelancers as needed
    ];

    // Function to load cart from localStorage and ensure User 1 is always in the cart
    function loadCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        // Retrieve cart from localStorage or initialize as empty array
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Ensure User 1 is always in the cart
        const user1 = window.people.find(p => p.id === 1);
        if (user1 && !cart.some(p => p.id === 1)) {
            cart.push(user1);
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('User 1 has been added to your cart.');
        }

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center">Your cart is empty.</p>';
            document.querySelector('.finalise-button').disabled = true;
            return;
        }

        cart.forEach(person => {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item d-flex align-items-center';

            // Check if the person is User 1
            const isUser1 = person.id === 1;

            cartItem.innerHTML = `
                <img src="${person.image}" alt="${person.name}">
                <div class="cart-item-details">
                    <h5>${person.name}</h5>
                    <p><strong>Starting Price:</strong> ${person.startingPrice}</p>
                    <p><strong>Rating:</strong> ${generateStars(person.rating)} (${person.rating})</p>
                </div>
                <button class="btn btn-danger" onclick="removeFromCart(${person.id})" ${isUser1 ? 'disabled title="User 1 cannot be removed."' : ''}>
                    <i class="bi bi-trash"></i> Remove
                </button>
            `;

            cartItemsContainer.appendChild(cartItem);
        });

        document.querySelector('.finalise-button').disabled = false;
    }

    // Function to remove item from cart
    function removeFromCart(id) {
        // Prevent removal of User 1
        if (id === 1) {
            alert('User 1 cannot be removed from the cart.');
            return;
        }

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(person => person.id !== id);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
    }

    // Function to finalise the list
    function finaliseList() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        // Handle the finalisation logic here (e.g., send data to the server)
        alert('Your list has been finalised.');

        // Clear the cart
        localStorage.removeItem('cart');
        loadCart();
    }

    // Function to generate star ratings
    function generateStars(rating) {
        const fullStars = Math.floor(rating);
        const halfStar = rating % 1 >= 0.5;
        let stars = '';

        for (let i = 0; i < fullStars; i++) {
            stars += '<i class="bi bi-star-fill text-warning"></i> ';
        }

        if (halfStar) {
            stars += '<i class="bi bi-star-half text-warning"></i> ';
        }

        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        for (let i = 0; i < emptyStars; i++) {
            stars += '<i class="bi bi-star text-warning"></i> ';
        }

        return stars;
    }

    // Initialize cart on page load
    window.onload = loadCart;
</script>
</body>

</html>