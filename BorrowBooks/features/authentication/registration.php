<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="registration.css">
    </head>
    <body>
    <section class="container">
        <h2>Sign up</h2>
        <form action="registration_server.php" method="post">
            <section class="fields">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </section>
            <section class="fields">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </section>
            <section class="fields">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </section>
            <section class="fields">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" required>
            </section>
            <section class="actions">
                <button type="submit" class="submit-btn">Register</button>
            </section>
        </form>
        <section class="link">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </section>
    </section>
    </body>
</html>