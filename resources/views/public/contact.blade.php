{{-- resources/views/public/contact.blade.php --}}
@extends('layouts.public')

@section('title', 'Contact Us - Lecture Demo')

@section('content')
<div class="card">
    <h1>Contact Us</h1>
    <p class="muted">
        Send a message to the Lecture Demo team. This form submits to the Laravel API,
        saves the contact message, and sends an email to the configured receiver.
    </p>

    <div id="contact-feedback"></div>

    <form id="contact-form">
        <div class="grid">
            <div>
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div>
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <br>
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" placeholder="Message subject" required>

        <br><br>
        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Write your message here" required></textarea>

        <br><br>
        <button class="btn" type="submit">Send Message</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
const contactEndpoint = "{{ url('/api/contact') }}";
const contactForm = document.getElementById('contact-form');

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function showContactMessage(message, type = 'success') {
    const feedback = document.getElementById('contact-feedback');
    feedback.className = 'message ' + type;
    feedback.innerHTML = message;
}

function validationErrorsToHtml(errors) {
    if (!errors || Object.keys(errors).length === 0) return '';
    let html = '<ul>';
    Object.keys(errors).forEach(function (field) {
        errors[field].forEach(function (message) {
            html += '<li>' + escapeHtml(message) + '</li>';
        });
    });
    html += '</ul>';
    return html;
}

contactForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    showContactMessage('Sending your message, please wait...', 'loading');

    const formData = new FormData(contactForm);
    const body = {
        name: formData.get('name'),
        email: formData.get('email'),
        subject: formData.get('subject'),
        message: formData.get('message')
    };

    try {
        const response = await fetch(contactEndpoint, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        const payload = await response.json().catch(function () {
            return {};
        });

        if (!response.ok) {
            const error = new Error(payload.message || 'Request failed with status ' + response.status);
            error.errors = payload.errors || {};
            throw error;
        }

        showContactMessage(payload.message || 'Message sent successfully.', 'success');
        contactForm.reset();
    } catch (error) {
        showContactMessage(escapeHtml(error.message) + validationErrorsToHtml(error.errors), 'error');
    }
});
</script>
@endsection