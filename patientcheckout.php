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
$patientnumber = $_POST['number'];

$patientname = mysqli_real_escape_string($conn, $patientnumber);
// this is a small attempt to avoid SQL injection
// better to use prepared statements


$query = "DELETE FROM hospital.Patient  
            WHERE PatientIDNumber =  ";
$query = $query.'"'.$patientnumber.'" ;';
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
echo "Patient checkout";
print "$patientnumber";
echo " Successed!";
}
else 
{
echo "Failed to checkout patient";
print " $patientnumber";
echo "!";
}

print "</pre>";

mysqli_close($conn);

?>


