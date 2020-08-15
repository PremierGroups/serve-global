<?php

require_once('../vendor/autoload.php');
include_once 'Donate.php';
include_once 'Customer.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_Fpzd9zJ2mTOEYHialubul3PG00B3fC5KdF');

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
if (isset($_POST['stripeToken']) && isset($_POST['donateEmail'])) {
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $anonymous = 0;
    if (isset($POST['anonymous'])) {
        $anonymous = 1;
    }
    $name = strip_tags(trim($POST['name']));
    $comment = strip_tags(trim($POST['comment']));
    $comment = stripcslashes($comment);
    $amount = strip_tags(trim($POST['amount']));
    $email = strip_tags(trim($POST['donateEmail']));
    $country= strip_tags(trim($POST['country']));
    $token = $POST['stripeToken'];
    $currency = 'usd';
    //echo "<pre>";
    $customer_id = "";
    $customers = \Stripe\Customer::all();
    foreach ($customers as $customer) {
        if ($customer['email'] == $email) {
            $customer_id = $customer['id'];
            //echo "Customer Exist";
            break;
        }
    }
    //var_dump($customers);
    //exit(1);
    if ((filter_var($email, FILTER_VALIDATE_EMAIL))) {
        if (empty($customer_id)) {
            $customer = \Stripe\Customer::create([
                        "email" => $email,
                        "source" => $token,
                        "name" => $name
            ]);
            if (isset($customer->id)) {
                $customer_id = $customer->id;
                $customerObj = new Customer();
                $customerObj->addCustomer($customer_id, $name, $email, $country);
            }
        } else {
            
        }

        if (isset($customer->id) && !empty($customer_id)) {
            $charge = \Stripe\Charge::create([
                        'amount' => ($amount * 100),
                        'currency' => strtolower($currency),
                        'description' => $comment,
                        //'source' => $token,
                        'customer' => $customer_id
            ]);
            //working on $charge response
            if (strcmp($charge->status, 'succeeded') == 0) {
                 $donationObj = new Donate();
                //$customer_id, $amount, $status="pending", $description
                $donationObj->addDonation($customer_id, $amount, $charge->status, $comment, $anonymous);
                //Send Ivoice to  Email address
                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = false;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                    $mail->Username = 'aemiromekete12@gmail.com';                     // SMTP username
                    $mail->Password = '0918577461q';                               // SMTP password
                    $mail->SMTPSecure = 'tls'; //PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to
                    //Recipients
                    $mail->setFrom('aemiromekete12@gmail.com', 'Serve Global');
                    $mail->addAddress($email, 'Test Email');     // Add a recipient
                    // Name is optional
                    $mail->addReplyTo('aemiromekete12@gmail.com', 'Serve Global');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Thank You For Your Donation';
                    $mail->Body = "Thank You For Your Donation!. Your <i>tansaction Id is <strong>$charge->id </strong></i> <b><a href='serveglobal.org/'>Back to Serve Global</a></b>";
                    $mail->AltBody = "Thank You For Your Donation!. Your tansaction is  <i><b>$charge->id</b></i>";

                    if ($mail->send()) {
                        // $msg='Message has been sent';
                    }
                } catch (Exception $e) {
                   $msg= $x->getMessage();
                   $status='error';
                }   // email End
            }
            $msg = $charge->description;
            $transaction = $charge->id;
            $status = $charge->status;
            header("location: ../success?msg=$msg&status=$status&transaction=$transaction");
            exit(1);
        }
    }
}
header("location: ../success.php?msg=Your Donation is failed please try again &status=failed");
exit(1);
