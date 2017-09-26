<?php
include("db.php");


//Web service for send SMS, Sending by post the number and message 

//define variables and set to empty values
$user =  "";
$password = "";
$destination = "";
$message = "";

//connect to db to get user and password of this api
$db = getUserPasswordSMS();

$user = $db["user"];
$password = $db["password"];

//check if the post recived is safe
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  $destination = chek($_POST["destination"]);
  $message = chek($_POST["message"]);
}

function chek($post){
  //Protects us from sql injection
  $post = str_ireplace("SELECT","",$post);
  $post = str_ireplace("COPY","",$post);
  $post = str_ireplace("DELETE","",$post);
  $post = str_ireplace("DROP","",$post);
  $post = str_ireplace("DUMP","",$post);
  $post = str_ireplace(" OR ","",$post);
  $post = str_ireplace("LIKE","",$post);
  $post = str_ireplace("--","",$post);
  $post = str_ireplace("^","",$post);
  $post = str_ireplace("[","",$post);
  $post = str_ireplace("]","",$post);
  $post = str_ireplace("*","",$post);

  //check if it's empty for safe time and memory
  if (empty($post)) {
    printf("Empty parameter");
    exit;
  }

  return $post;
}


// check if destination only contains a numbers
if (!preg_match("/^[0-9 ()+]*$/",$destination)) {
  var_dump($destination);
  echo "The destination have wrong parameters";
  exit;
}


require_once(dirname(__FILE__) . '/No2SMS_Client.class.php');

//display of advanced message information, number of SMS used, etc.
//var_dump(No2SMS_Client::message_infos($message, TRUE));
//var_dump(No2SMS_Client::test_message_conversion($message));

// new api client
$client = new No2SMS_Client($user, $password);

try {
    //test user
    if (!$client->auth())
        die('Wrong user or password');

    //send message
    print "-Send-\n";
    $res = $client->send_message($destination, $message);
    //var_dump($res);
    $id = $res[0][2];
    printf("SMS-ID: %s\n", $id);


    print "-Status-\n";
    $res = $client->get_status($id);
    //var_dump($res);
    print($res["last_status_text"]."\n");

    // Shows the remaining credits 
    $credits = $client->get_credits();
    printf("-Credits- You still have %d \n", $credits);

} catch (No2SMS_Exception $e) {
    printf("Connection problem: %s", $e->getMessage());
    exit(1);
}

?>
