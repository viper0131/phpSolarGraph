<?php header("Content-type: text/css"); 
include "Parameters.php";


include "connect.php";

$sqlpar="SELECT *
	FROM ".$prefixpar."_parameters"; 
//echo $sqlpar;
	$resultpar = mysql_query($sqlpar); //or die(header('location:opstart_installatie.php?fout=table'));
	if (!$resultpar)
		echo ".verborgen{display:none;}";
	else{
		if(mysql_num_rows($resultpar)==0)
			echo ".verborgen{display:none;}";
		else{
			include "par_verwerking.php";
			if(isset($sInvullen_gegevens)){
				if($sInvullen_gegevens=="Invullen_gegevens_sunny_explorer")
					echo ".verborgen{display:block;}";
				else
					echo ".verborgen{display:none;}";
			}
			else
				echo ".verborgen{display:none;}";
		}
	}
?>

#bodytextparm{
	width:700px;
	font-size:12px;		
	font-family :Verdana ;}
#menus{
	float:left;
	width:200px;}
#container{	
	margin-left:200px;	
	padding:0;}
#versie{
	padding-top:5px;
	font-family:Verdana;	
	text-align:center;	
	font-size:10px;}
#bodytext{
	width:700px;}

.top-left, .top-right, .bottom-left, .bottom-right { 
	background-image: url('jpg/corners1280x18.gif'); /* CHANGE: path and name of your image */
	height: 9px;       /* CHANGE: replace by the height of one of your corners (= 1/2 height of the image) */
	font-size: 2px;    /* DNC: correction IE for height of the <div>'s */
	}
.top-left, .bottom-left { 
	margin-right: 9px; /* CHANGE: replace by the width of one of your corners */
	}
.top-right, .bottom-right { 
	margin-left: 9px;  /* CHANGE: replace by the width of one of your corners */
	margin-top: -9px;  /* CHANGE: replace by the height of one of your corners */
	}
.top-right {
	background-position: 100% 0;    /* DNC: position right corner at right side, no vertical changes */
	}
.bottom-left  { 
	background-position: 0 -9px;    /* CHANGE: replace second number by negative height of one of your corners */
	}
.bottom-right { 
	background-position: 100% -9px; /* CHANGE: replace second number by negative height of one of your corners */
	}
.inside {
	border-left: 1px solid #C00000; /* YCC: color & properties of the left-borderline */
	border-right: 1px solid #C00000;/* YCC: color & properties of the right-borderline */
	background: #EFEFEF;            /* YCC: background-color of the inside */
	color: #000000;                 /* YCC: default text-color of the inside */
	padding-left: 10px;             /* YCC: all texts at some distance of the left border */
	padding-right:0px;             /* YCC: all texts at some distance of the right border */	
	margin-top:0px;}
.inside ul{
	list-style:none;
	padding:0;
	margin:0;
	font-family:Georgia;font-size:13px;}
.inside ul a{
	color :#000000 ;
	text-decoration :none ;
	display:block;
	padding:0;margin:0;}
.inside ul a:hover{
	background:url('jpg/glow-ani.gif') 50% 0;}
.notopgap{ 
	margin-top: 0px; }    /* DNC: to avoid splitting of the box */
.nobottomgap { 
	margin-bottom: -1px; 
	padding-bottom: 1px; } /* DNC: to avoid splitting of the box */

body{    
	font-family: Georgia, "Times New Roman",Times, serif;	
	background: url(jpg/funky_background.gif) repeat-y fixed;}

#container1{	
	margin-left:10px;	
	width:160px;	}
TABLE {
	border-collapse: collapse;
	font-family: Verdana;
	background-color: #F0F8FF;
	text-align: center;
	empty-cells:hide;}
TABLE.count {
	border-collapse: collapse;
	font-family: Verdana;
	text-align: left;
	background: transparent;}
TD { 
	border: 1px solid #000000;
	padding : 0;}
TH { 
	border: 1px solid #000000;
	padding : 0;}	
TD a{
	color :#000000 ;	
	text-decoration :none ;	
	display:block;}
TD:hover a{ 
	text-align: center;  
	font-weight: bold;  
	background-color: #F0F8FF; 
	width: auto;
	background:url('jpg/glow-ani.gif') 50% 0;}

	
#nav, #nav ul {
	padding: 0;
	margin: 0;
	list-style: none;}

#nav ul {
	margin: -1em 0 0 5em;
	position: absolute;
	left: -1000px;
	background: #EFEFEF;
	border:1px solid #C00000;
	width:160px;} 
#nav li:hover ul, #nav li.ie_does_hover ul {
	left: auto;
	background-position: 0 0;
	z-index:1;} 
#nav a {
display: block;} 

	
