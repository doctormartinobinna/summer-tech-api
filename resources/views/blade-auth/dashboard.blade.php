@extends('layouts.api-panel')

@section('title', 'Dashboard - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>Dashboard</h1>
        <p class="muted">This page checks the logged-in user through the API and displays role-based access.</p>
        <div id="dashboard-feedback" class="message loading">Loading dashboard...</div>
        
        <div id="dashboard-content" class="hidden"></div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        try {
            const user = await requireAuth();
            if (!user) return;

            let permissions = '';

            if (user.role === 'admin') {
                permissions = `
                    <li>Create users</li>
                    <li>Create categories</li>
                    <li>Create products</li>
                    <li>Update user roles</li>
                    <li>View profile, products, and categories</li>
                `;
            } else if (user.role === 'manager') {
                permissions = `
                    <li>Create and update products</li>
                    <li>View profile, products, and categories</li>
                `;
            } else {
                permissions = `
                    <li>View personal profile</li>
                    <li>View products</li>
                    <li>View categories</li>
                `;
            }

            document.getElementById('dashboard-content').innerHTML = `
                <h2>Welcome, ${escapeHtml(user.name)}</h2>
                <p>Your role is <strong>${escapeHtml(user.role)}</strong>.</p>
                <h3>Your access in this project</h3>
                <ul>${permissions}</ul>
            `;

            document.getElementById('dashboard-feedback').style.display = 'none';
            document.getElementById('dashboard-content').classList.remove('hidden');
        } catch (error) {
            showMessage('dashboard-feedback', escapeHtml(error.message), 'error');
        }
    });
</script>
@endsection