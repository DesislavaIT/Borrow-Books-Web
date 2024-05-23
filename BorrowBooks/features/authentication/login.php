<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="registration.css">
    </head>
    <body>
    <div class="container">
        <h2>Sign in</h2>
        <form action="login_server.php" method="post">
            <div class="fields">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="fields">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="actions">
                <button type="submit" class="submit-btn">Log In</button>
            </div>
        </form>
        <div class="link">
            <p>Don't have an account? <a href="registration.php">Sign up</a></p>
        </div>
    </div>
    </body>
</html>