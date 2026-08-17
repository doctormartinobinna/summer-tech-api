@extends('layouts.frontend')

@section('title', 'Products - Blade API Consumption')

@section('content')
    <h1>Products</h1>
    <p class="muted">
        This page is loading product data from the Laravel API and displaying it inside a Blade view.
    </p>

    <div id="feedback" class="message loading">
        Loading products, please wait...
    </div>

    <table id="products-table" style="display: none;">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="products-body"></tbody>

    </table>

    <script>
        const productsEndpoint = "{{ url('/api/products') }}";

        function formatMoney(value) {
            const amount = Number(value || 0);
            return new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            }).format(amount);
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function extractProducts(payload) {
            if (Array.isArray(payload)) return payload;
            if (Array.isArray(payload.data)) return payload.data;
            if (payload.data && Array.isArray(payload.data.data)) return payload.data.data;
            return [];
        }

        function renderProducts(products) {
            const feedback = document.getElementById('feedback');
            const table = document.getElementById('products-table');
            const tbody = document.getElementById('products-body');
           
            tbody.innerHTML = '';

            if (products.length === 0) {
                feedback.className = 'message empty';
                feedback.textContent = 'No products were found.';
                table.style.display = 'none';
                return;
            }

            products.forEach(function (product) {
                const image = product.image
                    ? `<img class="product-image" src="${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}">`
                    : '<span class="muted">No image</span>';

                const categoryName = product.category?.name ?? product.categoryName ?? 'No category';
                const status = product.isActive ?? product.is_active ? 'Active' : 'Inactive';

                const row = `
                    <tr>
                        <td>${image}</td>
                        <td>${escapeHtml(product.name)}</td>
                        <td>${escapeHtml(categoryName)}</td>
                        <td>${formatMoney(product.price)}</td>
                        <td>${escapeHtml(status)}</td>
                        <td><a class="btn" href="/blade-products/${product.id}">View</a></td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            feedback.style.display = 'none';
            table.style.display = 'table';
        }

        async function loadProducts() {
            const feedback = document.getElementById('feedback');
            
            try {
                const response = await fetch(productsEndpoint, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Request failed with status ' + response.status);
                const payload = await response.json();
                const products = extractProducts(payload);
                renderProducts(products);
            } catch (error) {
                feedback.className = 'message error';
                feedback.textContent = 'Unable to load products. ' + error.message;
            }
        }

        loadProducts();
    </script>
@endsection