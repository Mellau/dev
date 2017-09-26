<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<h2>Send SMS</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="sendsms.php">  
  Destination: <input type="tel" name="destination" required>
  <span class="error">*</span>
  <br><br>
  Message: <textarea type="text" name="message" required></textarea>
  <span class="error">*</span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>