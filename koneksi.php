<?php


error_reporting(false);

$u = "root";
$p = "";
$d = "danu";
$s = "localhost";

@$con = mysqli_connect($s,$u,$p,$d);

// Need internet conenction bcoz i need to load some file on cdn such as CSS or JS files ..

if (!$con)
{
	$Pesan = '<br><br><br><br><br><br><br><center>
	<h2><font color=red> Failed to Connect Database </font> </h2>
	<h4> Check Configurasi pada file <i>koneksi.php</i> </h4>

	<br>
	1. configurasi haruslah sama dengan Localhost anda .
	<br>
	2. Oke sip

	
	';
 	die($Pesan); 
}


?>