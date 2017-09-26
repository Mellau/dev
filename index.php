<!DOCTYPE HTML>  
<html>

<h2>Send SMS</h2>
<form method="post" action="sendsms.php">  
  Destination: <input type="tel" name="destination" required>
  <br><br>
  Message: <textarea type="text" name="message" required></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</html>