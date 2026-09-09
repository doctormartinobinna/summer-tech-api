@extends('layouts.api-panel')

@section('title', 'Categories - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>Categories</h1>
        <p class="muted">All logged-in users can view categories. Only admin can create categories.</p>
        <div id="category-feedback"></div>

        <form id="category-form" class="hidden">
            <h2>Create Category</h2>
            <div class="grid">
                <div>
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="slug">Category Slug</label>
                    <input type="text" id="slug" name="slug" required>
                </div>
            </div>
            <br>
            <button class="btn" type="submit">Create Category</button>
        </form>
    </div>

    <div class="card">
        <h2>Category List</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Name</th><th>Slug</th></tr>
            </thead>
            <tbody id="categories-body"></tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    let loggedInUser = null;

    document.addEventListener('DOMContentLoaded', async function () {
        try {
            loggedInUser = await requireAuth(['admin', 'manager', 'staff']);
            if (!loggedInUser) return;

            if (loggedInUser.role === 'admin') {
                document.getElementById('category-form').classList.remove('hidden');
            }

            await loadCategories();
        } catch (error) {
            showMessage('category-feedback', escapeHtml(error.message), 'error');
        }
    });

    async function loadCategories() {
        const payload = await apiRequest('/categories');
        const categories = Array.isArray(payload.data) ? payload.data : [];
        const tbody = document.getElementById('categories-body');
        tbody.innerHTML = '';

        categories.forEach(function (category) {
            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${escapeHtml(category.id)}</td>
                    <td>${escapeHtml(category.name)}</td>
                    <td>${escapeHtml(category.slug)}</td>
                </tr>
            `);
        });
    }

    document.getElementById('category-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        if (loggedInUser.role !== 'admin') {
            showMessage('category-feedback', 'Only admin can create categories.', 'error');
            return;
        }

        const formData = new FormData(this);
        const body = {
            name: formData.get('name'),
            slug: formData.get('slug')
        };

        try {
            const payload = await apiRequest('/categories', {
                method: 'POST',
                body: JSON.stringify(body)
            });

            showMessage('category-feedback', payload.message || 'Category created successfully.', 'success');
            this.reset();
            await loadCategories();
        } catch (error) {
            showMessage('category-feedback', escapeHtml(error.message) + validationErrorsToHtml(error.errors), 'error');
        }
    });
</script>
@endsection