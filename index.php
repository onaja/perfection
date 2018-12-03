<?php
echo "Hello LINE BOT";
$old=21;
session_register ( "old" );
if($_SESSION["old"]>0){
			$_SESSION["old"]= $_SESSION["old"] + 1;
			}
			else{	
			$_SESSION["old"]=2;
			}
echo $_SESSION["old"];
