<?php
include_once 'include/Feedback.php';
if (isset($_POST['fname']) && isset($_POST['message'])) {
    $secretKey = "6LdAnfcUAAAAAAnleaEnM7NKs2RiLdHCONCC03rY";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIp = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIp";
    try {
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($response->success) {
            $email = strip_tags($_POST['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $name = strip_tags($_POST['fname']);
                $email = strip_tags($_POST['email']);
                $comment = strip_tags($_POST['message']);
                $subject = strip_tags($_POST['subject']);
                $name = stripcslashes($name);
                $email = stripcslashes($email);
                $comment = stripcslashes($comment);
                $subject = stripcslashes($subject);

                $feedback = new Feedback();
                if ($feedback->addFeedback($name, $email, $comment, $subject)) {
                    echo "Thank You for your comment";
                } else {
                    echo "Comment have not submitted to the System! Please Try agian.";
                }
            }else{
                echo "Please Use valide email address!";
            }
        } else {
           echo "You are not verified! Please try again.";
        }
    } catch (Exception $e) {
       echo "Please try again.";
    }
} else {
    echo "Please enter proper comment!";
}
