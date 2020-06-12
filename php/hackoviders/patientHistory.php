<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="javascript" src="Library/javascript_functions.js"></script>
        <link rel="stylesheet" href="./css/main.css">
		<link rel="stylesheet" type="text/css" href="Library/main.css" />
        <link rel="stylesheet" href="./css/style.css">

        <title>Patient details</title>
    </head>
    

<div class="history-box">
  <h2>Hackoviders Hospitals</h2>
  <h3>Patient History</h3>

<?php  
  	include 'Library/common_functions.php';
	connect_db();

	$query = "select pe_id, pe_date, pat_name, pat_id from patient_investigation, patient_info where patient_investigation.pe_pat_id = patient_info.pat_id and patient_info.pat_ssn=\"$paadhar\"";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error() . "<BR>$query");
	$count = mysql_num_rows($result);
			
	while ($row = mysql_fetch_array($result, MYSQL_BOTH))
	{
		$pat_id = $row["pat_id"];
		$pat_name = $row["pat_name"];
		$pe_date = $row["pe_date"];
//		$radType = $row["ex_et_id"];
	}
?>
    <div class="user-box">  
      <label>Aadhar card no.: <?php print $paadhar; ?></label>
      <br/><br/>
      <label>Case no.: <?php print $pat_id; ?></label>
        <br/><br/>
      <label>Patient Name: <?php print $pat_name; ?></label>
        <br/><br/>
      <label>Investigation Date: <?php print $pe_date; ?></label>
        <br/><br/>
      <!-- <label>Last diagnostics : Viral infection </label>
  <br/><br/>
      <label>Last prescription : Paracitamol 500mg </label>
  <br/><br/>
      <label>Chronic disease : None </label> -->
      <br/><br/>
    </div>
  
    <br/><br/><br/>
    <form name="todiag" id="todiag" action="./patientDiag.php">
    <input type="hidden" name="paadhar" required="" value="<?php echo "$paadhar"; ?>">
    
     
   <a href="#" onclick='document.getElementById("todiag").submit();'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Next
    </a>
  </form>
</div>


</html>
