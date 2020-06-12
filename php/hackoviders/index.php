<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="javascript" src="Library/javascript_functions.js"></script>
        <link rel="stylesheet" href="./css/main.css">
		<link rel="stylesheet" type="text/css" href="Library/main.css" />
		<title>Integrated Health System - Login</title>
    </head>
	<head>
	</head> 
    
<div class="login-box">
    <h2>Hackovider Hospitals</h2>

	<body onLoad="setFocus('txtUser')">
		<?php
		include 'Library/common_functions.php';
		$txtEncryptedPassword = md5($txtPassword);
		$host = "$_SERVER[SERVER_NAME]";
		ini_set('register_globals', true);
		?>
        <form name="login" id="login"  method="get" action="./patientDetails.php">
	

  <h3>Login</h3>
  <!-- <form name="login" id="login"  method="post" action="./patientDetails.jsp"> -->
    <div class="user-box">
      <input type="text" name="txtUser" required="">
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="password" name="txtPassword" required="">
      <label>Password</label>
    </div>
    
      <a href="#?login=true" name="btnSubmit" onclick='document.getElementById("login").submit();'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Login 
    </a>
	<?php print $_GET['login']; ?>
    <input type="hidden" name="btnSubmit" value='<?php print $_GET['login']; ?>' required="">

  </form>
</div>

		
		
	</body>
</html>

