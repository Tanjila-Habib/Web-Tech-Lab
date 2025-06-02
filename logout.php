<?php
session_start();
 
session_unset();
 
// Destroy the session
session_destroy();
 
// Inform the user
echo "You are now redirected";
 
header("refresh:1; url=index.html");
exit;
?>
