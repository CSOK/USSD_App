<?php
    class Social
    {
        public function __construct()
        {
            // 
        }

        public function social()
        {
            $ussd_text = "We are Social!\nTweet at: @csokimathi\nLike us on Facebook: ComputerSocietyOfKimathi";
            ussd_proceed($ussd_text);
        }
    }
?>