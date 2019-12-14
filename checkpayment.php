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


$query = "select PatientName, PaymentAmount, RoutingNumber 
            from Patient join PaymentForService using(PatientIDNumber)
            join CheckPayment using(ReceiptNumber); ";
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
print "The list of patient for whom check payment was made are \n";
Print "Patient Name  Payment Amount       Routing Number";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    
    print "$row[PatientName]       $row[PaymentAmount]          $row[RoutingNumber]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>


