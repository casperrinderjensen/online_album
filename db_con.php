<?php 

// Opret forbindelse til mySQL serveren ved brug af mysqli metoden

// 1. Variabler (konstanter) til forbindelsen
// const (konstanten) navn skrives ALTID med store bogstaver

const HOSTNAME = 'localhost'; //Server 
const MYSQLUSER = 'root'; // Bruger
const MYSQLPASS = 'root'; // Adgangskode
const MYSQLDB = 'image_gallery'; // Database navn

// 2. Forbindelsen via mysqli metode

$con = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

// For at sikre sig at alle utf8-tegn kan bruges under forbindelsen
$con->set_charset('utf8');

// 3. Tjek
//Hvis der er fejl i forbindelsen

if($con->connect_error){
	die($con->connect_error);
}

// Hvis forbindelsen kører uden problemer
else {
	//echo '<p>Der er ingen problemer med forbindelsen! Jeg kan se databasen.</p>';
}
	
	
	
// PHP slut tag kan undlades, hvis filen KUN indeholder "rent" PHP