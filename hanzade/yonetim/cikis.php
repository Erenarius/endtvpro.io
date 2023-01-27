<?php
ob_start(); 
$cookiePath = "/";
setcookie("scriptindirnet_satisscriptv1","", time()-3600, $cookiePath);
unset ($_COOKIE['scriptindirnet_satisscriptv1']);
echo '<meta http-equiv="refresh" content="0;URL=index.php">'; 
ob_end_flush(); 
?>