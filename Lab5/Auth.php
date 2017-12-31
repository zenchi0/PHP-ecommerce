<?php
// Include the template
include_once 'homePage.php';
session_start();
// 30 minute session lengths
$maxSessionLength = 30 * 60;
$now = time();
if ($_POST['logout']) {
    $_SESSION = array();
    session_destroy();
    // Create the appropriate page
    userLogout();
} elseif ($_POST['newOrder']) {
    // Restart the 30 minute session
    $_SESSION['discard_after'] = $now + $maxSessionLength;
    $_SESSION['ordered'] = false;
    $_SESSION['cart'] = array();
    $_SESSION['cart']['TotalPrice'] = 0.00;
    // Create the appropriate page
    moreShopping();
} else {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['discard_after'] = $now + $maxSessionLength;
    $_SESSION['ordered'] = false;
    $_SESSION['error'] = false;
    $_SESSION['cart'] = array();
    $_SESSION['cart']['TotalPrice'] = 0.00;
    // Create the appropriate page
    successfulLogin();
}
function userLogout() {
    $heading = "Logged out";
    $para = "Thanks for visiting ZenWireless!";
    $img = "./images/ZenWireless.jpg";
    homePage($heading, $para, $img);
}
function successfulLogin() {
    $heading = "Thank you for your continued patronage, " . $_SESSION['username'];
    $para = "Head over to the <a href='./products.php'>Product Page</a> to check out our amazing deals!";
    $img = "./images/ZenWireless.jpg";
    homePage($heading, $para, $img);
}
function moreShopping() {
    $heading = "Get connected!";
    $para = "Head over to the <a href='./products.php'>Product Page</a> to check out our amazing deals!";
    $img = "./images/ZenWireless.jpg";
    homePage($heading, $para, $img);
}
