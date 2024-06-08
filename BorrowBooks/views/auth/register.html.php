
{% extends views/auth.html.php %}

{% block stylesheets %}
    <link rel="stylesheet" href="assets/css/auth.css" />
{% endblock %}

{% block content %}
    <div class="page-layout">
        <div class="container">
            <header>
                <h2>Sign Up</h2>
            </header>
            <form action="/register" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input type="password" id="password-confirm" name="password_confirm" required>
                </div>
                <div class="form-actions" style="justify-content: center;">
                    <button class="button-primary button-rounded button-wide" type="submit">Register</button>
                </div>
                <div class="form-links" style="justify-content: center;">
                    <p>Already have an account? <a href="/login">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
{% endblock %}
