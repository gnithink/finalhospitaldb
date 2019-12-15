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

$patientname = $_POST['patientname'];

$patientname = mysqli_real_escape_string($conn, $patientname);
// this is a small attempt to avoid SQL injection
// better to use prepared statements


$query = "select PatientName, Category, Description, DateOfRecord
from Patient join MedicalRecord using(PatientIDNumber)
Where PatientName LIKE";
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
    print "$row[PatientName] $row[Category] $row[Description] $row[DateOfRecord]" ;
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>


