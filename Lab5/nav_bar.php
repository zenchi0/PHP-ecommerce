<?php
function createPageNavBar($currentFile, $fileNum) {
  session_start();
  $now = time();
  // Checks if the session has expired on every new page
  checkSession($now);
  $pages = Array();
  $pages["Home"] = "index.php";
  $pages["Products"] = "products.php";
  $pages["Order"] = "order.php";
?>
    <nav>
        <ul>
          <?php
            foreach ($pages as $text => $link) {
                if ($link == $currentFile) {
                    echo "<li class='selected'><a href='#'>$text</a></li>\n";
                } else {
                    echo "<li><a href='$link'>$text</a></li>\n";
                }
            }
          ?>
          <li class="settings">
            <a href="Settings.php">
              <img src="./images/Cog_Logo.png" alt="Settings" title="Settings">
            </a>
          </li>
          <?php
            if (isset($_SESSION['username'])) {
          ?>
              <li class="username"><?php echo($_SESSION['username']); ?></li>
          <?php
            } elseif (!(isset($_SESSION['username']))) {
            ?>
              <li class="username">Logged out</li>
          <?php
            }
          ?>
        </ul>
    </nav>
<?php
}
function checkSession($now)
{
  if ((isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after'])) {
    $_SESSION = array();
    session_destroy();
  }
}
?>
