@extends('layouts.api-panel')

@section('title', 'Login - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>Login</h1>
        <p class="muted">Enter your email and password. The form will call the Laravel API and store your token.</p>

        <div id="login-feedback"></div>

        <form id="login-form">
            <div class="grid">
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="admin@example.com" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
            </div>

            <br>
            <button class="btn" type="submit">Login</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        showMessage('login-feedback', 'Logging in, please wait...', 'loading');

        const formData = new FormData(loginForm);

        const body = {
            email: formData.get('email'),
            password: formData.get('password')
        };

        try {
            const payload = await apiRequest('/login', {
                method: 'POST',
                body: JSON.stringify(body)
            });

            const token = payload.token ?? payload.data?.token ?? payload.access_token ?? payload.data?.access_token;
            const user = extractUser(payload);
            if (!token || !user) {
                throw new Error('Login response does not contain token and user details.');
            }

            saveAuth(token, user);
            showMessage('login-feedback', 'Login successful. Redirecting...', 'success');

            setTimeout(function () {
                window.location.href = dashboardPage;
            }, 800);
        } catch (error) {
            const details = validationErrorsToHtml(error.errors);
            showMessage('login-feedback', escapeHtml(error.message) + details, 'error');
        }
    });
</script>
@endsection