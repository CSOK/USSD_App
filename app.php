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
                register($ussdString_explode,$phonenumber, $conn);
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

    function register($details,$phone, $conne){      
		if (count($details)==1){
            $ussd_text="CON \nYour full name?\nFormat: FirstName LastName";
			ussd_proceed($ussd_text); 
		} 
		else if(count($details) == 2){
            $ussd_text="CON \nRespond with your E-mail Address\ne.g example@example.com";
			ussd_proceed($ussd_text);
		}
		else if(count($details) == 3){
            $ussd_text="CON \nMy gender is?\nMale or Female";
			ussd_proceed($ussd_text);
		}
		else if(count($details) == 4){	
            $ussd_text="CON \nWhich course are you pursuing?\ne.g BSc. Mechatronics Engineering";  
			ussd_proceed($ussd_text);  
		}
		else if(count($details) == 5){
            $ussd_text="CON \nRespond with Registration Number\ne.g C026-01-1210/2018";
			ussd_proceed($ussd_text);
		}
		else if(count($details) == 6){  
			$full_name=$details[1];
			$email=$details[2];  
			$gender=$details[3];
			$course = $details[4];
            $reg_number=$details[5];   
            

		
			// Write into database all the details
			$sql = "INSERT INTO member (full_name, email, gender, phone_number, course, reg_number) 
					VALUES ('$full_name', '$email', '$gender', '$phone', '$course', '$reg_number')";
			if($conne->query($sql) == TRUE){
				$message = "Thank you  for choosing Leja.\nYou are our new member.";
				$sms_message = "Dear , \nWe are excited to have you on the App!\nAccess our service through *384*567# for delightful services.\nHappy sales! Leja Team.";
				
				echo "END ".$message;
			}
			else{
				echo "error: ".$sql ."\n" .$conne->error;
			}
		}  
	}



?>