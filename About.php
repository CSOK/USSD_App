<?php

    class About
    {
        public function __construct()
        {
            // 
        }

        public function about()
        {
            $ussd_text = "END An academic tech club where \"We Advance Modern Technology\"";
            ussd_proceed($ussd_text);
        }
    }
?>