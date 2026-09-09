<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Details - DO2Shop</title>

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
            justify-content: space-between;
            align-items: center;
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

        .breadcrumb {
            max-width: 1200px;
            margin: 25px auto 0;
            padding: 0 25px;
            color: var(--muted);
            font-size: 14px;
        }

        .breadcrumb a {
            color: var(--orange);
            font-weight: 700;
        }

        .container {
            max-width: 1200px;
            margin: 25px auto 60px;
            padding: 0 25px;
        }

        .product-layout {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 30px;

            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 40px;
        }

        .image-area {
            background: #f3f4f6;
            border-radius: 10px;
            min-height: 420px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 420px;
            object-fit: contain;
        }

        .no-image {
            color: #9ca3af;
        }

        .category {
            display: inline-block;
            background: #fff3e6;
            color: var(--orange);
            padding: 6px 10px;
            border-radius: 20px;

            font-size: 12px;
            font-weight: 700;
            margin-bottom: 13px;
        }

        .product-name {
            font-size: 34px;
            color: var(--navy);
            margin-bottom: 15px;
        }

        .price {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 20px;
        }

        .description {
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .meta {
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 15px 0;
            margin-bottom: 22px;
        }

        .meta-row {
            margin-bottom: 8px;
        }

        .meta-row strong {
            color: var(--navy);
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 7px;
            font-weight: 800;
        }

        .btn-primary {
            background: var(--orange);
            color: white;
        }

        .btn-secondary {
            background: var(--navy);
            color: white;
        }

        .feedback {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 40px;
            text-align: center;
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

        @media (max-width: 850px) {
            .product-layout {
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
        <a href="{{ route('public.catalogue') }}">Catalogue</a>
        <a href="{{ route('public.contact') }}">Contact</a>
        <a href="{{ route('blade.login') }}">Account</a>
    </nav>

</header>


<div class="breadcrumb">

    <a href="{{ route('public.home') }}">
        Home
    </a>

    /

    <a href="{{ route('public.catalogue') }}">
        Catalogue
    </a>

    /

    Product Details

</div>


<main class="container">

    <div
        id="feedback"
        class="feedback"
    >
        Loading product details...
    </div>


    <div
        id="product-container"
        style="display:none;"
    ></div>

</main>


<footer>
    © {{ date('Y') }} DO2Shop. All Rights Reserved.
</footer>


<script>

    /*
    |--------------------------------------------------------------------------
    | PRODUCT ID FROM WEB ROUTE
    |--------------------------------------------------------------------------
    |
    | URL:
    |
    | /products/10
    |
    | produces:
    |
    | productId = 10
    |
    */

    const productId =
        "{{ request()->route('id') }}";


    /*
    |--------------------------------------------------------------------------
    | API ENDPOINT
    |--------------------------------------------------------------------------
    */

    const productEndpoint =
        "{{ url('/api/products') }}/" +
        productId;


    /*
    |--------------------------------------------------------------------------
    | HELPERS
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


    function extractProduct(payload) {

        if (!payload) {
            return null;
        }

        /*
         * Case:
         *
         * {
         *     data: {
         *         id: ...
         *     }
         * }
         */

        if (
            payload.data &&
            !Array.isArray(payload.data)
        ) {
            return payload.data;
        }


        /*
         * Case:
         *
         * {
         *     product: {
         *         id: ...
         *     }
         * }
         */

        if (payload.product) {
            return payload.product;
        }


        /*
         * Case:
         *
         * {
         *     id: ...
         * }
         */

        if (payload.id) {
            return payload;
        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD PRODUCT
    |--------------------------------------------------------------------------
    */

    async function loadProduct() {

        const feedback =
            document.getElementById(
                'feedback'
            );

        const container =
            document.getElementById(
                'product-container'
            );


        try {

            const response =
                await fetch(
                    productEndpoint,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            if (!response.ok) {

                if (response.status === 404) {

                    throw new Error(
                        'Product not found.'
                    );
                }


                throw new Error(
                    'Request failed with status ' +
                    response.status
                );
            }


            const payload =
                await response.json();


            const product =
                extractProduct(payload);


            if (!product) {

                throw new Error(
                    'Product data could not be read from the API response.'
                );
            }


            renderProduct(product);


            feedback.style.display =
                'none';


            container.style.display =
                'block';


        } catch (error) {

            feedback.className =
                'feedback error';


            feedback.textContent =
                error.message;

        }
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER PRODUCT
    |--------------------------------------------------------------------------
    */

    function renderProduct(product) {

        const container =
            document.getElementById(
                'product-container'
            );


        const categoryName =

            product.category?.name ??
            product.categoryName ??
            'Uncategorized';


        const status =

            product.is_active ??
            product.isActive ??
            false;


        const image = product.image

            ? `

                <img
                    src="${escapeHtml(product.image)}"
                    alt="${escapeHtml(product.name)}"
                    class="product-image"
                >

            `

            : `

                <span class="no-image">
                    No Image Available
                </span>

            `;


        container.innerHTML = `

            <section class="product-layout">


                <div class="image-area">

                    ${image}

                </div>


                <div>

                    <span class="category">

                        ${escapeHtml(categoryName)}

                    </span>


                    <h1 class="product-name">

                        ${escapeHtml(product.name)}

                    </h1>


                    <div class="price">

                        ${formatMoney(product.price)}

                    </div>


                    <p class="description">

                        ${escapeHtml(
                            product.description ??
                            'No description is available for this product.'
                        )}

                    </p>


                    <div class="meta">

                        <div class="meta-row">

                            <strong>
                                Product ID:
                            </strong>

                            ${escapeHtml(product.id)}

                        </div>


                        <div class="meta-row">

                            <strong>
                                Slug:
                            </strong>

                            ${escapeHtml(
                                product.slug ?? '-'
                            )}

                        </div>


                        <div class="meta-row">

                            <strong>
                                Category:
                            </strong>

                            ${escapeHtml(categoryName)}

                        </div>


                        <div class="meta-row">

                            <strong>
                                Status:
                            </strong>

                            <span class="
                                status
                                ${status ? 'active' : 'inactive'}
                            ">

                                ${status
                                    ? 'Available'
                                    : 'Unavailable'
                                }

                            </span>

                        </div>

                    </div>


                    <div class="actions">

                        <a
                            href="{{ route('public.catalogue') }}"
                            class="btn btn-secondary"
                        >
                            ← Back to Catalogue
                        </a>


                        <a
                            href="{{ route('public.contact') }}"
                            class="btn btn-primary"
                        >
                            Contact to Order
                        </a>

                    </div>

                </div>


            </section>

        `;
    }


    /*
    |--------------------------------------------------------------------------
    | START PAGE
    |--------------------------------------------------------------------------
    */

    loadProduct();

</script>

</body>
</html>