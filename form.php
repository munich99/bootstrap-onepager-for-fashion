<?php

ini_set("allow_url_fopen", 1);

echo 'irgendwas';


$secret_key = '6Lec09gUAAAAACJlfqVwE4gACCenLh6wSqNA-hBu'; // Your Google reCaptcha secret key
 
if(!empty($_POST['g-recaptcha-response']))
                {
                // Request the Google server to validate our captcha
                $request = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
                // The result is in a JSON format. Decoding..
                $response = json_decode($request);
                
                if($response->success)
                {
                // Here goes your code.
                echo 'Congratulations! You have passed the reCaptcha!';
                }
                else
                {
                echo 'Please, try again. You must complete the Captcha!';
                }
}


?>