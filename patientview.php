<?php

include('connectionData.txt');

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

$patientname = $_POST['patientname'];

$patientname = mysqli_real_escape_string($conn, $patientname);
// this is a small attempt to avoid SQL injection
// better to use prepared statements


$query = "SELECT p.PatientIDNumber, p.PatientName, p.DateOfBirth, 
        p.BloodType, p.Sex, p.Address, p.PhoneNumber
          FROM hospital.Patient p 
            WHERE p.PatientName =  ";
$query = $query.'"'.$patientname.'" ;';

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

print "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[PatientIDNumber]  $row[PatientName] $row[DateOfBirth] $row[BloodType] $row[Sex] $row[Address] $row[PhoneNumber]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>


