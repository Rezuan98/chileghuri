@php
use App\Models\Cart;
@endphp

@push('ecomcss')
<style>
    /* Desktop Navbar */
    .main-navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease-in-out;
        transform: translateY(0);
    }

    .main-navbar.navbar-hidden {
        transform: translateY(-100%);
    }

    .main-navbar.navbar-visible {
        transform: translateY(0);
    }

    .navbar-content {
        padding: 15px 0;
    }

    .logo img {
        height: 50px;
    }

    .search-container {
        position: relative;
        max-width: 400px;
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 2px solid #9A0000;
        border-radius: 25px;
        outline: none;
        font-size: 14px;
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #9A0000;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        color: white;
        cursor: pointer;
    }

    .category-list {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 20px;
    }

    .category-list a {
        color: #9A0000;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .category-list a:hover {
        color: #7A0000;
    }

    .nav-icons .nav-icon {
        color: #9A0000;
        font-size: 20px;
        margin: 0 8px;
        text-decoration: none;
        position: relative;
        transition: color 0.3s ease;
    }

    .nav-icons .nav-icon:hover {
        color: #7A0000;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #9A0000;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 50%;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-icons .social-link {
        color: #9A0000;
        margin: 0 5px;
        font-size: 16px;
        text-decoration: none;
        border: 1px solid rgba(154, 0, 0, 0.3);
        padding: 6px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #9A0000;
        color: white;
    }

    /* Mobile Navbar */
    .mobile-navbar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px 0;
    }

    .mobile-search {
        display: none;
        width: 100%;
        padding: 10px 0;
        border-top: 1px solid #f0f0f0;
    }

    .mobile-search .search-input {
        border: 2px solid #9A0000;
        border-radius: 15px;
        padding: 10px 15px;
        width: 100%;
    }

    .mobile-menu {
        position: fixed;
        top: 0;
        left: -300px;
        width: 300px;
        height: 100vh;
        background: white;
        z-index: 1100;
        transition: left 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .mobile-menu.open {
        left: 0;
    }

    .mobile-menu-header {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #9A0000;
        color: white;
    }

    .mobile-category-list {
        list-style: none;
        padding: 20px;
        margin: 0;
    }

    .mobile-category-list li {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .mobile-category-list a {
        color: #333;
        text-decoration: none;
        font-size: 16px;
    }

    .close-menu {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: white;
    }

    /* User Dropdown */
    .user-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        min-width: 200px;
        z-index: 1000;
    }

    .user-dropdown ul {
        list-style: none;
        margin: 0;
        padding: 10px 0;
    }

    .user-dropdown li a {
        display: block;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }

    .user-dropdown li a:hover {
        background: #f8f9fa;
        color: #9A0000;
    }

    /* Cart Sidebar */
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100vh;
        background: white;
        z-index: 1100;
        transition: right 0.3s ease;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .cart-sidebar.open {
        right: 0;
    }

    .cart-header {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #9A0000;
        color: white;
    }

    .close-cart {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: white;
    }
    .cart-count.hidden-no-space {
    display: none !important;
}


    .cart-content {
        padding: 20px;
        height: calc(100vh - 80px);
        overflow-y: auto;
    }

    .cart-footer {
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        background: #f8f9fa;
    }

    .cart-subtotal {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .cart-buttons {
        display: flex;
        gap: 10px;
    }

    .view-cart-btn, .checkout-btn {
        flex: 1;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .view-cart-btn {
        background: white;
        color: #9A0000;
        border: 2px solid #9A0000;
    }

    .checkout-btn {
        background: #9A0000;
        color: white;
        border: 2px solid #9A0000;
    }

    /* WhatsApp Float Button */
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 1000;
    }

    .whatsapp-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background-color: #25D366;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transition: all 0.3s ease;
    }

    .whatsapp-btn:hover {
        transform: scale(1.1);
        color: white;
    }

    /* Search Results */
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .search-results li {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 10px;
        cursor: pointer;
    }

    .search-results li:hover {
        background: #f8f9fa;
    }

    .search-results li img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }

    .search-results li a {
        font-weight: bold;
        text-decoration: none;
        color: #9A0000;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-navbar {
            display: none;
        }
        
        .mobile-navbar {
            display: block;
        }

        .cart-sidebar {
            width: 90%;
        }

        .mobile-menu {
            width: 90%;
        }

        .whatsapp-float {
            bottom: 20px;
            left: 20px;
        }

        .whatsapp-btn {
            width: 50px;
            height: 50px;
        }

        .whatsapp-btn i {
            font-size: 20px;
        }
    }

    /* Body padding for fixed navbar */
    body {
        padding-top: 80px;
    }

    @media (max-width: 768px) {
        body {
            padding-top: 70px;
        }
    }

    /* Hidden class for mobile search */
    .hidden-no-space {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
        padding: 0 !important;
        margin: 0 !important;
        flex: 0 0 0% !important;
    }

    
</style>
@endpush

<!-- Desktop Navbar -->
<nav class="main-navbar" id="mainNavbar">
    <div class="navbar-content">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-2 col-md-3">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Logo' }}">
                        </a>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="col-lg-4 col-md-4">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Search for products..." id="desktop-search">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                        <ul id="desktop-search-results" class="search-results"></ul>
                    </div>
                </div>
                
         <div class="col-lg-4 col-md-3 d-none d-md-block">
    <ul class="category-list">
        @foreach ($categories->slice(0, 4) as $category)
            <li class="category-item">
                <a href="#" class="{{ $category->subcategories->count() > 0 ? 'has-dropdown' : '' }}">
                    {{ $category->name }}
                </a>
                @if($category->subcategories->count() > 0)
  <div class="subcategory-dropdown">
    <div class="mega-inner">
      <ul>
        @foreach($category->subcategories->take(30) as $subcategory)
          <li>
            <a href="{{ route('subcategory.products', $subcategory->id) }}">{{ $subcategory->name }}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

            </li>
        @endforeach


    @if($brands->count() > 0)
<li class="category-item">
    <a href="#" class="has-dropdown">Brands</a>
    <div class="subcategory-dropdown">
        <div class="mega-inner">
            <ul>
            @foreach ($brands as $brand)
                <li>
                    <a href="{{ route('brand.products', $brand->id) }}">{{ $brand->name }}</a>
                </li>
            @endforeach
        </ul>
        </div>
    </div>
</li>
@endif
       
    </ul>
</div>
                
                <!-- Right Icons -->
                <div class="col-lg-2 col-md-2">
                    <div class="d-flex justify-content-end align-items-center">
                        <!-- Social Icons -->
                        <div class="social-icons d-none d-lg-flex me-3">
                            <a href="{{ $settings->facebook_url }}" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="{{ $settings->instagram_url }}" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        
                        <!-- User & Cart -->
                        <div class="nav-icons d-flex align-items-center">
                            <div class="position-relative">
                                <a href="#" class="nav-icon user-icon">
                                    <i class="fas fa-user"></i>
                                </a>
                                <div class="user-dropdown">
                                    <ul>
                                        @auth
                                            <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                            <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                            
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                                </form>
                                            </li>
                                        @else
                                            <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                            <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                            <li><a href="{{ route('user.login') }}">Login</a></li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                            <a href="#" class="nav-icon cart-icon" onclick="toggleCart(); return false;">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count">{{ auth()->check() ? 
                                    Cart::where('user_id', auth()->id())->sum('quantity') : 
                                    collect(session('cart', []))->sum('quantity') 
                                }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navbar -->
<nav class="mobile-navbar">
    <div class="container">
        <div class="row align-items-center" id="mobile-nav-row">
            <!-- Left Icons -->
            <div class="col-4 d-flex" id="mobile-left-icons">
                <a href="#" class="nav-icon me-3" id="mobile-menu-toggle">
                    <i style="color: #f2f2f2;" class="fas fa-bars"></i>
                </a>
                <a href="#" class="nav-icon" id="mobile-search-toggle">
                    <i style="color: #f2f2f2;" class="fas fa-search"></i>
                </a>
            </div>
            
            <!-- Center Logo -->
            <div class="col-4 text-center" id="mobile-logo">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Logo' }}" style="height: 40px;">
                    </a>
                </div>
            </div>
            
            <!-- Right Icons -->
            <div class="col-4 d-flex justify-content-end" id="mobile-right-icons">
                <div class="position-relative">
                    <a href="#" class="nav-icon me-3 mobile-user-icon">
                        <i style="color: #f2f2f2;" class="fas fa-user"></i>
                    </a>
                    <div class="user-dropdown">
                        <ul>
                            @auth
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.login') }}">Login</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <a style="color: #f2f2f2;" href="#" class="nav-icon mobile-cart-icon" onclick="toggleCart(); return false;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">{{ auth()->check() ? 
                        Cart::where('user_id', auth()->id())->sum('quantity'): 
                        collect(session('cart', []))->sum('quantity') 
                    }}</span>
                </a>
            </div>
        </div>
        
        <!-- Mobile Search Row -->
        <div class="mobile-search" id="mobile-search">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-10">
                        <input type="text" class="search-input" placeholder="Search for products..." id="mobile-search-input">
                        <ul id="mobile-search-results" class="search-results" style="margin-top: 5px;"></ul>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn" id="close-search">
                            <i class="fas fa-times" style="color: #fefefe;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-header">
        <h5>Categories</h5>
        <button class="close-menu" id="close-mobile-menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="mobile-category-list">
        @foreach ($categories->take(8) as $category)
            <li class="category-item">
                @if($category->subcategories && $category->subcategories->count() > 0)
                    <!-- Category with subcategories -->
                    <div class="category-link">
                        <div>
                            <i class="fas fa-folder category-icon"></i>
                            <span>{{ $category->name }}</span>
                        </div>
                        <button class="category-toggle" onclick="toggleSubcategory(this)">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <ul class="subcategory-list">
                        @foreach($category->subcategories as $subcategory)
                            <li class="subcategory-item">
                                <a href="{{ route('category.products', $subcategory->id) }}" class="subcategory-link">
                                    {{ $subcategory->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <!-- Category without subcategories -->
                    <a href="{{ route('category.products', $category->id) }}" class="category-link">
                        <div>
                            <i class="fas fa-folder category-icon"></i>
                            <span>{{ $category->name }}</span>
                        </div>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<!-- Cart Sidebar -->
<div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h5>Shopping Cart</h5>
        <button class="close-cart" onclick="toggleCart()">×</button>
    </div>
    <div class="cart-content">
        <div class="cart-items">
            <!-- Cart items will be dynamically populated here -->
        </div>
    </div>
    <div class="cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal:</span>
            <span id="cart-subtotal-amount">৳0.00</span>
        </div>
        <div class="cart-buttons">
            <a href="{{ route('cart.index') }}" class="view-cart-btn">View Cart</a>
            <a href="{{ route('shipping') }}" class="checkout-btn">Checkout</a>
        </div>
    </div>
</div>

<!-- WhatsApp Float Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings->phone) }}?text=Hello%20{{ $settings->site_name ?? 'Scinan' }}%2C%20I%20need%20help%20with..." target="_blank" class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

@push('ecomjs')
<script>
    // Scroll Effect for Navbar
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('mainNavbar');
        let lastScrollTop = 0;
        let scrollThreshold = 150;

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > scrollThreshold) {
                if (scrollTop > lastScrollTop) {
                    // Scrolling down - hide navbar
                    navbar.classList.add('navbar-hidden');
                    navbar.classList.remove('navbar-visible');
                } else {
                    // Scrolling up - show navbar
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
            } else {
                // At top - always show navbar
                navbar.classList.remove('navbar-hidden');
                navbar.classList.add('navbar-visible');
            }

            lastScrollTop = scrollTop;
        });
    });

    // Mobile menu toggle
    document.getElementById('mobile-menu-toggle').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('mobile-menu').classList.add('open');
    });

    // Close mobile menu
    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.remove('open');
    });

    // Mobile search toggle
  document.getElementById('mobile-search-toggle').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('mobile-left-icons').classList.add('hidden-no-space');
    document.getElementById('mobile-right-icons').classList.add('hidden-no-space');
    document.getElementById('mobile-logo').classList.add('hidden-no-space');
    document.querySelector('.mobile-cart-icon .cart-count')?.classList.add('hidden-no-space');
    document.getElementById('mobile-search').style.display = 'block';
    document.getElementById('mobile-search-input').focus();
});


    // Close mobile search
   document.getElementById('close-search').addEventListener('click', function() {
    document.getElementById('mobile-left-icons').classList.remove('hidden-no-space');
    document.getElementById('mobile-right-icons').classList.remove('hidden-no-space');
    document.getElementById('mobile-logo').classList.remove('hidden-no-space');
    document.querySelector('.mobile-cart-icon .cart-count')?.classList.remove('hidden-no-space');
    document.getElementById('mobile-search').style.display = 'none';
    document.getElementById('mobile-search-results').style.display = 'none';
});


    // Cart toggle function
    function toggleCart() {
        const cart = document.getElementById('cart-sidebar');
        cart.classList.toggle('open');
        updateCartSidebar();
    }

    // User dropdown toggle
    document.querySelectorAll('.user-icon, .mobile-user-icon').forEach(function(icon) {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-icon') && !e.target.closest('.mobile-user-icon')) {
            document.querySelectorAll('.user-dropdown').forEach(function(dropdown) {
                dropdown.style.display = 'none';
            });
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('mobile-menu');
        const toggle = document.getElementById('mobile-menu-toggle');
        if (!menu.contains(e.target) && !toggle.contains(e.target)) {
            menu.classList.remove('open');
        }
    });

    // Close cart when clicking outside
    document.addEventListener('click', function(e) {
        const cart = document.getElementById('cart-sidebar');
        const cartIcons = document.querySelectorAll('.cart-icon, .mobile-cart-icon');
        let clickedCart = false;
        cartIcons.forEach(function(icon) {
            if (icon.contains(e.target)) clickedCart = true;
        });
        if (!cart.contains(e.target) && !clickedCart) {
            cart.classList.remove('open');
        }
    });

    // Live search functionality
    function setupSearch(inputId, resultsId) {
        const searchInput = document.getElementById(inputId);
        const searchResults = document.getElementById(resultsId);

        if (!searchInput || !searchResults) return;

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();

            if (query.length > 2) {
                fetch(`/live-search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(product => {
                                const listItem = document.createElement('li');
                                listItem.className = 'list-group-item p-2';
                                listItem.innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <img 
                                            src="${location.origin}/uploads/products/${product.product_image}" 
                                            alt="${product.product_name}" 
                                            style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 5px;"
                                            onerror="this.src='/path/to/placeholder.jpg';"
                                        >
                                        <div>
                                            <a href="/product/details/${product.id}" style="text-decoration: none; font-weight: bold; color: #9A0000;">${product.product_name}</a>
                                            <div style="color: #9A0000; font-size: 14px;">Price: ৳${product.sale_price}</div>
                                        </div>
                                    </div>
                                `;
                                searchResults.appendChild(listItem);
                            });
                            searchResults.style.display = 'block';
                        } else {
                            const noResultsItem = document.createElement('li');
                            noResultsItem.className = 'list-group-item';
                            noResultsItem.textContent = 'No results found';
                            searchResults.appendChild(noResultsItem);
                            searchResults.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        searchResults.style.display = 'none';
                    });
            } else {
                searchResults.style.display = 'none';
            }
        });
    }

    // Initialize search for both desktop and mobile
    setupSearch('desktop-search', 'desktop-search-results');
    setupSearch('mobile-search-input', 'mobile-search-results');

    // Cart sidebar update function
    function updateCartSidebar() {
        console.log('Updating cart sidebar...');
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        const searchContainers = document.querySelectorAll('.search-container, .mobile-search');
        searchContainers.forEach(container => {
            if (!container.contains(e.target)) {
                const results = container.querySelector('.search-results');
                if (results) results.style.display = 'none';
            }
        });
    });





    // Update Cart Sidebar Content
function updateCartSidebar() {
    fetch('/cart/items')
        .then(response => response.json())
        .then(data => {
            if (data.success) {

                // const cartCountElements = document.querySelectorAll('.cart-count');
                // cartCountElements.forEach(element => {
                //     element.textContent = data.cartCount;
                // });
                const cartItemsContainer = document.querySelector('.cart-items');
                const cartSubtotalElement = document.getElementById('cart-subtotal-amount');
                const cartFooter = document.querySelector('.cart-footer');

                // Clear existing cart items
                cartItemsContainer.innerHTML = '';

                // Convert cartItems to array
                const cartItemsArray = Array.isArray(data.cartItems) ? data.cartItems : Object.values(data.cartItems);

                if (cartItemsArray.length > 0) {
                    cartItemsArray.forEach(item => {
                        const price = parseFloat(item.price) || 0;
                        const productImage = item.product?.product_image || item.product_image || 'default.png';
                        const productName = item.product?.product_name || item.product_name || 'N/A';
                        const variantSize = item.variant?.size?.name || item.variant?.size || 'N/A';
                        const variantColor = item.variant?.color?.name || item.variant?.color || 'N/A';

                        const cartItemHTML = `
                            <div class="cart-item">
                                <img src="/uploads/products/${productImage}" alt="Product Image" class="cart-item-image">
                                <div class="cart-item-details">
                                    <h6 class="cart-item-title">${productName}</h6>
                                    <p class="cart-item-variant">${variantSize}-${variantColor}</p>
                                    <div class="cart-item-price">৳${price.toFixed(2)}</div>
                                    <div class="cart-item-actions">
                                        <div class="quantity-controls">
                                            <button onclick="updateSidebarQuantity('${item.id}', 'decrease')">-</button>
                                            <span class="sidebar-quantity" data-id="${item.id}">${item.quantity || 1}</span>
                                            <button onclick="updateSidebarQuantity('${item.id}', 'increase')">+</button>
                                        </div>
                                        <button class="remove-item" onclick="removeSidebarItem('${item.id}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                        cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
                    });

                    // Update subtotal and show footer
                    cartSubtotalElement.textContent = `৳${data.subtotal.toFixed(2)}`;
                    cartFooter.style.display = 'block';
                } else {
                    // Show empty cart message
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Your cart is empty</p>
                        </div>`;
                    cartSubtotalElement.textContent = '৳0.00';
                    cartFooter.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
}

// Update Sidebar Quantity
async function updateSidebarQuantity(itemId, action) {
    
    const quantityElement = document.querySelector(`.sidebar-quantity[data-id="${itemId}"]`);
    let newValue = parseInt(quantityElement.textContent);

    if (action === 'increase' && newValue < 10) {
        newValue++;
    } else if (action === 'decrease' && newValue > 1) {
        newValue--;
    } else {
        return;
    }

    try {
        const response = await fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                cart_id: itemId,
                quantity: newValue
            })
        });

        const data = await response.json();

        if (data.success) {
           
            // Update quantity display
            quantityElement.textContent = newValue;
        
            // Update cart count
            // updateCartCount(data.cartCount);
            
            const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.cartCount;
                });
            
            // Update subtotal
            updateCartSubtotal();
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
    }
}

// Remove Item from Sidebar
async function removeSidebarItem(itemId) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    try {
        const response = await fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                cart_id: itemId
            })
        });

        const data = await response.json();

        if (data.success) {
            // Remove the item from the sidebar
            const cartItem = document.querySelector(`.sidebar-quantity[data-id="${itemId}"]`).closest('.cart-item');
            cartItem.remove();

            // Update cart count
            const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.cartCount;
                });

            // Update subtotal
            updateCartSubtotal();

            // Check if cart is empty
            const remainingItems = document.querySelectorAll('.cart-item');
            if (remainingItems.length === 0) {
                const cartItemsContainer = document.querySelector('.cart-items');
                cartItemsContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Your cart is empty</p>
                    </div>`;
                document.querySelector('.cart-footer').style.display = 'none';
            }
        }
    } catch (error) {
        console.error('Error removing item:', error);
    }
}

// Update Cart Subtotal
function updateCartSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const priceText = item.querySelector('.cart-item-price').textContent;
        const price = parseFloat(priceText.replace('৳', '').replace(',', ''));
        const quantity = parseInt(item.querySelector('.sidebar-quantity').textContent);
        subtotal += price * quantity;
    });

    const subtotalElement = document.getElementById('cart-subtotal-amount');
    if (subtotalElement) {
        subtotalElement.textContent = '৳' + subtotal.toFixed(2);
    }
}

// Show Notification
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Close cart when clicking outside
document.addEventListener('click', function(e) {
    const cart = document.getElementById('cart-sidebar');
    const cartIcon = document.querySelector('.cart-icon');
    
    if (!cart.contains(e.target) && !cartIcon.contains(e.target)) {
        cart.classList.remove('active');
    }
});

// Initialize cart sidebar on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load cart count on page load
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.count);
            }
        })
        .catch(error => console.error('Error loading cart count:', error));
});



function toggleSubcategory(button) {
    const subcategoryList = button.parentElement.nextElementSibling;
    const isOpen = subcategoryList.classList.contains('show');
    
    // Close all other subcategories
    document.querySelectorAll('.subcategory-list').forEach(list => {
        list.classList.remove('show');
    });
    document.querySelectorAll('.category-toggle').forEach(toggle => {
        toggle.classList.remove('active');
    });
    
    // Toggle current subcategory
    if (!isOpen) {
        subcategoryList.classList.add('show');
        button.classList.add('active');
    }
}


</script>
@endpush