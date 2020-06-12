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

<?php  
  	include 'Library/common_functions.php';
	connect_db();
	$symptom = "Patient has lung cancer, but did not smoke. She may consider chemotherapy as part of a treatment plan. mucinex, paracetamol";

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

  <h3>Patient Diagnostics</h3>

    <div class="user-box">  
      <label>Aadhar card no.: <?php print $paadhar; ?></label>
      <br/><br/>
      <label>Case no.: <?php print $pat_id; ?></label>
        <br/><br/>
      <label>Patient Name: <?php print $pat_name; ?></label>
        <br/><br/>
      <label>Investigation Date: <?php print $pe_date; ?></label>
        <br/><br/>
	</div>


  <form name="pdetails" id="pdetails"  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="paadhar" value="<?php echo $paadhar; ?>" required="">
	<div class="user-box">
      <label>Symptoms</label><BR><BR>
	  <textarea  name="docdiag" id="docdiag" required=""></textarea>
    </div>
		<?php 
		//print $docdiag; 
		if (trim($docdiag) != "")
		{
			$filename = "result.txt";
			$cmd = "java -cp ./IHS/annotator-for-clinical-data-1.1.1.jar;./IHS/core-6.9.3.jar;./IHS/ibm-watson-8.5.0-jar-with-dependencies.jar;./IHS/ibm-whcs-services-common-1.1.1.jar;./IHS/IHS.jar;./IHS/insights-for-medical-literature-1.1.1.jar IHSApp \"$symptom\" > " . $filename;
			$response = exec($cmd);

			$myfile = fopen("$filename", "r") or die("Unable to open file!");
			$result;
			if ($myfile)
			{
				$result = explode("\n", fread($myfile, filesize($filename)));
			}
			fclose($myfile);

			$data;
			foreach ($result as $element)
			{
				$temp = explode(":", $element);
				$data[$temp[0]] = substr(trim($temp[1]),0,-1);
			}
		}
		?>
    <a href="#" onclick='document.getElementById("pdetails").submit();'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Submit
    </a>
	<br><br>

	<div class="user-box"> 
      <!--<label>Potential Disease: <?php echo substr($data["SymptomDisease"], 0, strpos($data["SymptomDisease"], ",")); ?></label><BR> -->
	  <label>Potential Disease: <?php echo $data["SymptomDisease"]; ?></label><BR>
    </div>
<BR><BR>
    <div class="user-box">
      <label>Medicine to prescribe: <?php echo $data["Medication"]; ?></label>
    </div> 
    
  </form>
</div>


</html>
