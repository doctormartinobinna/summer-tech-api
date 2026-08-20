@extends('layouts.api-panel')

@section('title', 'My Profile - Blade Forms and AJAX')

@section('content')
    <div class="card">
        <h1>My Profile</h1>
        <div id="profile-feedback" class="message loading">Loading profile...</div>
        <table id="profile-table" class="hidden">
            <tbody>
                <tr><th>Name</th><td id="profile-name"></td></tr>
                <tr><th>Email</th><td id="profile-email"></td></tr>
                <tr><th>Role</th><td id="profile-role"></td></tr>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        try {
            const user = await requireAuth(['admin', 'manager', 'staff']);
            if (!user) return;

            document.getElementById('profile-name').textContent = user.name ?? 'No name';
            document.getElementById('profile-email').textContent = user.email ?? 'No email';
            document.getElementById('profile-role').textContent = user.role ?? 'No role';

            document.getElementById('profile-feedback').style.display = 'none';
            document.getElementById('profile-table').classList.remove('hidden');
        } catch (error) {
            showMessage('profile-feedback', escapeHtml(error.message), 'error');
        }
    });
</script>
@endsection