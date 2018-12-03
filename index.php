<?php
echo "Hello LINE BOT";
Session_Start();
$name="นายวีระชัย นุกิจรัมย์";
 $old=21;
 Session_register("name");
 Session_register("old")
   echo "ค่าใน Session Name คือ $name <br>";
echo "ค่าใน Session Old คือ $old <br>";
?>
