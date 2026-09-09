<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DO2Shop - Product Catalogue</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #061a3a;
            --navy-light: #0b2f66;
            --orange: #ff8500;
            --orange-dark: #e97100;
            --black: #111827;
            --text: #172033;
            --muted: #6b7280;
            --border: #e5e7eb;
            --background: #f7f8fb;
            --white: #ffffff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .site-header {
            background: white;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-inner {
            max-width: 1450px;
            margin: auto;
            min-height: 72px;
            padding: 10px 28px;
            display: grid;
            grid-template-columns: 260px minmax(300px, 1fr) auto;
            align-items: center;
            gap: 30px;
        }

        .logo {
            font-size: 31px;
            font-weight: 900;
            letter-spacing: -1px;
            color: var(--navy);
        }

        .logo .two {
            color: #2563eb;
        }

        .logo .orange {
            color: var(--orange);
        }

        .search-form {
            display: flex;
            border: 1px solid #cfd6e1;
            border-radius: 7px;
            overflow: hidden;
            background: white;
        }

        .search-form input {
            flex: 1;
            padding: 13px 16px;
            border: none;
            outline: none;
        }

        .search-form button {
            border: none;
            padding: 0 27px;
            background: var(--orange);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .search-form button:hover {
            background: var(--orange-dark);
        }

        .header-actions {
            display: flex;
            gap: 25px;
            align-items: center;
            font-weight: 700;
        }

        .header-action:hover {
            color: var(--orange);
        }

        /* =========================================================
           PAGE CONTAINER
        ========================================================= */

        .page {
            max-width: 1450px;
            margin: auto;
            padding: 20px 28px 40px;
        }

        /* =========================================================
           TOP SHOP AREA
        ========================================================= */

        .top-shop {
            display: grid;
            grid-template-columns: 270px minmax(0, 1fr) 270px;
            gap: 20px;
        }

        /* Categories */

        .categories-box {
            background: white;
            border: 1px solid var(--border);
            border-radius: 9px;
            overflow: hidden;
        }

        .categories-title {
            background: var(--navy);
            color: white;
            padding: 14px 17px;
            font-weight: 800;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            border-bottom: 1px solid var(--border);
        }

        .category-btn {
            width: 100%;
            min-height: 48px;
            border: none;
            background: white;
            cursor: pointer;
            display: grid;
            grid-template-columns: 34px 1fr auto;
            align-items: center;
            gap: 5px;
            padding: 9px 14px;
            text-align: left;
            font-weight: 600;
            color: var(--navy);
        }

        .category-btn:hover,
        .category-btn.active {
            background: #fff5ea;
            color: var(--orange);
        }

        .category-icon {
            font-size: 18px;
        }

        .category-loading {
            padding: 20px;
            color: var(--muted);
        }

        /* Hero */

        .hero {
            min-height: 360px;
            background:
                radial-gradient(circle at 80% 30%, #174fba 0%, transparent 35%),
                linear-gradient(120deg, #061a3a, #073d91);
            color: white;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero::after {
            content: "🛒";
            position: absolute;
            right: 10%;
            top: 50%;
            transform: translateY(-50%);
            font-size: 145px;
            opacity: .9;
        }

        .hero-content {
            padding: 55px 65px;
            width: 63%;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            display: inline-block;
            background: var(--orange);
            padding: 7px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 17px;
        }

        .hero h1 {
            font-size: 44px;
            line-height: 1.08;
            margin-bottom: 16px;
        }

        .hero p {
            line-height: 1.6;
            color: #e6edf8;
            margin-bottom: 24px;
        }

        .shop-now {
            display: inline-block;
            background: var(--orange);
            color: white;
            font-weight: 800;
            padding: 12px 20px;
            border-radius: 6px;
        }

        .hero-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 42px;
            width: 42px;
            border-radius: 50%;
            border: none;
            font-size: 25px;
            cursor: pointer;
            z-index: 3;
        }

        .hero-arrow.left {
            left: 14px;
        }

        .hero-arrow.right {
            right: 14px;
        }

        .hero-dots {
            position: absolute;
            left: 50%;
            bottom: 18px;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .hero-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .hero-dot.active {
            background: var(--orange);
            border-color: var(--orange);
        }

        /* Quick actions */

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .quick-card {
            flex: 1;
            background: white;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 19px;
            display: grid;
            grid-template-columns: 50px 1fr auto;
            gap: 13px;
            align-items: center;
        }

        .quick-card:hover {
            box-shadow: 0 8px 22px rgba(0,0,0,.07);
        }

        .quick-icon {
            width: 45px;
            height: 45px;
            border-radius: 9px;
            display: grid;
            place-items: center;
            background: var(--orange);
            color: white;
            font-size: 22px;
        }

        .quick-card:nth-child(2) .quick-icon {
            background: #22c55e;
        }

        .quick-card:nth-child(3) .quick-icon {
            background: #2563eb;
        }

        .quick-card h3 {
            font-size: 15px;
            margin-bottom: 5px;
            color: var(--navy);
        }

        .quick-card p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.4;
        }

        /* =========================================================
           PRODUCT SECTIONS
        ========================================================= */

        .product-section {
            margin-top: 18px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 9px;
            overflow: hidden;
        }

        .section-header {
            min-height: 54px;
            padding: 13px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .section-header h2 {
            font-size: 17px;
            text-transform: uppercase;
            color: var(--navy);
        }

        .section-link,
        .promo-label {
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            padding: 12px;
        }

        .product-card {
            min-height: 150px;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 12px;
            display: grid;
            grid-template-columns: 115px 1fr;
            gap: 14px;
            transition: .2s;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,.06);
        }

        .product-image-box {
            height: 115px;
            display: grid;
            place-items: center;
            background: #f8fafc;
            overflow: hidden;
            border-radius: 6px;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .no-image {
            font-size: 12px;
            color: #9ca3af;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-category {
            color: var(--orange);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .product-name {
            color: var(--navy);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .view-btn {
            align-self: flex-start;
            border: 1px solid #2563eb;
            color: #2563eb;
            padding: 7px 11px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
        }

        .feedback {
            grid-column: 1 / -1;
            padding: 30px;
            text-align: center;
            color: var(--muted);
        }

        .feedback.error {
            color: #b91c1c;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            margin-top: 25px;
            border-top: 7px solid var(--orange);
            background: var(--navy);
            color: white;
        }

        .footer-main {
            max-width: 1450px;
            margin: auto;
            padding: 35px 28px;
            display: grid;
            grid-template-columns: 280px minmax(400px, 1fr) 380px;
            gap: 50px;
        }

        .footer-logo {
            font-size: 31px;
            font-weight: 900;
            margin-bottom: 17px;
        }

        .footer-logo .two {
            color: #3b82f6;
        }

        .footer-logo .orange {
            color: var(--orange);
        }

        .footer p {
            color: #d1d5db;
            line-height: 1.5;
            font-size: 14px;
        }

        .footer h3 {
            color: var(--orange);
            margin-bottom: 9px;
            font-size: 16px;
        }

        .footer-links-inline {
            color: var(--orange);
        }

        .consent {
            margin: 12px 0;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            color: #d1d5db;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            margin: 12px 0;
        }

        .newsletter-form input {
            flex: 1;
            padding: 13px 14px;
            border-radius: 5px;
            border: none;
        }

        .newsletter-form button {
            background: var(--orange);
            border: none;
            color: white;
            padding: 0 23px;
            border-radius: 5px;
            font-weight: 800;
            cursor: pointer;
        }

        .app-row {
            display: flex;
            gap: 10px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        .app-badge {
            border: 1px solid #7c8798;
            background: #05070a;
            padding: 9px 15px;
            border-radius: 6px;
            font-size: 13px;
        }

        .socials {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .social {
            height: 33px;
            width: 33px;
            border-radius: 50%;
            background: white;
            color: var(--navy);
            display: grid;
            place-items: center;
            font-weight: 800;
        }

        .footer-bottom {
            background: #030b18;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .footer-bottom-inner {
            max-width: 1450px;
            margin: auto;
            padding: 17px 28px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            font-size: 12px;
            color: #d1d5db;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a:not(:last-child)::after {
            content: "|";
            color: var(--orange);
            margin-left: 20px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {
            .top-shop {
                grid-template-columns: 230px 1fr;
            }

            .quick-actions {
                grid-column: 1 / -1;
                flex-direction: row;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-main {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 760px) {
            .header-inner,
            .top-shop,
            .footer-main {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                flex-direction: column;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .hero-content {
                width: 100%;
                padding: 45px;
            }

            .hero::after {
                display: none;
            }

            .footer-bottom-inner {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<header class="site-header">
    <div class="header-inner">

        <a href="{{ route('public.home') }}" class="logo">
            DO<span class="two">2</span>SHOP<span class="orange">★</span>
        </a>

        <form id="search-form" class="search-form">
            <input
                id="search-input"
                type="search"
                placeholder="Search products..."
            >
            <button type="submit">Search</button>
        </form>

        <div class="header-actions">
            <a href="{{ route('blade.login') }}" class="header-action">
                ◯ Account
            </a>

            <a href="#" class="header-action">
                🛒 Cart
            </a>
        </div>

    </div>
</header>


<main class="page">

    <section class="top-shop">

        <!-- CATEGORIES -->
        <aside class="categories-box">

            <div class="categories-title">
                Categories
            </div>

            <ul id="category-list" class="category-list">
                <li class="category-loading">
                    Loading categories...
                </li>
            </ul>

        </aside>


        <!-- HERO -->
        <section class="hero">

            <button class="hero-arrow left" type="button">
                ‹
            </button>

            <div class="hero-content">

                <span class="hero-tag">
                    DO2 Shop
                </span>

                <h1>
                    Everything You Need,<br>
                    All in One Place.
                </h1>

                <p>
                    Browse our Product Catalogue and discover
                    products across our available categories.
                </p>

                <a
                    href="{{ route('public.products.index') }}"
                    class="shop-now"
                >
                    Shop Now
                </a>

            </div>

            <button class="hero-arrow right" type="button">
                ›
            </button>

            <div class="hero-dots">
                <span class="hero-dot active"></span>
                <span class="hero-dot"></span>
                <span class="hero-dot"></span>
                <span class="hero-dot"></span>
                <span class="hero-dot"></span>
            </div>

        </section>


        <!-- QUICK ACTIONS -->
        <aside class="quick-actions">

            <a
                href="{{ route('public.contact') }}"
                class="quick-card"
            >
                <div class="quick-icon">☎</div>

                <div>
                    <h3>Call to Order</h3>
                    <p>Contact us for help with your order.</p>
                </div>

                <span>›</span>
            </a>


            <a
                href="{{ route('blade.login') }}"
                class="quick-card"
            >
                <div class="quick-icon">⬆</div>

                <div>
                    <h3>Upload to Sell</h3>
                    <p>Authorized users can add products.</p>
                </div>

                <span>›</span>
            </a>


            <a
                href="{{ route('public.products.index') }}"
                class="quick-card"
            >
                <div class="quick-icon">🚚</div>

                <div>
                    <h3>Shop Packages</h3>
                    <p>Browse products available in our catalogue.</p>
                </div>

                <span>›</span>
            </a>

        </aside>

    </section>


    <!-- TOP SELLERS -->
    <section class="product-section">

        <div class="section-header">
            <h2 id="main-products-title">
                Top Sellers
            </h2>

            <span class="promo-label">
                UP TO 20% OFF
            </span>
        </div>

        <div
            id="top-sellers"
            class="products-grid"
        >
            <div class="feedback">
                Loading products...
            </div>
        </div>

    </section>


    <!-- LIMITED STOCK -->
    <section class="product-section">

        <div class="section-header">
            <h2>Limited Stock Deals</h2>

            <a
                href="{{ route('public.products.index') }}"
                class="section-link"
            >
                View All →
            </a>
        </div>

        <div
            id="limited-stock"
            class="products-grid"
        ></div>

    </section>


    <!-- NEW ARRIVALS -->
    <section class="product-section">

        <div class="section-header">
            <h2>New Arrivals</h2>

            <a
                href="{{ route('public.products.index') }}"
                class="section-link"
            >
                View All →
            </a>
        </div>

        <div
            id="new-arrivals"
            class="products-grid"
        ></div>

    </section>


    <!-- BEST RATED -->
    <section class="product-section">

        <div class="section-header">
            <h2>Best Rated Products</h2>

            <a
                href="{{ route('public.products.index') }}"
                class="section-link"
            >
                View All →
            </a>
        </div>

        <div
            id="best-rated"
            class="products-grid"
        ></div>

    </section>


    <!-- TRENDING -->
    <section class="product-section">

        <div class="section-header">
            <h2>Trending Now</h2>

            <a
                href="{{ route('public.products.index') }}"
                class="section-link"
            >
                View All →
            </a>
        </div>

        <div
            id="trending"
            class="products-grid"
        ></div>

    </section>

</main>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="footer">

    <div class="footer-main">

        <section>

            <div class="footer-logo">
                DO<span class="two">2</span>SHOP<span class="orange">★</span>
            </div>

            <p>
                Your one-stop shop for the best products across
                all our available categories.
            </p>

            <div class="socials">
                <a href="#" class="social">f</a>
                <a href="#" class="social">◎</a>
                <a href="#" class="social">𝕏</a>
                <a href="#" class="social">▶</a>
            </div>

        </section>


        <section>

            <h3>NEW TO DO2SHOP?</h3>

            <p>
                You can subscribe to our newsletter to get updates
                on our latest offers, deals and marketing campaigns.
            </p>

            <br>

            <p>
                To subscribe to our newsletter, you must first read
                and agree to DO2Shop's
                <span class="footer-links-inline">
                    Privacy Policy
                </span>
                and
                <span class="footer-links-inline">
                    Cookie Notice
                </span>.
            </p>

            <label class="consent">
                <input id="newsletter-consent" type="checkbox">

                <span>
                    I consent to DO2Shop processing my data
                    to send me newsletters.
                </span>
            </label>

            <form
                id="newsletter-form"
                class="newsletter-form"
            >

                <input
                    id="newsletter-email"
                    type="email"
                    placeholder="✉ Enter E-mail Address"
                    required
                >

                <button type="submit">
                    Subscribe
                </button>

            </form>

            <p id="newsletter-feedback"></p>

            <p>
                You can withdraw your consent at any time by
                clicking the Unsubscribe Link at the bottom
                of any email we send you.
            </p>

        </section>


        <section>

            <h3>DOWNLOAD DO2SHOP APP</h3>

            <p>
                Get access to exclusive offers!
            </p>

            <div class="app-row">

                <a href="#" class="app-badge">
                     Download on the<br>
                    <strong>App Store</strong>
                </a>

                <a href="#" class="app-badge">
                    ▶ GET IT ON<br>
                    <strong>Google Play</strong>
                </a>

            </div>

        </section>

    </div>


    <div class="footer-bottom">

        <div class="footer-bottom-inner">

            <span>
                © {{ date('Y') }} DO2Shop.
                All Rights Reserved.
            </span>

            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Cookie Notice</a>
                <a href="#">Terms & Conditions</a>
            </div>

        </div>

    </div>

</footer>


<script>

    /*
    |--------------------------------------------------------------------------
    | API ENDPOINTS
    |--------------------------------------------------------------------------
    */

    const categoriesEndpoint =
        "{{ url('/api/categories') }}";

    const productsEndpoint =
        "{{ url('/api/products') }}";


    /*
    |--------------------------------------------------------------------------
    | APPLICATION STATE
    |--------------------------------------------------------------------------
    */

    let allCategories = [];
    let allProducts = [];
    let selectedCategoryId = null;


    /*
    |--------------------------------------------------------------------------
    | HELPER: ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER: FORMAT MONEY
    |--------------------------------------------------------------------------
    */

    function formatMoney(value) {

        return new Intl.NumberFormat(
            'en-NG',
            {
                style: 'currency',
                currency: 'NGN'
            }
        ).format(
            Number(value || 0)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER: EXTRACT ARRAY FROM API RESPONSE
    |--------------------------------------------------------------------------
    */

    function extractArray(payload) {

        if (Array.isArray(payload)) {
            return payload;
        }

        if (Array.isArray(payload.data)) {
            return payload.data;
        }

        if (
            payload.data &&
            Array.isArray(payload.data.data)
        ) {
            return payload.data.data;
        }

        return [];
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY ID OF PRODUCT
    |--------------------------------------------------------------------------
    */

    function getProductCategoryId(product) {

        return Number(
            product.category_id ??
            product.category?.id ??
            0
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD CATEGORIES
    |--------------------------------------------------------------------------
    */

    async function loadCategories() {

        const categoryList =
            document.getElementById(
                'category-list'
            );

        try {

            const response =
                await fetch(
                    categoriesEndpoint,
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Unable to load categories.'
                );
            }


            const payload =
                await response.json();


            allCategories =
                extractArray(payload);


            renderCategories(
                allCategories.slice(0, 5)
            );

        } catch (error) {

            categoryList.innerHTML = `

                <li class="category-loading">

                    ${escapeHtml(error.message)}

                </li>

            `;

        }
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER CATEGORIES
    |--------------------------------------------------------------------------
    */

    function renderCategories(categories) {

        const categoryList =
            document.getElementById(
                'category-list'
            );


        categoryList.innerHTML = `

            <li class="category-item">

                <button
                    class="category-btn active"
                    data-category-id=""
                >
                    <span class="category-icon">▦</span>
                    <span>All Products</span>
                    <span>›</span>
                </button>

            </li>

        `;


        categories.forEach(
            function(category) {

                categoryList.insertAdjacentHTML(
                    'beforeend',
                    `

                    <li class="category-item">

                        <button
                            class="category-btn"
                            data-category-id="${category.id}"
                        >

                            <span class="category-icon">
                                ▣
                            </span>

                            <span>
                                ${escapeHtml(category.name)}
                            </span>

                            <span>›</span>

                        </button>

                    </li>

                    `
                );

            }
        );


        document
            .querySelectorAll('.category-btn')
            .forEach(
                function(button) {

                    button.addEventListener(
                        'click',
                        function() {

                            selectCategory(this);

                        }
                    );

                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT CATEGORY
    |--------------------------------------------------------------------------
    */

    function selectCategory(button) {

        document
            .querySelectorAll('.category-btn')
            .forEach(
                item =>
                    item.classList.remove(
                        'active'
                    )
            );


        button.classList.add('active');


        const id =
            button.dataset.categoryId;


        if (!id) {

            selectedCategoryId = null;

            document
                .getElementById(
                    'main-products-title'
                )
                .textContent =
                    'Top Sellers';


            renderAllProductGroups(
                allProducts
            );

            return;
        }


        selectedCategoryId =
            Number(id);


        const category =
            allCategories.find(

                item =>
                    Number(item.id) ===
                    selectedCategoryId

            );


        const products =
            allProducts.filter(

                product =>
                    getProductCategoryId(product)
                    === selectedCategoryId

            );


        document
            .getElementById(
                'main-products-title'
            )
            .textContent =

                category
                    ? category.name
                    : 'Products';


        /*
         * When category is selected, all
         * sections display products belonging
         * only to that category.
         */

        renderAllProductGroups(
            products
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD PRODUCTS
    |--------------------------------------------------------------------------
    */

    async function loadProducts() {

        try {

            const response =
                await fetch(
                    productsEndpoint,
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Unable to load products.'
                );
            }


            const payload =
                await response.json();


            allProducts =
                extractArray(payload);


            renderAllProductGroups(
                allProducts
            );

        } catch (error) {

            [
                'top-sellers',
                'limited-stock',
                'new-arrivals',
                'best-rated',
                'trending'
            ].forEach(
                function(id) {

                    document.getElementById(id)
                        .innerHTML = `

                            <div class="feedback error">

                                ${escapeHtml(
                                    error.message
                                )}

                            </div>

                        `;

                }
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TEMPORARY PRODUCT GROUPING
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | Our current Product table does not yet
    | appear to contain proper fields for:
    |
    | - top seller
    | - limited stock
    | - rating
    | - trending
    |
    | Therefore these groups are TEMPORARILY
    | derived from the products we already have.
    |
    | We can later make them database/API driven.
    |
    */

    function renderAllProductGroups(products) {

        const newest =
            [...products]
                .sort(
                    (a, b) =>
                        Number(b.id) -
                        Number(a.id)
                );


        const oldest =
            [...products]
                .sort(
                    (a, b) =>
                        Number(a.id) -
                        Number(b.id)
                );


        const expensive =
            [...products]
                .sort(
                    (a, b) =>
                        Number(b.price) -
                        Number(a.price)
                );


        const cheaper =
            [...products]
                .sort(
                    (a, b) =>
                        Number(a.price) -
                        Number(b.price)
                );


        /*
         * Temporary grouping:
         */

        const topSellers =
            products.slice(0, 4);


        const limited =
            cheaper.slice(0, 4);


        const newArrivals =
            newest.slice(0, 4);


        const bestRated =
            expensive.slice(0, 4);


        const trending =
            oldest.slice(-4).reverse();


        renderProducts(
            'top-sellers',
            topSellers
        );

        renderProducts(
            'limited-stock',
            limited
        );

        renderProducts(
            'new-arrivals',
            newArrivals
        );

        renderProducts(
            'best-rated',
            bestRated
        );

        renderProducts(
            'trending',
            trending
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER PRODUCT CARDS
    |--------------------------------------------------------------------------
    */

    function renderProducts(
        containerId,
        products
    ) {

        const container =
            document.getElementById(
                containerId
            );


        container.innerHTML = '';


        if (!products.length) {

            container.innerHTML = `

                <div class="feedback">

                    No products available.

                </div>

            `;

            return;
        }


        products.forEach(
            function(product) {


                const categoryName =

                    product.category?.name ??
                    product.categoryName ??
                    'Uncategorized';


                const image = product.image

                    ? `

                        <img
                            class="product-image"
                            src="${escapeHtml(product.image)}"
                            alt="${escapeHtml(product.name)}"
                        >

                    `

                    : `

                        <span class="no-image">
                            No image
                        </span>

                    `;


                const card = `

                    <article class="product-card">

                        <div class="product-image-box">
                            ${image}
                        </div>


                        <div class="product-details">

                            <div class="product-category">
                                ${escapeHtml(categoryName)}
                            </div>


                            <div class="product-name">
                                ${escapeHtml(product.name)}
                            </div>


                            <div class="product-price">
                                ${formatMoney(product.price)}
                            </div>


                            <a
                                href="/products/${product.id}"
                                class="view-btn"
                            >
                                View Product
                            </a>

                        </div>

                    </article>

                `;


                container.insertAdjacentHTML(
                    'beforeend',
                    card
                );

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT SEARCH
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('search-form')
        .addEventListener(
            'submit',
            function(event) {

                event.preventDefault();


                const search =

                    document
                        .getElementById(
                            'search-input'
                        )
                        .value
                        .trim()
                        .toLowerCase();


                if (!search) {

                    renderAllProductGroups(
                        allProducts
                    );

                    return;
                }


                const products =
                    allProducts.filter(
                        function(product) {

                            const name =
                                String(
                                    product.name ?? ''
                                ).toLowerCase();


                            const description =
                                String(
                                    product.description ?? ''
                                ).toLowerCase();


                            const category =
                                String(
                                    product.category?.name ??
                                    ''
                                ).toLowerCase();


                            return (
                                name.includes(search) ||
                                description.includes(search) ||
                                category.includes(search)
                            );

                        }
                    );


                document
                    .getElementById(
                        'main-products-title'
                    )
                    .textContent =
                        'Search Results';


                renderAllProductGroups(
                    products
                );

            }
        );


    /*
    |--------------------------------------------------------------------------
    | NEWSLETTER
    |--------------------------------------------------------------------------
    |
    | This currently demonstrates the frontend
    | interaction only.
    |
    | We can later create:
    |
    | POST /api/newsletter/subscribe
    |
    */

    document
        .getElementById(
            'newsletter-form'
        )
        .addEventListener(
            'submit',
            function(event) {

                event.preventDefault();


                const consent =
                    document
                        .getElementById(
                            'newsletter-consent'
                        )
                        .checked;


                const email =
                    document
                        .getElementById(
                            'newsletter-email'
                        )
                        .value;


                const feedback =
                    document
                        .getElementById(
                            'newsletter-feedback'
                        );


                if (!consent) {

                    feedback.textContent =
                        'Please provide consent before subscribing.';

                    feedback.style.color =
                        '#ffb15b';

                    return;
                }


                feedback.textContent =
                    `${email} has been prepared for newsletter subscription.`;

                feedback.style.color =
                    '#ffffff';

            }
        );


    /*
    |--------------------------------------------------------------------------
    | START PAGE
    |--------------------------------------------------------------------------
    */

    loadCategories();
    loadProducts();

</script>

</body>
</html>