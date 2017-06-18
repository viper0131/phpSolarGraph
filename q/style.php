<?php header("Content-type: text/css"); 
include "Parameters.php";
include "par_verwerking.php";
?>
#containerEO{
	width:auto;	
	margin-left:200px;	
	padding:0;}
#dagEO{	
	width:550px;
	float:left;}
#maandEO{	
	width:550px;
	float:left;
	clear:right;}
#jaarEO{	
	width:550px;
	float:left;}
#totaalEO{	
	width:550px;
	float:left;
	clear:right;}
.bannerdag{	
	float:left;}
.bannermaand{	
	float:left;}
#tabelgeg1{	
	width:900px;}
#verplaats{	
	margin-top:-20px;	
	font-family:Verdana;	
	text-align:center;	
	font-size:14px;}
.verplaats{	
	margin-top:-20px;	
	font-family:Verdana;	
	text-align:center;	
	font-size:14px;}
.eenblad{
	width:580px;	
	font-family:Verdana;
	text-align:center;
	font-size:10px;}
#radioknop{	
	text-align:center;	
	margin-top:-20px;}
#menus{
	float:left;
	width:200px;}
#container{	
	margin-left:20px;	
	padding:0;}
#versie{
	padding-top:5px;
	font-family:Verdana;	
	text-align:center;	
	font-size:10px;}
#plus_min{
	float:left;
	padding-left:50px;}
.sbutton{
	background-image: url(images/glow-ani.gif);
	width:33px;}
.sbutton1{	
	background-image: url(images/glow-ani.gif);	
	width:55px;}
.sbutton2{	
	background-image: url(images/glow-ani.gif);
	width:140px;}
.buttonj{
	font-size:18px;
	font-weight:bold;
	border:0px solid #EFEFEF;
	background: #EFEFEF;
	color: #000000; }
.sbuttonmaxmin{	
	width:100px;
	font-family:Verdana;
	font-weight:bold;	
	text-align:center;	
	font-size:18px;}
#inform{
	padding-left:120px;
	float:left;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
#inform1{
	float:left;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
#inform2{
	font-size:18px;
	font-weight:bold;}
#foto{	
	padding-left: 15px;}
#gif{
	padding-left:270px;
	padding-top:10px;}
#bodytext{
	<?php echo "width:".$iwidth."px;}";?>
#tabelgegevens{
	float:left;
	text-align:left;
	padding-left:100px;
	font-family:Verdana;
	font-size:14px;}
#gegevens{
	font-family:Verdana;	
	text-align:center;
	font-size:14px;}
#gegevens1{	
	font-family:Verdana;	
	font-size:14px;}
#showcode{	
	font-family:Courier;	
	font-size:10px;}
#tabelgeg{
	margin-top:5px;}
#kalender{
	margin-top:5px;}
.top-left, .top-right, .bottom-left, .bottom-right { 
	background-image: url('images/corners1280x18.gif'); /* CHANGE: path and name of your image */
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

	background:url('images/glow-ani.gif') 50% 0;}

.notopgap{ 

	margin-top: 0px; }    /* DNC: to avoid splitting of the box */

.nobottomgap { 

	margin-bottom: -1px; 

	padding-bottom: 1px; } /* DNC: to avoid splitting of the box */

#footer{	

	margin-left:209px;	

	margin-top:20px;	

	padding:0;}

body{    

	font-family: Georgia, "Times New Roman",Times, serif;	

	background: url(images/funky_background.gif) repeat-y fixed;}

#afstand{	

	margin-top:0px;

	margin-left:0px;}

#afstand1{	

	margin-top:10px;	

	margin-left:0px;}

#container1{	

	margin-left:10px;	

	width:160px;	}

#Logo img{	

	margin-left:0px;}

#Weer{	

	margin-left:10px;	

	width:160px;

	background-color: transparent;

	background: transparent;}

#kleinefotos{	

	margin-left:4px;}

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



#resize {

<?php 

	echo "width:".$iwidth."px;"; 

	echo "height:".$iheight."px;";

	echo "background-color:".$kleurachtergronddiv.";";  

?>

	padding: 0px 1px 1px 0px;}

#resizekl { 

	float:left; 

	width: 100px; 

	height: 80px; 

	padding: 0px 3px 3px 0px; }

#tabelgeg2{	

	width:700px;}

#tabelgeg2 h2{	

	font-size :12px ;	

	color :#FFFFFF ;	

	background-color:#2D7575;	

	height:20px;	

	font-family:Georgia;	

	padding-left:25px;	

	padding-top:3px;	

	margin-top:0px;}

#tabelgeg2 h3{	

	font-size :25px ;	

	color :#FFFFFF ;	

	background-color:#2D7575;	

	height:30px;	

	font-family:Georgia;	

	padding-left:150px;	

	padding-top:0px;	

	margin-top:0px;}

#bannertweeindex{	

	float:right;}	

#welkomdown{		

	color :#2A2B2B;		

	font-size:12px;		

	font-family :Verdana ;}		

#welkom{		

	color :#2A2B2B;		

	font-size:12px;		

	font-family :Verdana ;}

#welkom img{		

	float:left;		

	margin:4px 4px 4px 4px;		

	WIDTH:160px; 	

	HEIGHT:120px;}

#sketchup{		

	float:right;}

#tabelgegindex{		

	float:left;		

	margin-right:4px;}

#tabelgegindex td,th{		

	border:solid 1px navy;		

	padding:0px 5px 0px 5px;		

	font-size:10px;		

	font-family :Verdana ;}

#tabelgegindex table{		

	border-collapse:collapse;}

	

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
#navadmin, #navadmin ul {
	padding: 0;
	margin: 0;
	list-style: none;}
#navadmin ul {
	margin: -1em 0 0 5em;
	position: absolute;
	left: -1000px;
	background: #EFEFEF;
	border:1px solid #C00000;
	width:200px;} 
#navadmin li:hover ul, #nav li.ie_does_hover ul {
	left: auto;
	background-position: 0 0;
	z-index:1;} 
#navadmin a {
display: block;} 
#eerste10{
	float:left;}
#refer{
	float:left;
	margin-top:10px;}
#laatste10{
	margin-left:30px;}
#euro{
	margin:10px 0px 0px 10px;}
#bannerfooter{
	width:auto;	
	margin-left:200px;	
	padding:0;}

	