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


$query = "
select PatientName, PaymentAmount,CardholderName  
from Patient join PaymentForService using(PatientIDNumber)
join DebitCreditPayment using(ReceiptNumber); ";
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
print "The list of patient for whom debit or credit payment was made are \n";
Print "Patient Name  Payment Amount       Card Holder Name";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    
    print "$row[PatientName]       $row[PaymentAmount]          $row[CardholderName]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>


