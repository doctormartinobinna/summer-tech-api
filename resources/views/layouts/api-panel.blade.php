<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blade Forms and AJAX')</title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f4f6; color: #1f2937; }
        .app { display: flex; min-height: 100vh; }
        .sidebar { width: 270px; background: #111827; color: white; padding: 24px 18px; position: fixed; top: 0; bottom: 0; left: 0; overflow-y: auto; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 25px; }
        .brand img { width: 42px; height: 42px; object-fit: contain; background: white; border-radius: 10px; padding: 4px; }
        .brand strong { display: block; font-size: 15px; }
        .brand span { color: #9ca3af; font-size: 12px; }
        .nav-link { display: block; color: #d1d5db; text-decoration: none; padding: 11px 12px; border-radius: 8px; margin-bottom: 6px; font-weight: bold; }
        .nav-link:hover { background: #1f2937; color: white; }
        .role-badge { display: inline-block; padding: 4px 9px; border-radius: 20px; background: #2563eb; color: white; font-size: 12px; margin-top: 8px; }
        .content { margin-left: 270px; padding: 30px; width: calc(100% - 270px); }
        .card {background: white; border-radius: 14px; padding: 24px; box-shadow: 0 10px 28px rgba(0,0,0,0.08); margin-bottom: 22px; }
        .muted { color: #6b7280; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 11px 12px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px; }
        textarea { min-height: 90px; }
        .btn { border: 0; background: #2563eb; color: white; padding: 10px 14px; border-radius: 9px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-danger { background: #dc2626; }
        .message { padding: 13px 15px; border-radius: 9px; margin: 14px 0; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .loading { background: #eff6ff; color: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; vertical-align: top; }
        th { background: #f9fafb; }
        .hidden { display: none !important; }
        img.product-image { width: 65px; height: 52px; object-fit: cover; border-radius: 8px; background: #e5e7eb; }
    </style>
</head>

<body>
    <div class="app">
        
        <aside class="sidebar">
            
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Digital Oxygen Hub Logo">
                <div>
                    <strong>Digital Oxygen Hub</strong>
                    <span>Blade Forms & AJAX</span>
                    <div id="role-badge" class="role-badge">Guest</div>
                </div>
            </div>

            <a class="nav-link" href="{{ route('blade.login') }}">Login</a>
            <a class="nav-link auth-link" href="{{ route('blade.dashboard') }}">Dashboard</a>
            <a class="nav-link auth-link" href="{{ route('blade.profile') }}">My Profile</a>
            <a class="nav-link auth-link" href="{{ route('blade.products.manage') }}">Products</a>
            <a class="nav-link auth-link" href="{{ route('blade.categories.manage') }}">Categories</a>
            <a class="nav-link admin-link" href="{{ route('blade.users') }}">Users</a>
            <button class="btn btn-danger auth-link" onclick="logoutUser()">Logout</button>

        </aside>

        <main class="content">
            @yield('content')
        </main>

    </div>

    <script>
        const apiBase = "{{ url('/api') }}";
        const loginPage = "{{ route('blade.login') }}";
        const dashboardPage = "{{ route('blade.dashboard') }}";

        function getToken() {
            return localStorage.getItem('api_token');
        }

        function getStoredUser() {
            try {
                return JSON.parse(localStorage.getItem('api_user'));
            } catch (error) {
                return null;
            }
        }

        function saveAuth(token, user) {
            localStorage.setItem('api_token', token);
            localStorage.setItem('api_user', JSON.stringify(user));
        }

        function clearAuth() {
            localStorage.removeItem('api_token');
            localStorage.removeItem('api_user');
        }

        function showMessage(elementId, message, type = 'success') {
            const element = document.getElementById(elementId);
            if (!element) return;
            element.className = 'message ' + type;
            element.innerHTML = message;
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function formatMoney(value) {
            return new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'EUR'
            }).format(Number(value || 0));
        }

        async function apiRequest(endpoint, options = {}) {
            const token = getToken();
            const isFormData = options.body instanceof FormData;

            const headers = {
                'Accept': 'application/json',
                ...(options.headers || {})
            };

            if (token) {
                headers['Authorization'] = 'Bearer ' + token;
            }

            if (!isFormData) {
                headers['Content-Type'] = 'application/json';
            }

            const response = await fetch(apiBase + endpoint, {...options,headers});

            const payload = await response.json().catch(function () {
                return {};
            });

            if (!response.ok) {
                const error = new Error(payload.message || 'Request failed with status ' + response.status);
                error.status = response.status;
                error.errors = payload.errors || {};
                throw error;
            }

            return payload;
        }

        function validationErrorsToHtml(errors) {
            let html = '<ul>';
            Object.keys(errors || {}).forEach(function (field) {
                errors[field].forEach(function (message) {
                    html += '<li>' + escapeHtml(message) + '</li>';
                });
            });
            html += '</ul>';
            return html;
        }

        function extractUser(payload) {
            if (!payload) return null;

            if (payload.user) {
                return payload.user;
            }

            if (payload.data && payload.data.user) {
                return payload.data.user;
            }

            if (payload.data && (payload.data.id || payload.data.email || payload.data.role)) {
                return payload.data;
            }

            if (payload.id || payload.email || payload.role) {
                return payload;
            }

            return null;
        }

        function normalizeRole(role) {
            return String(role ?? '').trim().toLowerCase();
        }

        async function requireAuth(allowedRoles = []) {
            if (!getToken()) {
                window.location.href = loginPage;
                return null;
            }

        try {
            const payload = await apiRequest('/user');
            const user = extractUser(payload);

            if (!user) {
                clearAuth();
                window.location.href = loginPage;
                return null;
            }

            const role = normalizeRole(user.role);

            if (!role) {
                document.querySelector('.content').innerHTML = `
                    <div class="card">
                        <h1>Role Not Found</h1>
                        <p class="muted">
                            The user was found, but the API response did not return the user's role.
                            Open DevTools Network tab and check the /api/user response.
                        </p>
                    </div>
                `;
                return null;
            }

            user.role = role;

            saveAuth(getToken(), user);
            updateNavigation(user);

            const allowed = allowedRoles.map(normalizeRole);

            if (allowed.length > 0 && !allowed.includes(role)) {
                document.querySelector('.content').innerHTML = `
                    <div class="card">
                        <h1>Access Denied</h1>
                        <p class="muted">
                            Your role is <strong>${escapeHtml(role)}</strong>.
                            You are not allowed to open this page.
                        </p>
                    </div>
                `;
                return null;
            }

            return user;
        } catch (error) {
            clearAuth();
            window.location.href = loginPage;
            return null;
        }
    }
        
    
    function updateNavigation(user = null) {
        user = user || getStoredUser();

        const roleBadge = document.getElementById('role-badge');
        const adminLinks = document.querySelectorAll('.admin-link');
        const authLinks = document.querySelectorAll('.auth-link');

        if (!user) {
            roleBadge.textContent = 'Guest';
            authLinks.forEach(link => link.classList.add('hidden'));
            adminLinks.forEach(link => link.classList.add('hidden'));
            return;
        }

        const role = normalizeRole(user.role);

        roleBadge.textContent = role || 'Unknown Role';

        authLinks.forEach(link => link.classList.remove('hidden'));

        if (role === 'admin') {
            adminLinks.forEach(link => link.classList.remove('hidden'));
        } else {
            adminLinks.forEach(link => link.classList.add('hidden'));
        }
    }

    async function logoutUser() {
        try {
            await apiRequest('/logout', { method: 'POST' });
        } catch (error) {}
        clearAuth();
        window.location.href = loginPage;
    }

        updateNavigation();
    </script>

    @yield('scripts')
</body>

</html>