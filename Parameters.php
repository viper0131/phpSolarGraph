<?php
	$versionnumber  = "0.1";

	//
	// Info about the used database
	//
	$sserver        = $_ENV['OPENSHIFT_DB_HOST'];
	$susername      = $_ENV['OPENSHIFT_DB_USERNAME'];
	$spassword      = $_ENV['OPENSHIFT_DB_PASSWORD'];		
	$sdatabase_name = "SolarGraph";	
	$dbPrefix       = "zon";

	//
	// Info about our convertor
	//
	$PIKO_PASSWD      = "pvwr";
        //$PIKO_ADDRESS   = "pv.vanampting.com";
        $PIKO_ADDRESS     = "82.95.120.155:8080";
        $PIKO_COEF        = 1;
        $checkInterval    = 15;  // in minutes
        $pikoStarted      = 1344763630;  //unix epoch: 12-08-12 9:27:10 GMT
        
        $YOULESS_ADDRESS  = "82.95.120.155:8081";  //"192.168.1.50";
        $Sense		  = 50;  
	//
	// Info about our installation
	//
        $installation = "PVDEHOEK";
	$plaats       = "Haalderen";
	$panels       = "27 * CentroSolar S-Class Professional Polykristallijn 245 wp";
	$InstalledWp  = 6615;
	$panelUrl     = "http://www.centrosolar.nl/producten/zonnepanelen/s-class-professional/";
	$omvormer     = "Solarstocc 5.5 Excellent (=Kostal Piko 5.5)";
	$orientatie   = "Oost (102 graden), 20 graden hellingshoek" ;
	$startUsing   = "12-augustus-2012";
	$dataLogging  = "Building my own....";
	$installedBy  = "Installatiebedrijf Pere";
	$installerUrl = "http://www.installatiebedrijfpere.nl";


?>
