@extends('layouts.api-panel')

@section('title', 'Users - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>User Management</h1>
        <p class="muted">Only admin can create users and update user roles.</p>
        <div id="user-feedback"></div>

        <form id="user-form">
            <h2>Create User</h2>
            <div class="grid">
                <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div>
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="staff">Staff</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <br>
            <button class="btn" type="submit">Create User</button>
        </form>
    </div>

    <div class="card">
        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Current Role</th><th>Change Role</th></tr>
            </thead>
            <tbody id="users-body"></tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        try {
            const user = await requireAuth(['admin']);
            if (!user) return;
            await loadUsers();
        } catch (error) {
            showMessage('user-feedback', escapeHtml(error.message), 'error');
        }
    });

    async function loadUsers() {
        const payload = await apiRequest('/users');
        const users = Array.isArray(payload.data) ? payload.data : [];
        const tbody = document.getElementById('users-body');
        tbody.innerHTML = '';

        users.forEach(function (user) {
            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${escapeHtml(user.name)}</td>
                    <td>${escapeHtml(user.email)}</td>
                    <td>${escapeHtml(user.role)}</td>
                    <td>
                        <select onchange="updateUserRole(${user.id}, this.value)">
                            <option value="staff" ${user.role === 'staff' ? 'selected' : ''}>Staff</option>
                            <option value="manager" ${user.role === 'manager' ? 'selected' : ''}>Manager</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                        </select>
                    </td>
                </tr>
            `);
        });
    }

    document.getElementById('user-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const body = {
            name: formData.get('name'),
            email: formData.get('email'),
            password: formData.get('password'),
            password_confirmation: formData.get('password_confirmation'),
            role: formData.get('role')
        };

        try {
            const payload = await apiRequest('/users', {
                method: 'POST',
                body: JSON.stringify(body)
            });

            showMessage('user-feedback', payload.message || 'User created successfully.', 'success');
            this.reset();
            await loadUsers();
        } catch (error) {
            showMessage('user-feedback', escapeHtml(error.message) + validationErrorsToHtml(error.errors), 'error');
        }
    });

    async function updateUserRole(userId, role) {
        try {
            const payload = await apiRequest('/users/' + userId + '/role', {
                method: 'PATCH',
                body: JSON.stringify({ role: role })
            });

            showMessage('user-feedback', payload.message || 'Role updated successfully.', 'success');
            await loadUsers();
        } catch (error) {
            showMessage('user-feedback', escapeHtml(error.message) + validationErrorsToHtml(error.errors), 'error');
        }
    }
</script>
@endsection