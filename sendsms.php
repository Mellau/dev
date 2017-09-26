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

//check if the post recived is ok
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  $destination = chekempty($_POST["destination"]);
  $destination = chekparameters($destination);
  $message = chekempty($_POST["message"]);
}

function chekempty($post){
  //check if it's empty for safe time and memory
  if (empty($post)) {
    printf("Empty parameter");
    exit;
  }
  return $post;
}

function chekparameters($number){
  // check if destination only contains a phone number
  if (!preg_match("/^[0-9 ()+]*$/",$number)) {
    var_dump($destination);
    echo "The destination have wrong parameters";
    exit;
  }
  return $number;
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
    var_dump($res);

    // Shows the remaining credits 
    $credits = $client->get_credits();
    printf("-Credits- You still have %d \n", $credits);

} catch (No2SMS_Exception $e) {
    printf("Connection problem: %s", $e->getMessage());
    exit(1);
}

?>
