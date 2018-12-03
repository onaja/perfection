<?php

session_Start();
$name="นายวีระชัย นุกิจรัมย์";
 $old=21;
 session_register("name");
 session_register("old");
   echo "ค่าใน Session Name คือ $name <br>";
echo "ค่าใน Session Old คือ $old <br>";
echo "Hello LINE BOT";
?>
