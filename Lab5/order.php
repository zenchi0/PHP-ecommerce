<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ZenWireless Order Page</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/form.css" />
    <link rel="stylesheet" href="./css/table.css" />
</head>
<body>
    <?php
    include 'nav_bar.php';
    $currentFile = basename(__FILE__);
    $fileNum = "Lab5";
    createPageNavBar($currentFile, $fileNum)
    ?>
    <div class="tableContainer">
        <div class="tableRow">
            <section class="twoCol">
                <?php
                    $theCart = $_SESSION['cart']['TotalPrice'];
                    include_once 'DisplayForms.php';
                    $productFile = "./products.csv";
                    $tableCaption = "Your order basket";
                    if ($_SESSION['ordered'] === true) {
                            displayThanks();
                    } elseif (isset($_SESSION['username']) && $theCart !== 0.00) {
                        if (isset($_POST['submitOrder'])) {
                            processForm();
                        } else {
                            displayOrderForm( array());
                        }
                    } elseif (isset($_SESSION['username']) && $_SESSION['cart']['TotalPrice'] == 0.00) {
                        displayEmptyCart();
                    } else {
                        FormGenerator\displayLogin();
                    }
                ?>
            </section>
            <section class="twoCol">
            <h1 class="title">Your Order Basket</h1>
            <?php
            $cartHeaders = array("Product Image", "Name", "Quantity", "Unit Price", "Subtotal");
            if ((isset($_POST['submitOrder']) || $_SESSION['ordered'] === true) && $_SESSION['error'] !== true) {
                echo "<h2 class='intro'>...is on it's way!</h2>";
                echo "<p class='intro'>Would you like to make another order?</p>";
                echo "<form action='Auth.php' method='post'>\n";
                echo "<p>\n";
                echo "<label for='newOrder'>More products?</label>\n";
                echo "<input type='submit' value='New Order' name='newOrder' />\n";
                echo "</p>\n";
                echo "</form>\n";
            } elseif (isset($_SESSION['username']) && $_SESSION['cart']['TotalPrice'] !== 0.00) {
                cartContents($cartHeaders);
            } elseif (!(isset($_SESSION['username'])) || $_SESSION['cart']['TotalPrice'] == 0.00) {
                echo "<p class='intro'>";
                echo "Fill this void with amazing new technology!";
                echo "</p>";
            }
            function cartContents($cartHeaders )
            {
                echo "<table>\n";
                echo "<tr>\n";
                foreach ($cartHeaders as $header) {
                    echo "<th>$header</th>\n";
                }
                echo "</tr>\n";
                foreach ($_SESSION['cart'] as $productID) {
                    echo "<tr>\n";
                    foreach ($productID as $property) {
                        if ((substr($property, -4) === ".jpg")) {
                            echo "\t\t<td><img src='$property'></td>\n";
                        } elseif (floor($property) != $property){
                            echo "<td>";
                            echo '$'.number_format($property, 2,'.', ',');
                            echo "</td>";
                        }
                        else {
                            echo "\t\t<td>$property</td>\n";
                        }
                    }
                    echo "</tr>\n";
                }
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td><b>Total:</b></td>";
                echo "<td><b>";
                echo '$'.number_format($_SESSION['cart']['TotalPrice'], 2,'.', ',');
                echo "</b></td>";
                echo "</tr>";
                echo "</table>\n";
            }
            ?>
            </section>
        </div>
    </div>
</body>
</html>
<?php
function displayEmptyCart()
{
?>
<h1 class="title">Your shopping cart is empty!</h1>
<p class="intro">
    Head to the <a href="./products.php">Products Page</a> to add some great
    smartphones to your basket!
</p>
<?php
}
function processForm()
{
    $missingFields = array();
    $requiredFields = array("fname",
                            "lname",
                            "address1",
                            "city",
                            "state",
                            "zipcode",
                            "cardType",
                            "cardNumber",
                            "cardExpireMonth",
                            "cardExpireYear");
    if ($_POST['state'] === "default") {
        $missingFields[] = 'state';
    }

    foreach ($requiredFields as $requiredField) {
        if (!isset($_POST[$requiredField]) or !$_POST[$requiredField]) {
            $missingFields[] = $requiredField;
        }
    }
    if ($missingFields) {
        $_SESSION['error'] = true;
        displayOrderForm($missingFields);
    } else {
        $_SESSION['error'] = false;
        displayThanks();
    }
}
function validateField($fieldName, $missingFields)
{
    if (in_array($fieldName, $missingFields)) {
        echo "class='error'";
    }
}
function displayOrderForm($missingFields)
{
?>
<h1 class="title">Your order is on its way!</h1>
<?php
if (!(empty($missingFields))) {
?>
<h2 class="intro error">There were errors in your order form.</h2>
<?php
}
?>
<h3>
    Let's get you a new phone!
    <?php echo($_SESSION['username']) ?>!
</h3>
<p>
    Email confirmation will be sent to <?php echo($_SESSION['email']) ?>
</p>
<form action="order.php" method="post">
    <p <?php validateField("fname", $missingFields); ?>>
        <label for="fname">First Name*:</label>
        <input type="text" name="fname" id="fname">
    </p>
    <p <?php validateField("lname", $missingFields); ?>>
        <label for="lname">Last Name*:</label>
        <input type="text" name="lname" id="lname">
    </p>
    <p <?php validateField("address1", $missingFields); ?>>
        <label for="address1">Address Line 1*:</label>
        <input type="text" name="address1" id="address1">
    </p>
    <p>
        <label for="address2">Address Line 2:</label>
        <input type="text" name="address2" id="address2">
    </p>
    <p <?php validateField("city", $missingFields); ?>>
        <label for="city">City*:</label>
        <input type="text" name="city" id="city">
    </p>
    <p <?php validateField("state", $missingFields); ?>>
        <label for="state">State*:</label>
        <select name="state">
            <option value="default">State</option>
            <option value="AL">AL</option>
            <option value="AK">AK</option>
            <option value="AZ">AZ</option>
            <option value="AR">AR</option>
            <option value="CA">CA</option>
            <option value="CO">CO</option>
            <option value="CT">CT</option>
            <option value="DE">DE</option>
            <option value="FL">FL</option>
            <option value="GA">GA</option>
            <option value="HI">HI</option>
            <option value="ID">ID</option>
            <option value="IL">IL</option>
            <option value="IN">IN</option>
            <option value="IA">IA</option>
            <option value="KS">KS</option>
            <option value="KY">KY</option>
            <option value="LA">LA</option>
            <option value="ME">ME</option>
            <option value="MD">MD</option>
            <option value="MA">MA</option>
            <option value="MI">MI</option>
            <option value="MN">MN</option>
            <option value="MS">MS</option>
            <option value="MO">MO</option>
            <option value="MT">MT</option>
            <option value="NE">NE</option>
            <option value="NV">NV</option>
            <option value="NH">NH</option>
            <option value="NJ">NJ</option>
            <option value="NM">NM</option>
            <option value="NY">NY</option>
            <option value="NC">NC</option>
            <option value="ND">ND</option>
            <option value="OH">OH</option>
            <option value="OK">OK</option>
            <option value="OR">OR</option>
            <option value="PA">PA</option>
            <option value="RI">RI</option>
            <option value="SC">SC</option>
            <option value="SD">SD</option>
            <option value="TN">TN</option>
            <option value="TX">TX</option>
            <option value="UT">UT</option>
            <option value="VT">VT</option>
            <option value="VA">VA</option>
            <option value="WA">WA</option>
            <option value="WV">WV</option>
            <option value="WI">WI</option>
            <option value="WY">WY</option>
        </select>
    </p>
    <p <?php validateField("zipcode", $missingFields); ?>>
        <label for="zipcode">Zipcode*:</label>
        <input type="text" name="zipcode" id="zipcode">
    </p>
    <div class="tableRow">
        <label for="cardType">Card Type*:</label>
        <div class="componentContainer">
            <div <?php validateField("cardType", $missingFields); ?>>
                <p>
                    <label for="cardType">Visa:</label>
                    <input type="radio" name="cardType" value="visa">
                </p>
                <p>
                    <label for="cardType">Mastercard:</label>
                    <input type="radio" name="cardType" value="mastercard">
                </p>
                <p>
                    <label for="cardType">American Express:</label>
                    <input type="radio" name="cardType" value="americanExpress">
                </p>
            </div>
        </div>
    </div>
    <p <?php validateField("cardNumber", $missingFields); ?>>
        <label for="cardNumber">Card Number*:</label>
        <input type="text" name="cardNumber" id="cardNumber">
    </p>
    <div class="tableRow">
        <label for="cardExpiration">Card Expiration</label>
        <div class="componentContainer">
            <p <?php validateField("cardExpireMonth", $missingFields); ?>>
                <label for="cardExpireMonth">Month*:</label>
                <input type="number" name="cardExpireMonth" value="1" min="1" max="12">
            </p>
            <p <?php validateField("cardExpireYear", $missingFields); ?>>
                <label for="cardExpireYear">Year*:</label>
                <input type="number" name="cardExpireYear" value="2015" min="2015" max="2021">
            </p>
        </div>
    </div>
    <p>
        <label for="comments">Comments:</label>
    </p>
    <p>
        <label for=""></label>
        <textarea name="comments" cols="30" rows="10"></textarea>
    </p>
    <p>
        <label for="submitOrder">Ready?</label>
        <input type="submit" value="Submit" name="submitOrder">
    </p>
</form>
<?php
}
function displayThanks()
{
    $_SESSION['ordered'] = true;
    $_SESSION['cart'] = array();
    $_SESSION['cart']["TotalPrice"] = 0.00;
?>
<h1 class="title">Thanks for your order!</h1>
<p class="intro">Your order will be shipping soon.</p>
<form action="Auth.php" method="post">
    <p>
        <label for="logout">Ready to logout?</label>
        <input type="submit" value="Logout" name="logout" />
    </p>
</form>
<?php
}
?>
