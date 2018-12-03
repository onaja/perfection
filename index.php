<?php
echo "Hello LINE BOT";
session_start ();
$user = "bamboo";
session_register ( "user" );
echo $_SESSION["user"];
?>
