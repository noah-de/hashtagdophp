<?php
require 'Person.php'

$bryan = new Student("0523842");
$bryan->setFirstname("Bryan");
$bryan->setLastname("Miner");
$bryan->setYear(4);
$bryan->setDorm("Armington");
$bryan->setRoomNum("B 206");
$bryan->setMSNum(1965);
$bryan->setPhoneNum("1-408-706-6564");
$bryan->setPrimaryContact("phone");
$dylan = new Student("0123456");
$bryan->setRoommates(array($dylan->getStudentID));

$drew = new Student("0583372");
$drew->setFirstname("Drew");
$drew->setLastname("Austin");
$drew->setYear(4);
$drew->setDorm("off-campus");
$drew->setRoomNum("811");
$drew->setMSNum(1057);
$drew->setPhoneNum("1-808-276-9401");
$drew->setPrimaryContact("phone");
$none = new Student("0");

$jordan = new Student("0523842");
$jordan->setYear(4);
$jordan->setDorm("Armington");
$jordan->setRoomNum("B 206");
$jordan->setMSNum(1965);
$jordan->setPhoneNum("1-408-706-6564");
$jordan->setPrimaryContact("phone");
$dylan = new Student("0123456");
$jordan->setRoommates(array($dylan->getStudentID));

$jordan = new Student("0523872");
$jordan->setYear(4);
$jordan->setDorm("vk");
$jordan->setRoomNum("D 1");
$jordan->setMSNum(10505);
$jordan->setPhoneNum("1-562-900-0640");
$jordan->setPrimaryContact("phone");
$dylan = new Student("0123596");
$jordan->setRoommates(array($dylan->getStudentID));

$drake = new Student("0245623");
$drake->setYear(4);
$drake->setDorm("Armington");
$drake->setRoomNum("a 202");
$drake->setMSNum(1965);
$drake->setPhoneNum("1-409-606-6064");
$drake->setPrimaryContact("phone");
$dylan = new Student("0123456");
$drake->setRoommates(array($dylan->getStudentID));

?>
