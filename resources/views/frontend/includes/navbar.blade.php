@php
use App\Models\Cart;
@endphp

@push('ecomcss')
<link rel="stylesheet" href="{{ asset('frontend/css/navbar.css') }}">
@endpush

<!-- Desktop Navbar -->
<nav class="main-navbar" id="mainNavbar">
    <div class="navbar-content">
        <div class="container-fluid">
            <div class="row align-items-center ">
                <!-- Logo -->
                <div class="col-lg-2 col-md-2">
                    <div class="logo mx-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Logo' }}">
                        </a>
                    </div>
                </div>
                
                <!-- Categories -->
                <div class="col-lg-8 col-md-8 d-none d-md-block justify-content-center">
                    <ul class="category-list">
                         <li class="category-item">
                                <a href="{{ route('home') }}" class="">
                                    Home
                                </a>
                               
                                                </li>
                        @foreach ($categories->slice(0, 3) as $category)
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

                        
                    </ul>
                </div>

                

                <!-- Search -->
                <div class="col-lg-1 col-md-1 " style="">
                    <div class="search-container d-flex " style="margin-top: 9px;">
                        <input type="text" class="search-input" placeholder="Search" id="desktop-search">
                        <img style="height:20px;" src="{{ asset('frontend/images/search.png') }}" alt="">
                        <ul id="desktop-search-results" class="search-results"></ul>
                    </div>
                </div>
                
                <!-- User & Cart Icons -->
                <div class="col-lg-1 col-md-1" style="padding: 0px!important;">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="nav-icons d-flex align-items-center">
                            <div class="position-relative">
                                <a href="#" class="nav-icon user-icon">
                                    <img style="height:23px;" src="{{ asset('frontend/images/user.png') }}" alt="">

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
                                <img style="height:25px;" src="{{ asset('frontend/images/market.png') }}" alt="">

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
                    <img style="height:25px;" src="{{ asset('frontend/images/hamburger.png') }}" alt="">
                </a>
                <a href="#" class="nav-icon" id="mobile-search-toggle">
                    <img style="height:25px;" src="{{ asset('frontend/images/search.png') }}" alt="">
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
                        <img style="height:23px;" src="{{ asset('frontend/images/user.png') }}" alt="">
                    </a>
                    <div class="user-dropdown">
                        <ul>
                            @auth
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                {{-- <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li> --}}
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
                <a style="color: #000000;" href="#" class="nav-icon mobile-cart-icon" onclick="toggleCart(); return false;">
                   <img style="height:25px;" src="{{ asset('frontend/images/market.png') }}" alt="">
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
                            <i class="fas fa-times" style="color: #000000;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
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
                        <div class="category-info">
                            @if($category->icon)
                                <img src="{{ asset('storage/' . $category->icon) }}" 
                                     alt="{{ $category->name }}" 
                                     class="category-icon-img"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <i class="fas fa-folder category-icon-fallback" style="display: none;"></i>
                            @else
                                <i class="fas fa-folder category-icon-fallback"></i>
                            @endif
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                        <button class="category-toggle" onclick="toggleSubcategory(this)">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <ul class="subcategory-list">
                        @foreach($category->subcategories as $subcategory)
                            <li class="subcategory-item">
                                <a href="{{ route('subcategory.products', $subcategory->id) }}" class="subcategory-link">
                                    @if($subcategory->icon)
                                        <img src="{{ asset('storage/' . $subcategory->icon) }}" 
                                             alt="{{ $subcategory->name }}" 
                                             class="subcategory-icon-img"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                        <i class="fas fa-tag subcategory-icon-fallback" style="display: none;"></i>
                                    @else
                                        <i class="fas fa-tag subcategory-icon-fallback"></i>
                                    @endif
                                    <span class="subcategory-name">{{ $subcategory->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <!-- Category without subcategories -->
                    <a href="{{ route('category.products', $category->id) }}" class="category-link">
                        <div class="category-info">
                            @if($category->icon)
                                <img src="{{ asset('storage/' . $category->icon) }}" 
                                     alt="{{ $category->name }}" 
                                     class="category-icon-img"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <i class="fas fa-folder category-icon-fallback" style="display: none;"></i>
                            @else
                                <i class="fas fa-folder category-icon-fallback"></i>
                            @endif
                            <span class="category-name">{{ $category->name }}</span>
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
            <span id="cart-subtotal-amount">Tk0.00</span>
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
// Add this function to your navbar.blade.php
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count || 0;
        
        // Always show the cart count, even when it's 0
        element.style.display = 'flex';
        
        // Optional: You can add a class for styling when count is 0
        if (count === 0 || count === '0') {
            element.classList.add('empty-cart');
        } else {
            element.classList.remove('empty-cart');
        }
    });
}

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
                                        <a href="/product/details/${product.id}" style="text-decoration: none; font-weight: bold; color: #4f0808;">${product.product_name}</a>
                                        <div style="color: #4f0808; font-size: 14px;">Price: Tk${product.sale_price}</div>
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
                                    <div class="cart-item-price">Tk${price.toFixed(2)}</div>
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
                    cartSubtotalElement.textContent = `Tk${data.subtotal.toFixed(2)}`;
                    cartFooter.style.display = 'block';
                } else {
                    // Show empty cart message
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Your cart is empty</p>
                        </div>`;
                    cartSubtotalElement.textContent = 'Tk0.00';
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
        const price = parseFloat(priceText.replace('Tk', '').replace(',', ''));
        const quantity = parseInt(item.querySelector('.sidebar-quantity').textContent);
        subtotal += price * quantity;
    });

    const subtotalElement = document.getElementById('cart-subtotal-amount');
    if (subtotalElement) {
        subtotalElement.textContent = 'Tk' + subtotal.toFixed(2);
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