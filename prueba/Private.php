<?php
include 'config.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>

<BODY>
    Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a><br /><br /> This is your private page. You can put specific content here.
</BODY>

</HTML>