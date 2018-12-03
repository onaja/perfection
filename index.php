<?php
echo "Hello LINE BOT";
$old=21;
 Session_register("old")
if(isset($_SESSION['old'])){
			$_SESSION['old']= $_SESSION['old'] + 1;
			}
			else{	
			$_SESSION['old']=2;
			}
echo $_SESSION['old'];
