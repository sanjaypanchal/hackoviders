<%-- 
    Document   : index
    Created on : Jun 11, 2020, 7:30:06 PM
    Author     : ChintanThaker
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./css/style.css">
        <title>Patient details</title>
    </head>
    
<div class="history-box">
    <h2>Medis Hospitals</h2>
    
  <h3>Patient Diagnostics</h3>
  <form name="pdetails" id="pdetails"  method="post" action="./patientDiag.jsp">
    <div class="user-box">
      <input type="text" name="pname" required="">
      <label>Name</label>
    </div>
    <div class="user-box">
      <input type="text" name="pcell" required="">
      <label>Cell no.</label>
    </div>
    <div class="user-box">
        <textarea  name="docdiag" id="docdiag" required=""></textarea>
      <label>Diagnostics.</label>
    </div>
      <a href="#" onclick='document.getElementById("pdetails").submit();'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Back
    </a>
      &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#" onclick='document.getElementById("pdetails").submit();' al>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Submit
    </a>
  </form>
</div>


</html>
