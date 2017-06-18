<?php
include "../Parameters.php";
include "../sessionstart.php";
include "../fout.php";
//include "Keuze.php";
//$str_json="{};";
include "../header.php";
?>
<div id="container" >
<?php 
echo'
	<div id="bodytext">
		<div class="top-left"></div><div class="top-right"></div>
		<div class="inside">
			<h1 class="notopgap" align="center">'.$installation.'</h1>
			<div id="tabelgegevens">
					Plaats<br>
					Module<br>
					Omvormer<br>
					Inbedrijfstelling<br>
					Orientatie<br>
					Data captatie<br>
					Uitvoerder
			</div>
			<div id="gegevens1">
				     <p>: '.$plaats.'<br>
					: <a href="'.$panelUrl.'" TARGET="_blank">'.$panels.'</a><br>
					: '.$omvormer.'<br>
					: '.$startUsing.'<br>
					: '.$orientatie.'<br>
					: '.$dataLogging.'<br>
					: <a href="'.$installerUrl.'" TARGET="_blank">'.$installedBy.'</a></p>
			</div>
			<div id="foto">
				<a href="images/panelsInMorningSun.jpg" target="_blank"><img src="images/panelsInMorningSun.jpg" alt="My panels in the morning sun!" width="400" height="300" hspace="10" style="border: solid 1px black;">
				<a href="images/convertorFirstDelivery.jpg" target="_blank"><img src="images/convertorFirstDelivery.jpg" alt="Powerstocc 5.5" width="400" height="300" hspace="10" style="border: solid 1px black;">
			</div>
			<p class="nobottomgap"></p>
		</div>
		<div class="bottom-left"></div><div class="bottom-right"></div>			
	</div>
	';
?>

</div>

<?php
include "../footer.php";
?>
