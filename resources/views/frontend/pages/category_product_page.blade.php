@extends('frontend.master.master')

@section('keyTitle','Category Products')
@push('ecomcss')
<style>
    /* Category Grid Layout */
    .cat-grid-col {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 5px;
        width: calc(25% - 10px);
    }

    /* Product Box */
    .cat-product-box {
        position: relative;
        background: #fff;
        padding: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
        margin: 5px;
        width: 100%;
        border-radius: 8px;
    }

    .cat-product-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    /* Image Styles */
    .cat-product-image {
        position: relative;
        margin-bottom: 10px;
        height: 0;
        padding-bottom: 100%;
        overflow: hidden;
        border-radius: 6px;
    }

    .cat-product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .7s ease;
    }

    .cat-product-image:hover img {
        transform: scale(1.1);
    }

    .cat-primary-image {
        opacity: 1;
    }

    .cat-hover-image {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .cat-product-box:hover .cat-primary-image {
        opacity: 0;
    }

    .cat-product-box:hover .cat-hover-image {
        opacity: 1;
    }

    /* Product Badge */
    .cat-product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #333;
        color: #fff;
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 3px;
        z-index: 2;
    }

    /* Plus Button */
    .cat-plus-btn {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 50%;
        background: #9A0000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        z-index: 2;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(154, 0, 0, 0.3);
    }

    .cat-plus-btn i {
        color: white;
        font-size: 14px;
    }

    .cat-product-box:hover .cat-plus-btn {
        opacity: 1;
    }

    .cat-plus-btn:hover {
        background: #7A0000;
        transform: scale(1.1);
    }

    /* Product Info */
    .cat-product-info {
        padding: 5px 0;
        width: 100%;
    }

    .cat-product-title {
        font-size: 14px;
        margin-bottom: 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 100%;
        height: 20px;
        line-height: 20px;
        font-weight: 500;
    }

    .cat-product-price {
        width: 100%;
    }

    .cat-current-price {
        font-size: 14px;
        font-weight: 600;
        display: block;
        width: 100%;
        color: #9A0000;
    }

    .cat-original-price {
        font-size: 12px;
        color: #999;
        text-decoration: line-through;
        margin-left: 5px;
        display: inline-block;
    }

    .category-header {
        background-color: #fef5f0;
    }

    .category-header .container i {
        color: #9A0000;
    }

    /* Enhanced Filter Styles */
    .category-filters {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 1fr 200px 200px 200px;
        gap: 30px;
        align-items: end;
    }

    .filter-item {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 12px;
        display: block;
    }

    /* Enhanced Price Range Slider */
    .price-range-container {
        position: relative;
        width: 100%;
        padding: 20px 0;
    }

    .price-slider {
        height: 8px;
        width: 100%;
        background: #e9ecef;
        position: relative;
        border-radius: 20px;
        margin: 20px 0;
    }

    .price-progress {
        height: 100%;
        position: absolute;
        background: linear-gradient(45deg, #9A0000, #c40000);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .range-input {
        position: relative;
    }

    .range-input input {
        position: absolute;
        top: -10px;
        height: 8px;
        width: 100%;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        appearance: none;
    }

    .range-input input::-webkit-slider-thumb {
        height: 22px;
        width: 22px;
        border-radius: 50%;
        background: #9A0000;
        pointer-events: auto;
        -webkit-appearance: none;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(154, 0, 0, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .range-input input::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 6px 20px rgba(154, 0, 0, 0.6);
    }

    .price-inputs {
        display: flex;
        align-items: center;
        margin-top: 20px;
        gap: 15px;
    }

    .field {
        display: flex;
        align-items: center;
        height: 45px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0 15px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        flex: 1;
    }

    .field:focus-within {
        border-color: #9A0000;
        box-shadow: 0 0 0 4px rgba(154, 0, 0, 0.1);
    }

    .field span {
        font-size: 14px;
        font-weight: 600;
        color: #9A0000;
        margin-right: 8px;
    }

    .field input {
        width: 100%;
        background: none;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
    }

    /* Enhanced Sort By Filter */
    .sort-select {
        appearance: none;
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        background: white url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239A0000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") no-repeat;
        background-position: right 15px center;
        background-size: 18px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .sort-select:hover {
        border-color: #9A0000;
    }

    .sort-select:focus {
        border-color: #9A0000;
        box-shadow: 0 0 0 4px rgba(154, 0, 0, 0.1);
    }

    /* Enhanced Availability Filter */
    .availability-options {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .availability-checkbox {
        display: none;
    }

    .availability-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        padding: 12px 18px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        white-space: nowrap;
    }

    .availability-label:hover {
        border-color: #9A0000;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .availability-checkbox:checked + .availability-label {
        background: #9A0000;
        color: white;
        border-color: #9A0000;
        box-shadow: 0 4px 16px rgba(154, 0, 0, 0.3);
    }

    /* Enhanced Filter Actions */
    .filter-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .apply-filters-btn, .clear-filters-btn {
        padding: 14px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        text-align: center;
        white-space: nowrap;
    }

    .apply-filters-btn {
        background: linear-gradient(45deg, #9A0000, #c40000);
        color: white;
        box-shadow: 0 4px 16px rgba(154, 0, 0, 0.3);
    }

    .apply-filters-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(154, 0, 0, 0.4);
    }

    .clear-filters-btn {
        background: white;
        color: #6c757d;
        border: 2px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .clear-filters-btn:hover {
        background: #f8f9fa;
        border-color: #9A0000;
        color: #9A0000;
        transform: translateY(-2px);
    }

    /* Loading Spinner */
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px;
        font-size: 16px;
        color: #6c757d;
    }

    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #9A0000;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin-right: 15px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Results Count */
    .results-info {
        padding: 15px 0;
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .filter-row {
            grid-template-columns: 1fr 180px 180px 180px;
            gap: 20px;
        }
    }

    @media (max-width: 991px) {
        .cat-grid-col {
            flex: 0 0 33.333%;
            max-width: 33.333%;
            width: calc(33.333% - 10px);
        }

        .filter-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .availability-options {
            justify-content: center;
        }

        .filter-actions {
            flex-direction: row;
        }

        .apply-filters-btn, .clear-filters-btn {
            flex: 1;
        }
    }

    @media (max-width: 576px) {
        .cat-grid-col {
            flex: 0 0 50%;
            max-width: 50%;
            width: calc(50% - 10px);
        }

        .cat-product-title {
            font-size: 12px;
            height: 18px;
            line-height: 18px;
        }

        .cat-plus-btn {
            opacity: 1;
            width: 25px;
            height: 25px;
            bottom: 5px;
            right: 5px;
        }

        .cat-product-badge {
            font-size: 10px;
            padding: 3px 8px;
        }

        .cat-original-price {
            font-size: 10px;
            margin-left: 2px;
        }

        .category-filters {
            padding: 20px 15px;
        }

        .filter-actions {
            flex-direction: column;
        }
    }

    /* Enhanced Pagination */
    .pagination {
        justify-content: center;
        margin-top: 40px;
    }

    .pagination .page-link {
        border: none;
        padding: 10px 15px;
        margin: 0 2px;
        border-radius: 8px;
        color: #9A0000;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: #9A0000;
        color: white;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: #9A0000;
        border-color: #9A0000;
    }
    @media (max-width: 576px) {
    .category-filters {
        padding: 15px 10px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .filter-label {
        font-size: 13px;
        margin-bottom: 6px;
    }

    .filter-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .price-inputs {
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }

    .field {
        height: 38px;
        padding: 0 10px;
        font-size: 13px;
    }

    .field span {
        font-size: 13px;
    }

    .field input {
        font-size: 13px;
    }

    .sort-select {
        font-size: 13px;
        padding: 10px 14px;
        background-position: right 10px center;
        background-size: 14px;
    }

    .availability-label {
        padding: 10px 14px;
        font-size: 13px;
    }

    .filter-actions {
        gap: 8px;
    }

    .apply-filters-btn,
    .clear-filters-btn {
        font-size: 13px;
        padding: 10px 14px;
        border-radius: 8px;
    }

    .results-info {
        flex-direction: column;
        gap: 5px;
        font-size: 13px;
    }
}

</style>
@endpush

@section('contents')
<!-- Category Header -->
<section class="category-header py-4 d-none d-sm-block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumb-nav text-center">
                    <div class="breadcrumb-path">
                        <span>Home</span>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span>Category</span>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span>{{ $categoryName ?? 'Products' }}</span>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- Filter Section -->
    <div class="category-filters">
        <div class="filter-row">
            <!-- Price Range Filter -->
            <div class="filter-item">
                {{-- <label class="filter-label">
                    <i class="fas fa-tag me-1"></i>
                    Price Range
                </label> --}}
                <div class="price-range-container">
                    <div class="price-slider">
                        <div class="price-progress"></div>
                    </div>
                    <div class="range-input">
                        <input type="range" class="range-min" min="0" max="10000" value="{{ request('min_price', 0) }}" step="100">
                        <input type="range" class="range-max" min="0" max="10000" value="{{ request('max_price', 10000) }}" step="100">
                    </div>
                    <div class="price-inputs">
                        <div class="field">
                            <span>৳</span>
                            <input type="number" class="input-min" value="{{ request('min_price', 0) }}" min="0" placeholder="Min">
                        </div>
                        <div class="field">
                            <span>৳</span>
                            <input type="number" class="input-max" value="{{ request('max_price', 10000) }}" min="0" placeholder="Max">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sort By Filter -->
            <div class="filter-item">
                {{-- <label class="filter-label">
                    <i class="fas fa-sort me-1"></i>
                    Sort By
                </label> --}}
                <select class="sort-select" name="sort">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>

            <!-- Availability Filter -->
            <div class="filter-item">
                {{-- <label class="filter-label">
                    <i class="fas fa-check-circle me-1"></i>
                    Availability
                </label> --}}
                <div class="availability-options">
                    <input type="checkbox" id="in_stock" class="availability-checkbox" {{ request('in_stock') ? 'checked' : '' }}>
                    <label for="in_stock" class="availability-label">
                        <i class="fas fa-check"></i>
                        <span>In Stock</span>
                    </label>
                    <input type="checkbox" id="out_of_stock" class="availability-checkbox" {{ request('out_of_stock') ? 'checked' : '' }}>
                    {{-- <label for="out_of_stock" class="availability-label">
                        <i class="fas fa-times"></i>
                        <span>Out of Stock</span>
                    </label> --}}
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="filter-item">
                <div class="filter-actions">
                    <button class="apply-filters-btn" onclick="applyFilters()">
                        <i class="fas fa-filter me-1"></i>
                        Apply Filters
                    </button>
                    <button class="clear-filters-btn" onclick="clearFilters()">
                        <i class="fas fa-refresh me-1"></i>
                        Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="results-info">
        <span id="results-count">
            <i class="fas fa-cube me-1"></i>
            Showing {{ $product->count() }} of {{ $product->total() }} products
        </span>
        <span class="category-name">
            <i class="fas fa-folder me-1"></i>
            {{ $categoryName ?? 'All Products' }}
        </span>
    </div>

    <!-- Product Grid -->
    <div class="row">
        <div class="col-12">
            <div class="row product-list">
                @include('frontend.pages.category_product_partial', ['product' => $product])
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($product->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $product->links() }}
    </div>
    @endif
</div>

@endsection

@push('ecomjs')
<script>
    let isFilteringInProgress = false;

    document.addEventListener('DOMContentLoaded', function() {
        initializePriceRange();
        attachEventListeners();
    });

    function initializePriceRange() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const inputMin = document.querySelector('.input-min');
        const inputMax = document.querySelector('.input-max');
        
        if (rangeMin && rangeMax && inputMin && inputMax) {
            updatePriceProgress();
            
            rangeMin.addEventListener('input', handleRangeMinChange);
            rangeMax.addEventListener('input', handleRangeMaxChange);
            inputMin.addEventListener('input', handleInputMinChange);
            inputMax.addEventListener('input', handleInputMaxChange);
            
            rangeMin.addEventListener('change', debounce(applyFilters, 300));
            rangeMax.addEventListener('change', debounce(applyFilters, 300));
        }
    }

    function attachEventListeners() {
        const sortSelect = document.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', applyFilters);
        }

        const checkboxes = document.querySelectorAll('.availability-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', applyFilters);
        });
    }

    function handleRangeMinChange() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const inputMin = document.querySelector('.input-min');
        
        let minVal = parseInt(rangeMin.value);
        let maxVal = parseInt(rangeMax.value);
        
        if (minVal >= maxVal) {
            rangeMin.value = maxVal - 100;
            minVal = maxVal - 100;
        }
        
        inputMin.value = minVal;
        updatePriceProgress();
    }

    function handleRangeMaxChange() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const inputMax = document.querySelector('.input-max');
        
        let minVal = parseInt(rangeMin.value);
        let maxVal = parseInt(rangeMax.value);
        
        if (maxVal <= minVal) {
            rangeMax.value = minVal + 100;
            maxVal = minVal + 100;
        }
        
        inputMax.value = maxVal;
        updatePriceProgress();
    }

    function handleInputMinChange() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const inputMin = document.querySelector('.input-min');
        
        let minVal = parseInt(inputMin.value) || 0;
        let maxVal = parseInt(rangeMax.value);
        
        if (minVal < 0) {
            minVal = 0;
            inputMin.value = 0;
        }
        
        if (minVal >= maxVal) {
            minVal = maxVal - 100;
            inputMin.value = minVal;
        }
        
        rangeMin.value = minVal;
        updatePriceProgress();
    }

    function handleInputMaxChange() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const inputMax = document.querySelector('.input-max');
        
        let minVal = parseInt(rangeMin.value);
        let maxVal = parseInt(inputMax.value) || 10000;
        
        if (maxVal > 10000) {
            maxVal = 10000;
            inputMax.value = 10000;
        }
        
        if (maxVal <= minVal) {
            maxVal = minVal + 100;
            inputMax.value = maxVal;
        }
        
        rangeMax.value = maxVal;
        updatePriceProgress();
    }

    function updatePriceProgress() {
        const rangeMin = document.querySelector('.range-min');
        const rangeMax = document.querySelector('.range-max');
        const progress = document.querySelector('.price-progress');
        
        if (!rangeMin || !rangeMax || !progress) return;
        
        const minVal = parseInt(rangeMin.value);
        const maxVal = parseInt(rangeMax.value);
        const minPercent = (minVal / rangeMin.max) * 100;
        const maxPercent = (maxVal / rangeMax.max) * 100;
        
        progress.style.left = minPercent + '%';
        progress.style.width = (maxPercent - minPercent) + '%';
    }

    function applyFilters() {
        if (isFilteringInProgress) return;
        
        isFilteringInProgress = true;
        
        const productList = document.querySelector('.product-list');
        const resultsCount = document.getElementById('results-count');
        
        productList.innerHTML = `
            <div class="col-12">
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    Loading products...
                </div>
            </div>
        `;

        const minPrice = parseInt(document.querySelector('.input-min').value) || 0;
        const maxPrice = parseInt(document.querySelector('.input-max').value) || 10000;
        const sortBy = document.querySelector('.sort-select').value;
        const inStock = document.querySelector('#in_stock').checked;
        const outOfStock = document.querySelector('#out_of_stock').checked;

        const params = new URLSearchParams();
        
        // Only add parameters if they have values
        if (minPrice > 0) params.append('min_price', minPrice);
        if (maxPrice < 10000) params.append('max_price', maxPrice);
        if (sortBy && sortBy !== 'newest') params.append('sort', sortBy);
        if (inStock) params.append('in_stock', '1');
        if (outOfStock) params.append('out_of_stock', '1');

        const baseUrl = window.location.pathname;
        const url = params.toString() ? `${baseUrl}?${params.toString()}` : baseUrl;

        console.log('Applying filters with URL:', url); // Debug log

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status); // Debug log
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data); // Debug log
            if (data.success && data.html) {
                productList.innerHTML = data.html;
                
                if (resultsCount) {
                    resultsCount.innerHTML = `
                        <i class="fas fa-cube me-1"></i>
                        Showing ${data.count} of ${data.total} products
                    `;
                }
            } else {
                productList.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-3">No products found</h5>
                        <p class="text-muted mb-4">Try adjusting your filters or search criteria</p>
                        <button class="btn btn-primary" onclick="clearFilters()">
                            <i class="fas fa-refresh me-1"></i>
                            Clear Filters
                        </button>
                    </div>
                `;
                if (resultsCount) {
                    resultsCount.innerHTML = `
                        <i class="fas fa-cube me-1"></i>
                        Showing 0 products
                    `;
                }
            }

            window.history.pushState({}, '', url);
            
            document.querySelector('.category-filters').scrollIntoView({ 
                behavior: 'smooth' 
            });

            // showNotification('Filters applied successfully!', 'success');
        })
        .catch(error => {
            console.error('Filter Error:', error); // Debug log
            productList.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5 class="text-warning mb-3">Error loading products</h5>
                    <p class="text-muted mb-4">Please check your connection and try again</p>
                    <button class="btn btn-warning" onclick="applyFilters()">
                        <i class="fas fa-redo me-1"></i>
                        Retry
                    </button>
                </div>
            `;
            showNotification('Error loading products. Please try again.', 'error');
        })
        .finally(() => {
            isFilteringInProgress = false;
        });
    }

    function clearFilters() {
        document.querySelector('.input-min').value = 0;
        document.querySelector('.input-max').value = 10000;
        document.querySelector('.sort-select').value = 'newest';
        document.querySelector('#in_stock').checked = false;
        document.querySelector('#out_of_stock').checked = false;

        document.querySelector('.range-min').value = 0;
        document.querySelector('.range-max').value = 10000;
        updatePriceProgress();

        showNotification('Filters cleared!', 'info');
        applyFilters();
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

   

    window.addEventListener('popstate', function(event) {
        location.reload();
    });

    // Google Analytics tracking
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        event: 'page_view',
        page_type: 'category',
        category_id: @json($id),
        category_name: @json($categoryName ?? ''),
        currency: 'BDT',
        user_type: @json(Auth::check() ? 'registered' : 'guest'),
        user_id: @json(Auth::check() ? Auth::id() : null)
    });
</script>
@endpush