<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About Us | {{ config('app.name', 'Laravel') }}</title>
        <style>
            :root {
                color-scheme: dark;
                --bg: #020617;
                --panel: #111827;
                --panel-2: #0f172a;
                --text: #f8fafc;
                --muted: #cbd5e1;
                --accent: #22d3ee;
                --accent-2: #38bdf8;
                --border: rgba(255,255,255,0.12);
            }

            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                line-height: 1.7;
                background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
                color: var(--text);
            }
            a { color: inherit; text-decoration: none; }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 24px 20px 48px;
            }
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 12px;
                padding: 14px 20px;
                margin-bottom: 32px;
                border: 1px solid var(--border);
                border-radius: 999px;
                background: rgba(255,255,255,0.05);
                backdrop-filter: blur(8px);
            }
            .brand {
                font-size: 1.1rem;
                font-weight: 700;
                letter-spacing: 0.04em;
            }
            .nav a {
                margin-left: 16px;
                color: var(--muted);
                transition: color 0.2s ease;
            }
            .nav a:hover,
            .nav a.active {
                color: var(--text);
            }
            .hero {
                display: grid;
                grid-template-columns: 1.2fr 0.8fr;
                gap: 32px;
                padding: 40px;
                border: 1px solid var(--border);
                border-radius: 28px;
                background: linear-gradient(135deg, #0f172a 0%, #111827 100%);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            }
            .tag {
                display: inline-block;
                padding: 7px 12px;
                margin-bottom: 16px;
                border: 1px solid rgba(34, 211, 238, 0.25);
                border-radius: 999px;
                background: rgba(34, 211, 238, 0.1);
                color: #67e8f9;
                font-size: 0.95rem;
                font-weight: 600;
            }
            h1 {
                margin: 0;
                font-size: clamp(2rem, 4vw, 3.2rem);
                line-height: 1.1;
            }
            .lead {
                margin: 18px 0 0;
                max-width: 700px;
                font-size: 1.05rem;
                color: var(--muted);
            }
            .buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 24px;
            }
            .btn {
                display: inline-block;
                padding: 12px 20px;
                border-radius: 999px;
                font-weight: 700;
                transition: transform 0.2s ease, background 0.2s ease;
            }
            .btn:hover { transform: translateY(-1px); }
            .btn-primary {
                background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
                color: #022c22;
            }
            .btn-secondary {
                border: 1px solid rgba(255,255,255,0.15);
                background: rgba(255,255,255,0.05);
                color: var(--text);
            }
            .stats {
                padding: 20px;
                border: 1px solid var(--border);
                border-radius: 20px;
                background: rgba(255,255,255,0.08);
                backdrop-filter: blur(8px);
            }
            .stats-grid {
                display: grid;
                gap: 12px;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .stat-box {
                padding: 14px;
                border-radius: 14px;
                background: rgba(2, 6, 23, 0.7);
            }
            .stat-label { font-size: 0.9rem; color: #94a3b8; }
            .stat-value { font-size: 1.4rem; font-weight: 700; margin-top: 4px; }
            .stat-box.full { grid-column: 1 / -1; }
            .cards {
                display: grid;
                gap: 18px;
                margin-top: 28px;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .card {
                padding: 22px;
                border: 1px solid var(--border);
                border-radius: 20px;
                background: rgba(255,255,255,0.05);
            }
            .card h2 { margin-top: 0; margin-bottom: 10px; font-size: 1.1rem; }
            .card p { margin: 0; color: var(--muted); font-size: 0.95rem; }
            .team-section {
                margin-top: 28px;
                padding: 30px;
                border: 1px solid var(--border);
                border-radius: 24px;
                background: rgba(15, 23, 42, 0.8);
            }
            .team-header { margin-bottom: 20px; }
            .team-header .eyebrow {
                color: #67e8f9;
                text-transform: uppercase;
                letter-spacing: 0.25em;
                font-size: 0.8rem;
                font-weight: 700;
            }
            .team-grid {
                display: grid;
                gap: 18px;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .team-card {
                padding: 18px;
                border: 1px solid var(--border);
                border-radius: 16px;
                background: rgba(255,255,255,0.05);
            }
            .team-card h3 { margin: 0 0 6px; font-size: 1rem; }
            .role { color: #67e8f9; font-size: 0.9rem; margin-bottom: 10px; }
            .contact {
                margin-top: 28px;
                padding: 28px;
                text-align: center;
                border: 1px solid rgba(34, 211, 238, 0.2);
                border-radius: 24px;
                background: rgba(34, 211, 238, 0.08);
            }
            .contact a {
                display: inline-block;
                margin-top: 16px;
                padding: 12px 20px;
                border-radius: 999px;
                background: #fff;
                color: #020617;
                font-weight: 700;
            }
            @media (max-width: 900px) {
                .hero { grid-template-columns: 1fr; }
                .cards, .team-grid { grid-template-columns: 1fr; }
            }
            @media (max-width: 600px) {
                .container { padding: 18px 14px 36px; }
                .header { border-radius: 18px; }
                .hero, .team-section, .contact { padding: 22px; }
                .stats-grid { grid-template-columns: 1fr; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="header">
                <a href="/" class="brand">Summer Tech API</a>
                <nav class="nav">
                    <a href="/">Home</a>
                    <a href="/about" class="active">About</a>
                    <a href="#contact">Contact</a>
                </nav>
            </header>

            <main>
                <section class="hero">
                    <div>
                        <div class="tag">Built for modern digital experiences</div>
                        <h1>We create reliable APIs that power bold ideas.</h1>
                        <p class="lead">
                            At Summer Tech API, we design scalable, developer-friendly services that help startups,
                            teams, and growing brands deliver smarter products faster.
                        </p>
                        <div class="buttons">
                            <a href="#contact" class="btn btn-primary">Get in Touch</a>
                            <a href="/" class="btn btn-secondary">Explore Services</a>
                        </div>
                    </div>

                    <div class="stats">
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-label">Fast Delivery</div>
                                <div class="stat-value">24/7</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">Uptime</div>
                                <div class="stat-value">99.9%</div>
                            </div>
                            <div class="stat-box full">
                                <div class="stat-label">Trusted by</div>
                                <div class="stat-value">Startups &amp; growing teams</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="cards">
                    <div class="card">
                        <h2>Our Mission</h2>
                        <p>To make complex integrations simple, secure, and seamless for every client we serve.</p>
                    </div>
                    <div class="card">
                        <h2>Our Vision</h2>
                        <p>To be the dependable technology partner behind exceptional digital products.</p>
                    </div>
                    <div class="card">
                        <h2>Our Values</h2>
                        <p>Reliability, clarity, speed, and long-term partnership are at the core of everything we build.</p>
                    </div>
                </section>

                <section class="team-section">
                    <div class="team-header">
                        <p class="eyebrow">Meet the team</p>
                        <h2>People behind the platform</h2>
                    </div>
                    <div class="team-grid">
                        <div class="team-card">
                            <h3>Ava Chen</h3>
                            <div class="role">Founder &amp; CEO</div>
                            <p>Leads product strategy and turns customer needs into powerful API experiences.</p>
                        </div>
                        <div class="team-card">
                            <h3>Noah Brooks</h3>
                            <div class="role">Engineering Lead</div>
                            <p>Builds the infrastructure that keeps every service fast, resilient, and secure.</p>
                        </div>
                        <div class="team-card">
                            <h3>Mina Patel</h3>
                            <div class="role">Client Success</div>
                            <p>Ensures each partnership is supported with care, clarity, and measurable results.</p>
                        </div>
                    </div>
                </section>

                <section id="contact" class="contact">
                    <h2>Ready to build something remarkable?</h2>
                    <p>Let’s talk about how Summer Tech API can support your next launch.</p>
                    <a href="mailto:hello@summertechapi.com">hello@summertechapi.com</a>
                </section>
            </main>
        </div>
    </body>
</html>
