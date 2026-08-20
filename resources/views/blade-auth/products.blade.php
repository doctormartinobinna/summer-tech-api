@extends('layouts.api-panel')

@section('title', 'Products - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>Products</h1>
        <p class="muted">Staff can view products. Manager and admin can create products.</p>
        <div id="product-feedback"></div>

        <form id="product-form" class="hidden" enctype="multipart/form-data">
            <h2>Create Product</h2>
            <div class="grid">
                <div>
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required></select>
                </div>
                <div>
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="name" required>
                </div>
                <div>
                    <label for="product_slug">Slug</label>
                    <input type="text" id="product_slug" name="slug" required>
                </div>
                <div>
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" required>
                </div>
                <div>
                    <label for="is_active">Status</label>
                    <select id="is_active" name="is_active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
            </div>
            <br>
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
            <br><br>
            <button class="btn" type="submit">Create Product</button>
        </form>
    </div>

    <div class="card">
        <h2>Product List</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="products-body"></tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    let currentUser = null;

    document.addEventListener('DOMContentLoaded', async function () {
        try {
            currentUser = await requireAuth(['admin', 'manager', 'staff']);
            if (!currentUser) return;

            await loadCategoriesIntoSelect();
            await loadProducts();

            if (currentUser.role === 'admin' || currentUser.role === 'manager') {
                document.getElementById('product-form').classList.remove('hidden');
            }
        } catch (error) {
            showMessage('product-feedback', escapeHtml(error.message), 'error');
        }
    });

    async function loadCategoriesIntoSelect() {
        const payload = await apiRequest('/categories');
        const categories = Array.isArray(payload.data) ? payload.data : [];
        const select = document.getElementById('category_id');
        select.innerHTML = '<option value="">Select category</option>';

        categories.forEach(function (category) {
            select.insertAdjacentHTML('beforeend', `
                <option value="${escapeHtml(category.id)}">${escapeHtml(category.name)}</option>
            `);
        });
    }

    async function loadProducts() {
        const payload = await apiRequest('/products');
        const products = Array.isArray(payload.data) ? payload.data : [];
        const tbody = document.getElementById('products-body');
        tbody.innerHTML = '';

        products.forEach(function (product) {
            const image = product.image
                ? `<img class="product-image" src="${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}">`
                : '<span class="muted">No image</span>';

            const categoryName = product.category?.name ?? 'No category';
            const status = (product.isActive ?? product.is_active) ? 'Active' : 'Inactive';

            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${image}</td>
                    <td>${escapeHtml(product.name)}</td>
                    <td>${escapeHtml(categoryName)}</td>
                    <td>${formatMoney(product.price)}</td>
                    <td>${escapeHtml(status)}</td>
                </tr>
            `);
        });
    }

    document.getElementById('product-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!(currentUser.role === 'admin' || currentUser.role === 'manager')) {
            showMessage('product-feedback', 'Only admin and manager can create products.', 'error');
            return;
        }

        const formData = new FormData(this);

        try {
            const payload = await apiRequest('/products', {
                method: 'POST',
                body: formData
            });

            showMessage('product-feedback', payload.message || 'Product created successfully.', 'success');
            this.reset();
            await loadCategoriesIntoSelect();
            await loadProducts();
        } catch (error) {
            showMessage('product-feedback', escapeHtml(error.message) + validationErrorsToHtml(error.errors), 'error');
        }
    });
</script>
@endsection