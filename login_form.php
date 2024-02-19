
<?php include 'header.php' ?>

    <h2>User Login</h2>
    <form action="backend/login.php" method="post">
        <label for="username_email">Username or Email:</label>
        <input type="text" id="username_email" name="username_email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
