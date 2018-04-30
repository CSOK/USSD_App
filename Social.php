<?php
    class Social
    {
        public function __construct()
        {
            // 
        }

        public function social()
        {
            $ussd_text = "Tweet at: @csokimathi\nLike us on Facebook: ComputerSocietyOfKimathi";
            ussd_proceed($ussd_text);
        }
    }
?>