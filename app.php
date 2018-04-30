<?php 
    // Try using POST with online NGROK and sandbox
	$phonenumber = $_GET['MSISDN'];  
    $sessionID = $_GET['sessionId'];  
    $servicecode = $_GET['serviceCode'];  
    $ussdString = $_GET['text'];

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
            case 2:  //Update sales
                about();  
                break;
            case 3:  //Profits and losses
                getSocial();				   
                break; 
            default:
                $ussd_text = "Ooops! We don't recognize that response!";
                ussd_proceed($ussd_text);
                break; 
        }  //End switch
    }  

    function displaymenu(){  
		$ussd_text="CON \n1: Register\n2: About Us\n3: Get Social";  
		ussd_proceed($ussd_text);  
    }
?>