<?php
require_once 'config.php';

// Is the user already logged in? Redirect him/her to the private page
if($_SESSION['username']){
    var_dump("Hola");
    header("Location: private.php"); 
    exit;
}

if(isSet($_POST['submit'])){
    $do_login = true; 
    include_once 'do_login.php'; 
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>

<BODY>
    <form name="login" method="post" action="login.php">
        <label>Username</label><input id="name" type="text" name="username"><br />
        <label>Password</label><input type="password" name="password"><br />
        <label>&nbsp;</label><input type="checkbox" name="autologin" value="1">Remember Me<br />
        <label>&nbsp;</label><input id="submit" type="submit" name="submit" value="Login"><br />
        </fieldset>
    </form>
</BODY>

</HTML>