<?php
require 'Person.php'

$bryan = new Student("0523842");
$bryan->setYear(4);
$bryan->setDorm("Armington");
$bryan->setRoomNum("B 206");
$bryan->setMSNum(1965);
$bryan->setPhoneNum("1-408-706-6564");
$bryan->setPrimaryContact("phone");
$dylan = new Student("0123456");
$bryan->setRoommates(array($dylan->getStudentID));


?>
