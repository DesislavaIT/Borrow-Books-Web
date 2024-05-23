<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="registration.css">
    </head>
    <body>
    <div class="container">
        <h2>Sign up</h2>
        <form action="registration_server.php" method="post">
            <div class="fields">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="fields">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="fields">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="fields">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" required>
            </div>
            <div class="actions">
            <button type="submit" class="submit-btn">Register</button>
            </div>
        </form>
        <div class="link">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>
    </body>
</html>