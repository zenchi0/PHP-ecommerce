<?php
namespace FormGenerator;

function displayLogin($missingFields = "")
{
?>
<h1 class="title">Login</h1>
<p class="intro">You must login before ordering.</p>
<form action="Auth.php" method="post">
    <p>
        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" autofocus>
    </p>
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <label for="submit"></label>
        <input type="submit" value="Login">
    </p>
</form>
<?php
}
function displaySettingOptions($missingFields = "")
{
?>
<h1 class="title">Settings</h1>
<form action="Auth.php" method="post">
    <p>
        <label for="logout">Ready to logout, <?php echo($_SESSION['username']); ?>?</label>
        <input type="submit" value="Logout" name="logout">
    </p>
</form>
<?php
}
