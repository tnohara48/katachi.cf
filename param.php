<?
$name = $_POST['name'];
$email = $_POST['password'];
print $name . " " . $email;

$array = [ $name , $email ];

echo json_encode($array);
