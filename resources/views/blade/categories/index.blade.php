@extends('layouts.frontend')

@section('title', 'Categories - Blade API Consumption')

@section('content')
    <h1>Categories</h1>
    <p class="muted">This page consumes the categories endpoint and displays category data in Blade.</p>
    <div id="feedback" class="message loading">Loading categories...</div>

    <table id="categories-table" style="display: none;">
        <thead>
            <tr><th>ID</th><th>Category Name</th><th>Slug</th></tr>
        </thead>
        <tbody id="categories-body"></tbody>
    </table>

    <script>
        const categoriesEndpoint = "{{ url('/api/categories') }}";

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function extractCategories(payload) {
            if (Array.isArray(payload)) return payload;
            if (Array.isArray(payload.data)) return payload.data;
            if (payload.data && Array.isArray(payload.data.data)) return payload.data.data;
            return [];
        }

        function renderCategories(categories) {
            const feedback = document.getElementById('feedback');
            const table = document.getElementById('categories-table');
            const tbody = document.getElementById('categories-body');
            tbody.innerHTML = '';

            if (categories.length === 0) {
                feedback.className = 'message empty';
                feedback.textContent = 'No categories were found.';
                table.style.display = 'none';
                return;
            }

            categories.forEach(function (category) {
                const row = `
                    <tr>
                        <td>${escapeHtml(category.id)}</td>
                        <td>${escapeHtml(category.name)}</td>
                        <td>${escapeHtml(category.slug)}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            feedback.style.display = 'none';
            table.style.display = 'table';
        }

        async function loadCategories() {
            const feedback = document.getElementById('feedback');
            try {
                const response = await fetch(categoriesEndpoint, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Request failed with status ' + response.status);
                const payload = await response.json();
                const categories = extractCategories(payload);
                renderCategories(categories);
            } catch (error) {
                feedback.className = 'message error';
                feedback.textContent = 'Unable to load categories. ' + error.message;
            }
        }

        loadCategories();
    </script>
@endsection