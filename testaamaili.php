<?php
	if ($_POST["to"] != "")
	{
		$to = $_POST["to"];
		$msg = "Liitteenä lasku tilaamistasi palveluista.";
		$headers = "From: noreply@palikka.org" . "\r\n";
		mail($to,"Lasku palveluista", $msg, $headers);
		echo "Viesti lähetetty.";
	}
	else
	{
		?>
		Lähetä sähköpostia<br />
		<form action="index.php?sivu=testaamaili" method="post">
			Sähköpostiosoite<br />
        	<input type="text" name="to" class="textinput" /><br />
			<input type="submit" name="submit" value="Lähetä" class="button_default" />
    	</form>                
		<?php
	}
?>
