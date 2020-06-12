<?php
function connect_db()
{
	// Connecting, selecting database
	//$host = "$_SERVER[SERVER_NAME]";
	$host = $password = $db = "";
	$db_file = "105104115095109097110097103101109101110116046116120116";
	$db_file_dec = decryptPassword($db_file);
	$file=fopen("$db_file_dec","r") or exit("Unable to open db file!!!");
	while(!feof($file))
	{
		$line = fgets($file);
		$line = trim($line);
		if ($line != "")
		{
			list ($host_enc, $db_enc, $password_enc) = split("::", $line);
		}
	}
	fclose($file);
	$host = decryptPassword($host_enc);
	$db = decryptPassword($db_enc);
	$password = decryptPassword($password_enc);
	//echo "host = $host<BR>db=$db<BR>passwd = $password<BR>";
	$link = mysql_connect($host, 'root', $password) or die('Could not connect: ' . mysql_error());
	mysql_select_db($db) or die('Could not select database');
}

function verify_in_db($user, $password)
{
	$query = "SELECT * FROM users where user_username = '$user' and user_password = '$password'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");
	$count = mysql_num_rows($result);

	global $username, $user_id;
//	echo "<BR>count=$count<BR>";
	echo "<BR>$query<BR>";

	if ($count == 1)
	{
		//echo "User verified successfully<BR>";
		while ($row = mysql_fetch_array($result, MYSQL_BOTH))
		{
			$username = $row["user_name"];
			$user_id = $row["user_id"];
		}
	}
	else
	{
		//echo "User does not exist or invalid credentials<BR>";
		$username = "";
		$user_id = 0;
	}

	//echo "username = $username, user_id = $user_id<BR>";
}

function create_session($username, $user_id)
{
	global $session_id;
	session_start();
	$session_id = session_id();
	$_SESSION['user_id'] = "$user_id";
	$_SESSION['username'] = "$username";
	echo "Welcome " . $_SESSION['username'] . " and User Id is " . $_SESSION['user_id'] . ". Session Id is $session_id<BR>";

	$query = "SELECT * FROM session where sess_user_id = $user_id";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");
	$count = mysql_num_rows($result);

	if ($count == 1)
	{
		$query = "update session set sess_details = '$session_id' where sess_user_id = $user_id";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");
	}
	else
	{
		$query = "delete from session where sess_user_id = $user_id";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");

		$query = "insert into session (sess_user_id, sess_details) values ($user_id, '$session_id')";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");
	}

//	return $session_id;
}

function check_session($user_id)
{
	$session_id = session_id();
	//echo "Inside check session, user_id = $user_id<BR>";
	$query = "SELECT * FROM session where sess_user_id = $user_id and sess_details = '$session_id'";
	//echo $query. "<BR>username=$username";
	$result = mysql_query($query) or die("$query<BR>Query failed: " . mysql_error() . "<BR>query:$query");
	$count = mysql_num_rows($result);
	//echo "<BR>Inside check session-$count<BR>";

	if ($count == 1)
	{
		$message = "Session Verified!!!";
	}
	else
	{
		$message = "Session Expired!!!";
	}
	return $message;
}

function destroy_session($user_id)
{
	$session_id = session_id();
	$query = "delete from session where sess_user_id = $user_id";
	echo $query;
	$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>query:$query");
}



function head_menu()
{
	global $username;
	echo "<h3>Welcome $username </h3>";
}

function left_menu($btnSubmit, $user_id)
{
	global $host;
	?>
	<div style='float: left; width: 10%;'>
	<table width=10% border=0>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Expense"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Alerts"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Salary"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Reports"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Expense Type"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Account"/></td></tr>
	<tr><td><input type="submit" name="btnSubmit" id="btnSubmit" value="Logout"/></td></tr>
	</table>
	</div>
	
	<?php
	if ($btnSubmit == "Expense")
	{
		header ("Location:./expense.php");
	}
	else if ($btnSubmit == "Alerts")
	{
		header ("Location:./alerts.php");
	}
	else if ($btnSubmit == "Salary")
	{
		header ("Location:./salary.php");
	}
	else if ($btnSubmit == "Expense Type")
	{
		header ("Location:./expense_type.php");
	}
	else if ($btnSubmit == "Account")
	{
		header ("Location:./user.php");
	}
	else if ($btnSubmit == "Reports")
	{
		header ("Location:./reports.php");
	}
	else if ($btnSubmit == "Logout")
	{
		echo "<BR>$btnSubmit, $user_id<BR>";
		destroy_session($user_id);
		$session_msg = check_session($user_id);

		if ($session_msg == "Session Expired!!!")
		{
			header ("Location:./index.php");
		}	
	}
}




function encryptPassword($dec_password)
{
	$len = strlen($dec_password);
	$enc = "";

	for ($i=0; $i<$len; $i++)
	{
		$char = substr($dec_password, $i, 1);
		$char_a = ord($char);
		$char_a_len = strlen($char_a);

		if ($char_a_len == 3)
		{
			$enc .= $char_a;
		}
		else if ($char_a_len == 2)
		{
			$temp = "0$char_a";
			$enc .= $temp;
		}
		else if ($char_a_len == 1)
		{
			$temp = "10$char_a";
			$enc .= $temp;
		}
		else if ($char_a_len == 0)
		{
			$temp = "000";
			$enc .= $temp;
		}
	}
	return $enc;
}

function decryptPassword($enc_password)
{
	$len = strlen($enc_password);
	$dec = "";

	for ($i=0; $i<$len;$i=$i+3)
	{
		$char = substr($enc_password, $i, 3);
		$char_a = chr($char);
		$dec .= $char_a;
	}
	return $dec;
}


function single_report($values)
{
	global $user_id;
	$img_width=675;
	$img_height=500; 
	$y_margins=30;
	$x_margins=80;
	$margins=30;

 	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $y_margins * 2;
	$graph_height=$img_height - $x_margins * 2; 
	$img=imagecreate($img_width,$img_height);
 
	$bar_width=15;
	$total_bars=count($values);
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);
 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,0,64,128);
	$background_color=imagecolorallocate($img,240,240,255);
	$border_color=imagecolorallocate($img,200,200,200);
	$line_color=imagecolorallocate($img,220,220,220);
	$total_color=imagecolorallocate($img,255,50,50);
 
	# ------ Create the border around the graph ------

	imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
	imagefilledrectangle($img,$y_margins,$margins,$img_width-1-$y_margins,$img_height-1-$x_margins,$background_color);

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values);
	$ratio= $graph_height/$max_value;
 
	# -------- Create scale and draw horizontal lines  --------
	$horizontal_lines=20;
	$horizontal_gap=$graph_height/$horizontal_lines;

	for($i=1;$i<=$horizontal_lines;$i++)
	{
		$y=$img_height - $x_margins - $horizontal_gap * $i ;
		imageline($img,$y_margins,$y,$img_width-$y_margins,$y,$line_color);
		$v=intval($horizontal_gap * $i /$ratio);
		imagestring($img,0,5,$y-5,$v,$bar_color);
	}

	imagestring($img, 4, $graph_width/2 - 20, $graph_height/6, "Total Expense = " . number_format(array_sum($values)), $total_color);
 
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++)
	{ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); 
		$x1= $y_margins + $gap + $i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
		$y1=$x_margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$x_margins;
		imagestring($img,0,$x1+3,$y1-10,number_format($value),$bar_color);
		imagestringup($img,0,$x1+3,$img_height-15,$key,$bar_color);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
	}
	$graph_folder = "Graphs";
	$graph_name = $user_id;
	$graph_file = $graph_folder. "/" . $graph_name.".jpeg";
	imagejpeg( $img, $graph_file, 90);
	imagedestroy($img);
	echo "<img src='".$graph_file."'><p></p>";
}


function double_report ($values_1, $values_2)
{
	global $user_id;
	$img_width=675;
	$img_height=475; 
	$y_margins=30;
	$x_margins=80;
	$margins=30;

 	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $y_margins * 2;
	$graph_height=$img_height - $x_margins * 2; 
	$img=imagecreate($img_width,$img_height);
 
	$bar_width=15;
	//$total_bars_1=count($values_1);
	//$gap_1 = ($graph_width- $total_bars_1 * $bar_width ) / ($total_bars_1 +1);

	//$total_bars_2=count($values_2);
	//$gap_2 = ($graph_width- $total_bars_2 * $bar_width ) / ($total_bars_2 +1);

	$total_bars=count($values_1);
	$gap = ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);
 
	# -------  Define Colors ----------------
	$bar_color_1=imagecolorallocate($img,0,0,100);
	$bar_color_2=imagecolorallocate($img,0,100,0);
	$background_color=imagecolorallocate($img,240,240,255);
	$border_color=imagecolorallocate($img,200,200,200);
	$line_color=imagecolorallocate($img,220,220,220);
	$total_color=imagecolorallocate($img,255,50,50);
 
	# ------ Create the border around the graph ------

	imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
	imagefilledrectangle($img,$y_margins,$margins,$img_width-1-$y_margins,$img_height-1-$x_margins,$background_color);

 
	# ------- Max value is required to adjust the scale	-------
	$max_value_1=max($values_1);
	$ratio_1= $graph_height/$max_value_1;

	$max_value_2=max($values_2);
	$ratio_2= $graph_height/$max_value_2;

	$ratio = min($ratio_1, $ratio_2);
 
	# -------- Create scale and draw horizontal lines  --------
	$horizontal_lines=20;
	$horizontal_gap=$graph_height/$horizontal_lines;

	for($i=1;$i<=$horizontal_lines;$i++)
	{
		$y=$img_height - $x_margins - $horizontal_gap * $i ;
		imageline($img,$y_margins,$y,$img_width-$y_margins,$y,$line_color);
		$v=intval($horizontal_gap * $i /$ratio);
		imagestring($img,0,5,$y-5,$v,$bar_color_1);
	}
 
	imagestring($img, 4, $graph_width/2 - 100, $graph_height/7, "Total Expense for month-1 = " . number_format(array_sum($values_1)), $total_color);
	imagestring($img, 4, $graph_width/2 - 100, $graph_height/5, "Total Expense for month-2 = " . number_format(array_sum($values_2)), $total_color);
 
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++)
	{ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values_1); 
		$x1= $y_margins + $gap + $i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
//		$y1=$x_margins +$graph_height- intval($value * $ratio_1) ;
		$y1=$x_margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$x_margins;
		imagestringup($img,0,$x1+3,$y1-10,number_format($value),$bar_color_1);
		imagestringup($img,0,$x1+3,$img_height-15,$key,$bar_color_1);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color_1);
	}

	for($i=0;$i< $total_bars; $i++)
	{ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values_2); 
		$x1= $y_margins + $gap + $bar_width +$i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
//		$y1=$x_margins +$graph_height- intval($value * $ratio_2) ;
		$y1=$x_margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$x_margins;
		imagestringup($img,0,$x1+3,$y1-10,number_format($value),$bar_color_2);
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color_2);
	}

	$graph_folder = "Graphs";
	$graph_name = $user_id;
	$graph_file = $graph_folder. "/" . $graph_name.".jpeg";
	imagejpeg( $img, $graph_file, 90);
	imagedestroy($img);
	echo "<img src='".$graph_file."'>";
}

?>

