<?php
echo "Hello LINE BOT";
if(isset($_SESSION['views'])){
			$_SESSION['views']= $_SESSION['views'] + 1;
			}
			else{	
			$_SESSION['views']=2;
			}
echo $_SESSION['views'];
