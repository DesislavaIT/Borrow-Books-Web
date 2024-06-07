
{% extends views/auth.html.php %}

{% block stylesheets %}
    <link rel="stylesheet" href="assets/css/auth.css" />
{% endblock %}

{% block content %}
    <div class="page-layout">
        <div class="container">
            <header>
                <h2>Sign In</h2>
            </header>
            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-actions" style="justify-content: center;">
                    <button class="button-primary button-rounded button-wide" type="submit">Log In</button>
                </div>
                <div class="form-links" style="justify-content: center;">
                    <p>Don't have an account? <a href="/register">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
{% endblock %}
