<?php


/*

 *  CONFIGURE EVERYTHING HERE

 */



// an email address that will be in the From field of the email.

$from = 'Eine Nachricht von deiner www.edithion.de Website';



// an email address that will receive the email with the output of the form

$sendTo = 'Deine Website ';



// subject of the email

$subject = 'Neue Nachricht und das Spamfrei www.edithion.de';



// form field names and their translations.

// array variable name => Text to appear in the email

$fields = array('name' => 'Name', 'surname' => 'Surname', 'need' => 'Need', 'email' => 'Email', 'message' => 'Message'); 



// message that will be displayed when everything is OK :)

// $okMessage = 'Vielen Dank für Ihre Nachricht,:) wir werden uns in kürze bei Ihnen Melden!';



// If something goes wrong, we will display this message.

$errorMessage = 'There was an error while submitting the form. Please try again later';



$secret_key = ''; // Your Google reCaptcha secret key



/*

 *  LET'S DO THE SENDING

 */





if(!empty($_POST['g-recaptcha-response']))

{

                // Request the Google server to validate our captcha

                $request = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

                // The result is in a JSON format. Decoding..

                $response = json_decode($request);



                if($response->success)

                {

                // Here goes your code.

                    $okMessage = 'Vielen Dank für Ihre Nachricht,:) wir werden uns in kürze bei Ihnen Melden!';

                    // echo 'Congratulations! You have passed the reCaptcha!';





                                                    try

                                                    {



                                                        if(count($_POST) == 0) throw new \Exception('Form is empty');

                                                                

                                                        $emailText = "You have a new message from your contact form\n=============================\n";



                                                        foreach ($_POST as $key => $value) {

                                                            // If the field exists in the $fields array, include it in the email 

                                                            if (isset($fields[$key])) {

                                                                $emailText .= "$fields[$key]: $value\n";

                                                            }

                                                        }



                                                        // All the neccessary headers for the email.

                                                        $headers = array('Content-Type: text/plain; charset="UTF-8";',

                                                            'From: ' . $from,

                                                            'Reply-To: ' . $from,

                                                            'Return-Path: ' . $from,

                                                        );

                                                        

                                                        // Send email

                                                        mail($sendTo, $subject, $emailText, implode("\n", $headers));



                                                        $responseArray = array('type' => 'success', 'message' => $okMessage);

                                                    }

                                                    catch (\Exception $e)

                                                    {

                                                        $responseArray = array('type' => 'danger', 'message' => $errorMessage);

                                                    }




                                                    // ------------------------------------------












                                                    // if requested by AJAX request return JSON response

                                                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                                                        $encoded = json_encode($responseArray);



                                                        header('Content-Type: application/json');



                                                        echo $encoded;

                                                    }

                                                    // else just display the message

                                                    else {

                                                        echo $responseArray['message'];


                                                    }




                }



                //// hier fängt das else an

                else

                {

                    $okMessage = 'Nachricht,:)ging schief';

                // echo 'Please, try again. You must complete the Captcha!';

                }


}