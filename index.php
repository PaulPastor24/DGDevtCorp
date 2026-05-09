<?php
session_start();
$brandName = 'D&G ConstructMonitor';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&G ConstructMonitor - Construction Project Monitoring System</title>
    <meta name="description" content="Construction project monitoring for workforce, progress, and site operations in one unified platform.">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/landing.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUarbnLLtQbOV5JnXwyIEo56nNmslbdkrMjW03fNvqrviJkur" crossorigin="anonymous">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-logo" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">
        <div class="navbar-logo-icon"><img src="images/logo.jpg" alt="D&G Construction logo"></div>
    </div>
    <div class="navbar-nav">
        <a href="#features" class="active">Features</a>
        <a href="#about">About</a>
        <button class="navbar-cta" onclick="openLoginModal()">Sign In</button>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">Construction Operations Platform</div>
        <h1 class="hero-title">Manage every project with one clear source of truth.</h1>
        <p class="hero-subtitle">D&G ConstructMonitor brings together progress tracking, workforce attendance, phase reporting, and site visibility in a single professional dashboard built for modern project teams.</p>

        <div class="hero-cta-group">
            <button class="btn-primary" onclick="openLoginModal()">Open Dashboard</button>
            <button class="btn-secondary" onclick="document.querySelector('#about').scrollIntoView({ behavior: 'smooth' })">Explore Platform</button>
        </div>

        <div class="hero-stats">
            <div class="stat">
                <div class="stat-value">7</div>
                <div class="stat-label">Active Projects</div>
            </div>
            <div class="stat">
                <div class="stat-value">184</div>
                <div class="stat-label">Workforce Members</div>
            </div>
            <div class="stat">
                <div class="stat-value">4.93M</div>
                <div class="stat-label">Inventory Value</div>
            </div>
        </div>
    </div>
</section>

<section class="features-section" id="features">
    <div class="section-header">
        <h2 class="section-title">Built for construction teams</h2>
        <p class="section-subtitle">Everything needed to coordinate on-site activity, track performance, and keep stakeholders aligned.</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <h3 class="feature-title">Live Project Dashboards</h3>
            <p class="feature-description">Track progress, milestones, and site status with a clean operational view designed for faster decisions.</p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Workforce Management</h3>
            <p class="feature-description">Capture attendance, verify workers, and keep a reliable log of daily on-site activity.</p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Material Tracking</h3>
            <p class="feature-description">Monitor inventory, deliveries, and supply status to reduce delays and keep work moving.</p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Phase Management</h3>
            <p class="feature-description">Organize project phases, report progress, and review completion updates in one place.</p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Alert System</h3>
            <p class="feature-description">Surface attendance issues, project delays, and milestone changes before they become bottlenecks.</p>
        </div>

        <div class="feature-card">
            <h3 class="feature-title">Role-Based Access</h3>
            <p class="feature-description">Give admins, supervisors, and clients the right level of visibility for their responsibilities.</p>
        </div>
    </div>
</section>

<section class="about-section" id="about">
    <div class="about-content">
        <div class="about-grid">
            <div>
                <h2>About D&G ConstructMonitor</h2>
                <p>D&G Development Corporation uses ConstructMonitor to streamline project coordination across offices, job sites, and client updates. The platform is designed to improve visibility, accountability, and delivery quality.</p>
                <p>It supports operational teams with a professional workflow for attendance, progress review, and field reporting without adding unnecessary complexity.</p>

                <ul class="about-list">
                    <li>Centralized project oversight</li>
                    <li>Real-time workforce and attendance tracking</li>
                    <li>Structured phase and milestone management</li>
                    <li>Clear reporting for supervisors and clients</li>
                    <li>Built for reliable day-to-day operations</li>
                </ul>
            </div>

            <div class="about-metrics">
                <div class="metric-item">
                    <div class="metric-number">50+</div>
                    <div class="metric-text">Completed Projects</div>
                </div>
                <div class="metric-item">
                    <div class="metric-number">2500+</div>
                    <div class="metric-text">Workforce Capacity</div>
                </div>
                <div class="metric-item">
                    <div class="metric-number">₱15B+</div>
                    <div class="metric-text">Total Project Value</div>
                </div>
                <div class="metric-item">
                    <div class="metric-number">98%</div>
                    <div class="metric-text">On-Time Delivery</div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-col">
            <h4>Company</h4>
            <ul>
                <li><a href="#about">About Us</a></li>
                <li><a href="#features">Projects</a></li>
                <li><a href="#features">Capabilities</a></li>
                <li><a href="#about">News</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Product</h4>
            <ul>
                <li><a href="#features">Features</a></li>
                <li><a href="#about">Documentation</a></li>
                <li><a href="#features">API</a></li>
                <li><a href="#about">Support</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Legal</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Security</a></li>
                <li><a href="#">Compliance</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <ul>
                <li><a href="mailto:info@dg-corp.ph">info@dg-corp.ph</a></li>
                <li><a href="tel:+6321234567">+63 (2) 1234-567</a></li>
                <li><a href="#">Support Center</a></li>
                <li><a href="#">Schedule Demo</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 D&G Development Corporation. All rights reserved.</p>
        <p>ConstructMonitor - Construction Project Monitoring System</p>
    </div>
</footer>

<div class="login-modal" id="loginModal">
    <div class="login-card">
        <button class="modal-close" onclick="closeLoginModal()">Close</button>

        <div class="login-header">
            <div class="login-logo"><img src="images/logo.jpg" alt="D&G Construction logo"></div>
            <h2 class="login-title">D&G ConstructMonitor</h2>
            <p class="login-subtitle">Project Management System</p>
        </div>

        <div class="role-tabs" id="roleTabs">
            <button class="role-tab active" onclick="selectRole(this, 'admin')">Admin</button>
            <button class="role-tab" onclick="selectRole(this, 'supervisor')">Supervisor</button>
            <button class="role-tab" onclick="selectRole(this, 'client')">Client</button>
        </div>

        <form class="login-form" id="loginForm" onsubmit="handleLogin(event)">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" id="loginEmail" placeholder="your@email.com" value="admin@dg-corp.ph" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-input" id="loginPassword" placeholder="••••••••" value="password123" required>
            </div>

            <input type="hidden" id="selectedRole" name="role" value="admin">

            <button type="submit" class="login-btn" id="loginBtn">Sign In</button>

            <div id="loginError" style="display:none; margin-top:12px; padding:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:6px; color:#ef4444; font-size:12px; text-align:center;"></div>
        </form>

        <div class="demo-credentials">
            <strong>Demo Credentials:</strong><br>
            Admin: admin@dg-corp.ph<br>
            Supervisor: supervisor@dg-corp.ph<br>
            Client: client@dg-corp.ph<br>
            Password: password123
        </div>
    </div>
</div>

<script>
    let selectedRole = 'admin';

    function openLoginModal() {
        document.getElementById('loginModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function selectRole(el, role) {
        document.querySelectorAll('.role-tab').forEach(tab => tab.classList.remove('active'));
        el.classList.add('active');
        selectedRole = role;
        document.getElementById('selectedRole').value = role;
        document.getElementById('loginError').style.display = 'none';
    }

    async function handleLogin(e) {
        e.preventDefault();

        const email = document.getElementById('loginEmail').value.trim();
        const password = document.getElementById('loginPassword').value;
        const loginBtn = document.getElementById('loginBtn');
        const errorDiv = document.getElementById('loginError');

        // Disable button during submission
        loginBtn.disabled = true;
        loginBtn.textContent = 'Signing in...';
        errorDiv.style.display = 'none';

        try {
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('role', selectedRole);

            const response = await fetch('login.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                // Show success and redirect
                loginBtn.textContent = 'Success! Redirecting...';
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 500);
            } else {
                // Show error message
                errorDiv.textContent = data.message || 'Login failed. Please try again.';
                errorDiv.style.display = 'block';
                loginBtn.disabled = false;
                loginBtn.textContent = 'Sign In';
            }
        } catch (error) {
            console.error('Login error:', error);
            errorDiv.textContent = 'A network error occurred. Please try again.';
            errorDiv.style.display = 'block';
            loginBtn.disabled = false;
            loginBtn.textContent = 'Sign In';
        }
    }

    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLoginModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLoginModal();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWbSxccPQtF3EpF3fnJHog6LaEVF+z4NhkxqHY4xZe3Z8L0L" crossorigin="anonymous"></script>

</body>
</html>