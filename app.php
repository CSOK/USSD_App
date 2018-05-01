<?php 
    // // Try using POST with online NGROK and sandbox
	// $phonenumber = $_GET['MSISDN'];  
    // $sessionID = $_GET['sessionId'];  
    // $servicecode = $_GET['serviceCode'];  
    // $ussdString = $_GET['text'];

    $phonenumber = $_POST['phoneNumber'];
    $sessionID = $_POST['sessionId'];  
    $servicecode = $_POST['serviceCode'];  
    $ussdString = $_POST['text'];

    /*
    * Use this format in settings.php file
    *
    $servername = "localhost";
    $dbase_username = "root";
    $password = "";
    $dbname="csok_ussd";
    */

    // Sandbox Settings, Database Settings
    require_once('settings.php');

    require_once('Register.php');

    require_once('About.php');

    require_once('Social.php');

    // Create connection **MYSQLI
	$conn = new mysqli($servername, $dbase_username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$level =0; 

	if($ussdString != ""){  
	    $ussdString=  str_replace("#", "*", $ussdString);  
	    $ussdString_explode = explode("*", $ussdString);
	    $level = count($ussdString_explode);  
    }

    //echo ussd_text
    function ussd_proceed ($ussd_text){  
    	echo $ussd_text;  
    }

    if ($level==0){
        displaymenu();
    }     
    if ($level>0){  
        switch ($ussdString_explode[0]) {  
            case 1: //Register
                $registration = new Register();
                $registration->register($ussdString_explode,$phonenumber, $conn);
                break;  
            case 2:  //About
                $about = new About();
                $about->about();  
                break;
            case 3:  //Social Links
                $social = new Social();
                $social->social();				   
                break; 
            default:
                $ussd_text = "END Ooops! We didn't recognize that response!";
                ussd_proceed($ussd_text);
                break; 
        }  //End switch
    }  

    function displaymenu(){  
		$ussd_text="CON Computer Society of Kimathi\n1: Register\n2: About Us\n3: Get Social";  
		ussd_proceed($ussd_text);  
    }
?>