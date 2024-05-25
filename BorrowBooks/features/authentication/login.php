<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="registration.css">
    </head>
    <body>
    <section class="container">
        <h2>Sign in</h2>
        <form action="login_server.php" method="post">
            <section class="fields">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </section>
            <section class="fields">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </section>
            <section class="actions">
                <button type="submit" class="submit-btn">Log In</button>
            </section>
        </form>
        <section class="link">
            <p>Don't have an account? <a href="registration.php">Sign up</a></p>
        </section>
    </section>
    </body>
</html>