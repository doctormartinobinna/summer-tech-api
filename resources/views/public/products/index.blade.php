<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products - DO2Shop</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #061a3a;
            --orange: #ff8500;
            --border: #e5e7eb;
            --muted: #6b7280;
            --background: #f7f8fb;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: #172033;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .header {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 14px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
            color: var(--navy);
        }

        .logo .two {
            color: #2563eb;
        }

        .logo .star {
            color: var(--orange);
        }

        .nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav a {
            font-weight: 700;
            color: var(--navy);
        }

        .nav a:hover {
            color: var(--orange);
        }

        .hero {
            background: linear-gradient(120deg, #061a3a, #0b3b7c);
            color: white;
            padding: 55px 6%;
            text-align: center;
        }

        .hero h1 {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .hero p {
            color: #dbeafe;
        }

        .content {
            max-width: 1400px;
            margin: auto;
            padding: 35px 30px 60px;
        }

        .toolbar {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 15px;
            margin-bottom: 25px;
        }

        .search-box input,
        .category-filter select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 14px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            transition: .2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,.07);
        }

        .image-box {
            height: 220px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .no-image {
            color: #9ca3af;
            font-size: 13px;
        }

        .product-info {
            padding: 17px;
        }

        .category {
            color: var(--orange);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .product-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .description {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
            min-height: 40px;
            margin-bottom: 10px;
        }

        .price {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .view-btn {
            display: inline-block;
            padding: 9px 13px;
            background: var(--orange);
            color: white;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
        }

        .feedback {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: var(--muted);
        }

        .error {
            color: #b91c1c;
        }

        footer {
            background: var(--navy);
            border-top: 6px solid var(--orange);
            color: #d1d5db;
            text-align: center;
            padding: 28px;
        }

        @media (max-width: 1000px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .products-grid,
            .toolbar {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header class="header">

    <a href="{{ route('public.home') }}" class="logo">
        DO<span class="two">2</span>SHOP<span class="star">★</span>
    </a>

    <nav class="nav">
        <a href="{{ route('public.home') }}">Home</a>
        <a href="{{ route('public.products.index') }}">Products</a>
        <a href="{{ route('public.categories.index') }}">Categories</a>
        <a href="{{ route('public.contact') }}">Contact</a>
        <a href="{{ route('blade.login') }}">Account</a>
    </nav>

</header>


<section class="hero">

    <h1>All Products</h1>

    <p>
        Browse products available in the DO2Shop Product Catalogue.
    </p>

</section>


<main class="content">

    <div class="toolbar">

        <div class="search-box">
            <input
                type="search"
                id="search-input"
                placeholder="Search by product name, description or category..."
            >
        </div>

        <div class="category-filter">
            <select id="category-filter">
                <option value="">
                    All Categories
                </option>
            </select>
        </div>

    </div>


    <div
        id="products-grid"
        class="products-grid"
    >
        <div class="feedback">
            Loading products...
        </div>
    </div>

</main>


<footer>
    © {{ date('Y') }} DO2Shop. All Rights Reserved.
</footer>


<script>

    const productsEndpoint =
        "{{ url('/api/products') }}";

    const categoriesEndpoint =
        "{{ url('/api/categories') }}";

    let allProducts = [];


    function escapeHtml(value) {

        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }


    function formatMoney(value) {

        return new Intl.NumberFormat(
            'en-NG',
            {
                style: 'currency',
                currency: 'NGN'
            }
        ).format(Number(value || 0));
    }


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


    function getProductCategoryId(product) {

        return Number(
            product.category_id ??
            product.category?.id ??
            0
        );
    }


    async function loadCategories() {

        try {

            const response =
                await fetch(categoriesEndpoint, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });


            if (!response.ok) {
                throw new Error(
                    'Unable to load categories.'
                );
            }


            const payload =
                await response.json();


            const categories =
                extractArray(payload);


            const select =
                document.getElementById(
                    'category-filter'
                );


            categories.forEach(
                function(category) {

                    const option =
                        document.createElement(
                            'option'
                        );

                    option.value =
                        category.id;

                    option.textContent =
                        category.name;

                    select.appendChild(
                        option
                    );
                }
            );

        } catch (error) {

            console.error(error);

        }
    }


    async function loadProducts() {

        const grid =
            document.getElementById(
                'products-grid'
            );

        try {

            const response =
                await fetch(productsEndpoint, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });


            if (!response.ok) {

                throw new Error(
                    'Request failed with status ' +
                    response.status
                );
            }


            const payload =
                await response.json();


            allProducts =
                extractArray(payload);


            renderProducts(
                allProducts
            );


        } catch (error) {

            grid.innerHTML = `

                <div class="feedback error">

                    Unable to load products.

                    ${escapeHtml(error.message)}

                </div>

            `;
        }
    }


    function renderProducts(products) {

        const grid =
            document.getElementById(
                'products-grid'
            );


        grid.innerHTML = '';


        if (!products.length) {

            grid.innerHTML = `

                <div class="feedback">
                    No products were found.
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


                const description =

                    product.description ??
                    'No description available.';


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
                            No Image Available
                        </span>

                    `;


                const card = `

                    <article class="product-card">

                        <div class="image-box">
                            ${image}
                        </div>


                        <div class="product-info">

                            <div class="category">
                                ${escapeHtml(categoryName)}
                            </div>


                            <div class="product-name">
                                ${escapeHtml(product.name)}
                            </div>


                            <p class="description">
                                ${escapeHtml(description)}
                            </p>


                            <div class="price">
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


                grid.insertAdjacentHTML(
                    'beforeend',
                    card
                );

            }
        );
    }


    function applyFilters() {

        const search =
            document
                .getElementById(
                    'search-input'
                )
                .value
                .trim()
                .toLowerCase();


        const categoryId =
            document
                .getElementById(
                    'category-filter'
                )
                .value;


        const results =
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


                    const categoryName =
                        String(
                            product.category?.name ??
                            product.categoryName ??
                            ''
                        ).toLowerCase();


                    const matchesSearch =
                        !search ||
                        name.includes(search) ||
                        description.includes(search) ||
                        categoryName.includes(search);


                    const matchesCategory =
                        !categoryId ||
                        getProductCategoryId(product)
                        === Number(categoryId);


                    return (
                        matchesSearch &&
                        matchesCategory
                    );

                }
            );


        renderProducts(
            results
        );
    }


    document
        .getElementById(
            'search-input'
        )
        .addEventListener(
            'input',
            applyFilters
        );


    document
        .getElementById(
            'category-filter'
        )
        .addEventListener(
            'change',
            applyFilters
        );


    loadCategories();
    loadProducts();

</script>

</body>
</html>