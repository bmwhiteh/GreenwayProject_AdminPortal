<?php
$uname = $_POST["uname"];
$psw = $_POST["psw"];

if ($uname ==  "test") {
    echo "Got username $uname .    Got password $psw .";
}else{
    echo "Incorrect login $uname";
}

?>