<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="javascript" src="Library/javascript_functions.js"></script>
        <link rel="stylesheet" href="./css/main.css">
		<link rel="stylesheet" type="text/css" href="Library/main.css" />
        <title>Patient details</title>
    </head>
    

<div class="login-box">
  <h2>Hackovider Hospitals</h2>
  <h3>Patient Details</h3>
  <form name="getotp" id="getotp" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <div class="user-box">
      <input type="text" name="paadhar" required="" value="<?php echo $paadhar; ?>">
      <label>Enter Patient's Aadhar number</label>
        
    </div>
      <a href="#&get_otp=true" name="get_otp" onclick='document.getElementById("getotp").submit();'>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Get OTP
        </a>
    </form>
  
	<?php
	if ($otp != "")
	{
		header ("Location:./patientHistory.php?paadhar=$paadhar");
	}

    if ($paadhar != ""){
		?>
		<div class="user-box">
		<label>OTP sent successfully to registered number!!!</label>
    <br/>
	<br/><br/><BR>


    <form name="submitotp" id="submitotp" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> 
    <input type="hidden" name="paadhar" value="<?php echo $paadhar; ?>" required="">

	<div class="user-box">
      <input type="text" name="otp" required= value="<?php echo $otp; ?>">
      <label>OTP</label>
    </div>
     
    <a href="#" name="next" onclick='document.getElementById("submitotp").submit();'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Next
    </a>
  </form>
  <?php
  	}
  ?>
</div>


</html>
