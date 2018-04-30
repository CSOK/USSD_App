<?php
    class Register
    {
        public function __construct()
        {
            // 
        }

        public function register($details,$phone, $conne){      
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
                    $message = "Thank you.";
                    $sms_message = "Dear , \nWe are excited to have you on the App!\nAccess our service through *384*567# for delightful services.\nHappy sales! Leja Team.";
                    
                    echo "END ".$message;
                }
                else{
                    // echo "error: ".$sql ."\n" .$conne->error;
                }
            }  
        }
    }


?>