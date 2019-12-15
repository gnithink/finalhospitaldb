<?php

include('connectionDataIx.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Hospital Management Database</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php

$PatientIDNumber = $_POST['PatientIDNumber'];
$PatientName = $_POST['PatientName'];
$DateOfBirth = $_POST['DateOfBirth'];
$BloodType = $_POST['BloodType'];
$Sex = $_POST['Sex'];
$Address = $_POST['Address'];
$PhoneNumber = $_POST['PhoneNumber'];


$query = "INSERT INTO hospital.Patient 
            VALUES ('$PatientIDNumber', '$PatientName', '$DateOfBirth', '$BloodType', 
            '$Sex', '$Address', '$PhoneNumber');";

?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php

$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

if(mysqli_affected_rows($conn)==1){
echo "Patient Checkin";
print $PatientName;
echo " Successed!";
}
else 
{
echo "Failed to checkin patient";
print $PatientName;
echo "!";
}

print "</pre>";

mysqli_close($conn);

?>


