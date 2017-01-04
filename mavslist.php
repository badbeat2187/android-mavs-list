<?php
if(function_exists($_GET['method']))
	{
		$_GET['method']();
	}


function registerUser()
	{


// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$name = $_POST["name"];
			$email = $_POST["email"];
			$password = $_POST["password"];
			$branch = $_POST["branch"];

$contact = $_POST["contact"];
$address = $_POST["address"];

$lat = $_POST["lat"];
$lon = $_POST["lon"];



$uuid = uniqid('', true);

$salt = sha1(rand());
$salt = substr($salt, 0, 10);
$encrypted = base64_encode(sha1($password . $salt, true) . $salt);

$result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());


$no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
			
			$result = mysql_query("SELECT * FROM users WHERE email = '$email' AND active = '1'") or die(mysql_error());$no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {

			$response["success"]="0";
			echo json_encode($response);
		}
		else{
			$response["success"]="-1";
			echo json_encode($response);
		}
		
			
			
		}else{
			$sql = "INSERT INTO users(unique_id, name, email, encrypted_password, salt,branch,address,contact,latitude,longitude) VALUES('".$uuid."','".$name."','".$email."','".$encrypted."', '".$salt."','".$branch."','".$address."','".$contact."','".$lat."','".$lon."')";

$result = mysql_query($sql);

$to      = $email; //Send email to our user
					$subject = 'Signup | Verification'; //// Give the email a subject 
					$message = '

					Thanks for signing up!
					Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

					------------------------
					Username: '.$name.'
					Password: '.$password.'
					------------------------

					Please click this link to activate your account:
					https://omega.uta.edu/~zxm9929/verify.php?email='.$email.'&encrypted='.$encrypted.'

					'; // Our message above including the link
					
					$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send the email
			
			$response["success"]="1";
	echo json_encode($response);
		}
 



//             $response["success"] = 1;
//             $response["uid"] = $user["unique_id"];
//             $response["user"]["name"] = $user["name"];
//             $response["user"]["email"] = $user["email"];


//             echo json_encode($response);
 mysql_close();   

}

function loginUser(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
			$email = $_POST["email"];
			$password = $_POST["password"];
			
			$albums = array();

$result = mysql_query("SELECT * FROM users WHERE email = '$email' AND active = '1'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result1 = mysql_fetch_array($result);
            $salt = $result1['salt'];
            $encrypted_password = $result1['encrypted_password'];

$hash = base64_encode(sha1($password . $salt, true) . $salt);

            // check for password equality
            if ($encrypted_password == $hash) {
				$result = mysql_query("SELECT * FROM users WHERE email = '$email' AND active = '1'");
                // user authentication details are correct
                while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  //$tmp["branch"]= $row["branch"];
  //$tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
            }
        } else {
            // user not found
      $albums["id"]="-1";
echo json_encode($albums);
        }







//	}

}

/**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
     function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
     function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }


function postbs(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$title = $_POST["title"];
			$descp = $_POST["desc"];
			$address = $_POST["address"];
$date = $_POST["date"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$email = $_POST["email"];
$contact = $_POST["contact"];
$rating = $_POST["rating"];

$sql = "INSERT INTO buysell VALUES('','".$title."','".$descp."','".$address."','".$date."','".$lon."','".$lat."','".$email."','".$contact."','0')";
$result = mysql_query($sql);
mysql_close();

			
}
//*************************************************************

function postTop(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$title = $_POST["title"];
			$descp = $_POST["desc"];
			$address = $_POST["address"];


$sql = "INSERT INTO forum VALUES('','".$title."','".$descp."','".$address."')";
$result = mysql_query($sql);
mysql_close();

			
}
//*************************************************************


function posteve(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$title = $_POST["title"];
			$descp = $_POST["desc"];
			$address = $_POST["address"];
$date = $_POST["date"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$email = $_POST["email"];
$contact = $_POST["contact"];
//$rating = $_POST["rating"];

$sql = "INSERT INTO events VALUES('','".$title."','".$descp."','".$address."','".$date."','".$lon."','".$lat."','".$email."','".$contact."','0')";
$result = mysql_query($sql);
mysql_close();

			
}
//**************************************************************

function posthouse(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$title = $_POST["title"];
			$descp = $_POST["desc"];
			$address = $_POST["address"];
$date = $_POST["date"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$email = $_POST["email"];
$contact = $_POST["contact"];
$rating = $_POST["rating"];

$sql = "INSERT INTO house VALUES('','".$title."','".$descp."','".$address."','".$date."','".$lon."','".$lat."','".$email."','".$contact."','0')";
$result = mysql_query($sql);
mysql_close();

			
}
//*************************************************************

function postjobs(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$title = $_POST["title"];
			$descp = $_POST["desc"];
			$address = $_POST["address"];
$date = $_POST["date"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$email = $_POST["email"];
$contact = $_POST["contact"];
$rating = $_POST["rating"];

$sql = "INSERT INTO jobs VALUES('','".$title."','".$descp."','".$address."','".$date."','".$lon."','".$lat."','".$email."','0','".$Contact."')";
$result = mysql_query($sql);
mysql_close();

			
}
//*************************************************************

function searchjb(){

// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 
 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	$search=$_POST['search'];
 $sql = "SELECT * FROM jobs WHERE title = '".$search."'";
 $result = mysql_query($sql);
 while($row=mysql_fetch_assoc($result))
  $output[]=$row;
 print(json_encode($output));
 mysql_close();
}

//**************************************************************

function getEvents(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$albums = array();

  $result = mysql_query("SELECT * FROM events");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
 mysql_close();   

}   

//************************
//**************************************************************

function getHouse(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$albums = array();

  $result = mysql_query("SELECT * FROM house");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
 mysql_close();   

}   

//**************************************************************

function getJobs(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$albums = array();

  $result = mysql_query("SELECT * FROM jobs");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
 mysql_close();   

}   
//**************************************************************

function getTp(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$albums = array();

  $result = mysql_query("SELECT * FROM forum");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["id"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
 mysql_close();   

}   

//**************************************************************

function getBs(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$albums = array();

  $result = mysql_query("SELECT * FROM buysell");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($albums, $tmp);
}

echo json_encode($albums);
 mysql_close();   

}   
//******************************************************

function getBsResults(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$nikhil = array();
$searchbs = array();
$nikhil = $_POST["search"];

  $result = mysql_query("SELECT * FROM buysell WHERE title like '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}

//******************************************************

function getTpResults(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$nikhil = array();
$searchbs = array();
$nikhil = $_POST["search"];

  $result = mysql_query("SELECT * FROM forum WHERE title like '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["id"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}

//******************************************************

function getHouseResults(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$nikhil = array();
$searchbs = array();
$nikhil = $_POST["search"];

  $result = mysql_query("SELECT * FROM house WHERE title like '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}

//******************************************************

function getJobsResults(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$nikhil = array();
$searchbs = array();
$nikhil = $_POST["search"];

  $result = mysql_query("SELECT * FROM jobs WHERE title like '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}



//******************************************************

function getEventsResults(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchbs = array();
$nikhil = $_POST["search"];

  $result = mysql_query("SELECT * FROM events WHERE title LIKE '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}

//******************************************************

function getEventsResultsGET(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchbs = array();
$nikhil = $_GET["search"];

  $result = mysql_query("SELECT * FROM buysell WHERE title LIKE '%".$nikhil."%'");
            // return user details




 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);
//echo json_encode($nikhil); 
mysql_close();      

}


//******************************************************

function getBsPost(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchbs = array();
$nikhil = $_POST["id"];

  $result = mysql_query("SELECT * FROM buysell WHERE uid = '".$nikhil."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  $tmp["lat"]= $row["latitude"];
  $tmp["lon"]= $row["longitute"];
  	
  $tmp["contact"]= $row["contact"];
$tmp["email"]= $row["email"];

  array_push($searchbs, $tmp);
}

echo json_encode($searchbs);

//echo json_encode($nikhil); 
mysql_close();      


}

//******************************************************
//******************************************************

function getTpPost(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchtp = array();
$nikhil = $_POST["id"];

  $result = mysql_query("SELECT * FROM forum WHERE id = '".$nikhil."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["id"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  

  array_push($searchtp, $tmp);
}

echo json_encode($searchtp);

//echo json_encode($nikhil); 
mysql_close();      


}
///////////////////////////////////////////////////
function getHousePost(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchhs = array();
$nikhil = $_POST["id"];

  $result = mysql_query("SELECT * FROM house WHERE uid = '".$nikhil."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
$tmp["lat"]= $row["latitude"];
  $tmp["lon"]= $row["longitute"];
  $tmp["contact"]= $row["contact"];
  
array_push($searchhs, $tmp);
}

echo json_encode($searchhs);

//echo json_encode($nikhil); 
mysql_close();      


}

//******************************************************

function getJobsPost(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searchjs = array();
$nikhil = $_POST["id"];

  $result = mysql_query("SELECT * FROM jobs WHERE uid = '".$nikhil."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
$tmp["lat"]= $row["latitude"];
  $tmp["lon"]= $row["longitute"];
  $tmp["contact"]= $row["contact"];

  array_push($searchjs, $tmp);
}

echo json_encode($searchjs);

//echo json_encode($nikhil); 
mysql_close();      


}

//******************************************************

function getEventsPost(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
//$nikhil = array();
$searcheve = array();
$nikhil = $_POST["id"];

  $result = mysql_query("SELECT * FROM events WHERE uid = '".$nikhil."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();

  $tmp["id"] = $row["uid"];
  $tmp["name"]= $row["title"];
  $tmp["desc"]= $row["descp"];
  $tmp["contact"]= $row["contact"];
  $tmp["date"]= $row["date"];
  $tmp["add"]= $row["address"];
  $tmp["lat"]= $row["latitude"];
  $tmp["lon"]= $row["longitute"];


  array_push($searcheve, $tmp);
}

echo json_encode($searcheve);

//echo json_encode($nikhil); 
mysql_close();      


}

//******************************************************

function fakeBS(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$fakebs = array();
$post = $_POST["id"];
$user = $_POST["userid"];

  $result = mysql_query("SELECT * FROM fakebs WHERE uid = '".$user."' AND pid='".$post."'");
  
            // return user details


        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {

            // user already rated
$tmp = array();
$tmp["success"] = "1";
  array_push($fakebs, $tmp);



            echo json_encode($fakebs);
        } else {
            // user not rated
$tmp = array();
$tmp["success"] = "0";
$sql = "INSERT INTO fakebs VALUES('".$user."','".$post."')";


$query= mysql_query("select rating from buysell where uid = '".$post."'");


 while($row=mysql_fetch_assoc($query)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $rating= $row["rating"];
 }
$rating = $rating +1; 


$sqlq= mysql_query("UPDATE buysell SET rating='".$rating."'
WHERE uid='".$post."'");




$sql = "INSERT INTO fakebs VALUES('".$user."','".$post."')";

$result = mysql_query($sql);
  array_push($fakebs, $tmp);


            echo json_encode($fakebs);
        }




mysql_close();      


}
//////////////////////////////////////////////////////////
function fakeHS(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$fakehs = array();
$post = $_POST["id"];
$user = $_POST["userid"];

  $result = mysql_query("SELECT * FROM fakehs WHERE uid = '".$user."' AND pid='".$post."'");
  
            // return user details


        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {

            // user already rated
$tmp = array();
$tmp["success"] = "1";
  array_push($fakehs, $tmp);



            echo json_encode($fakehs);
        } else {
            // user not rated
$tmp = array();
$tmp["success"] = "0";
$sql = "INSERT INTO fakehs VALUES('".$user."','".$post."')";


$query= mysql_query("select rating from house where uid = '".$post."'");


 while($row=mysql_fetch_assoc($query)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $rating= $row["rating"];
 }
$rating = $rating +1; 


$sqlq= mysql_query("UPDATE house SET rating='".$rating."'
WHERE uid='".$post."'");




$sql = "INSERT INTO fakehs VALUES('".$user."','".$post."')";

$result = mysql_query($sql);
  array_push($fakehs, $tmp);


            echo json_encode($fakehs);
        }




mysql_close();      


}
//////////////////////////////////////////////////////////

function fakeJB(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$fakejb = array();
$post = $_POST["id"];
$user = $_POST["userid"];

  $result = mysql_query("SELECT * FROM fakejb WHERE uid = '".$user."' AND pid='".$post."'");
  
            // return user details


        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {

            // user already rated
$tmp = array();
$tmp["success"] = "1";
  array_push($fakejb, $tmp);



            echo json_encode($fakejb);
        } else {
            // user not rated
$tmp = array();
$tmp["success"] = "0";
$sql = "INSERT INTO fakejb VALUES('".$user."','".$post."')";


$query= mysql_query("select rating from jobs where uid = '".$post."'");


 while($row=mysql_fetch_assoc($query)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $rating= $row["rating"];
 }
$rating = $rating +1; 


$sqlq= mysql_query("UPDATE jobs SET rating='".$rating."'
WHERE uid='".$post."'");




$sql = "INSERT INTO fakejb VALUES('".$user."','".$post."')";

$result = mysql_query($sql);
  array_push($fakejb, $tmp);


            echo json_encode($fakejb);
        }




mysql_close();      


}
//////////////////////////////////////////////////////////
function fakeEVE(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);
	
$fakeeve = array();
$post = $_POST["id"];
$user = $_POST["userid"];

  $result = mysql_query("SELECT * FROM fakeeve WHERE uid = '".$user."' AND pid='".$post."'");
  
            // return user details


        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {

            // user already rated
$tmp = array();
$tmp["success"] = "1";
  array_push($fakeeve, $tmp);



            echo json_encode($fakeeve);
        } else {
            // user not rated
$tmp = array();
$tmp["success"] = "0";
$sql = "INSERT INTO fakeeve VALUES('".$user."','".$post."')";


$query= mysql_query("select rating from events where uid = '".$post."'");


 while($row=mysql_fetch_assoc($query)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $rating= $row["rating"];
 }
$rating = $rating +1; 


$sqlq= mysql_query("UPDATE events SET rating='".$rating."'
WHERE uid='".$post."'");




$sql = "INSERT INTO fakeeve VALUES('".$user."','".$post."')";

$result = mysql_query($sql);
  array_push($fakeeve, $tmp);


            echo json_encode($fakeeve);
        }




mysql_close();      


}
//////////////////////////////////////////////////////////



function getAccount(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);

$searchacc = array();
$id = $_POST["id"];

$result = mysql_query("SELECT * FROM users WHERE uid = '".$id."'");
  
            // return user details


 while($row=mysql_fetch_assoc($result)){
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
  $tmp = array();
  $tmp["name"] = $row["name"];
  $tmp["email"]= $row["email"];
  $tmp["address"]= $row["address"];
  $tmp["contact"]= $row["contact"];
  $tmp["branch"]= $row["branch"];
    $tmp["lat"]= $row["latitude"];
  $tmp["lon"]= $row["longitude"];


  array_push($searchacc, $tmp);
}

echo json_encode($searchacc);


mysql_close();      


}

//////////////////////////////////////////////////////////



function editAccount(){
// Database Host
 $db_host  = "omega.uta.edu";
 // Database User
 $db_uid  = "zxm9929";
 // Database Password
 $db_pass = "GXKb=8eTF";
 // Database Name
 $db_name  = "zxm9929"; 

 $db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
 mysql_select_db($db_name);

$searchacc = array();
$id = $_POST["id"];
$name= $_POST["name"];
$address = $_POST["address"];
$contact = $_POST["contact"];
$lon = $_POST["lon"];
$lat = $_POST["lat"];



$sqlq= mysql_query("UPDATE users SET name='".$name."',address='".$address."',contact='".$contact."',latitude='".$lat."',longitude='".$lon."'
WHERE uid='".$id."'");





mysql_close();      


}





 ?>