<?php
include_once '../models/Feedback.php';

if(isset($_POST['feedbackId'])){
    $feedbackId=$_POST['feedbackId'];
    if(filter_var($feedbackId, FILTER_VALIDATE_INT)) {
        $feedback = new Feedback();
        if($feedback->removeFeedback($feedbackId)){
            echo "Feedback deleted successfully";
        } else {
            echo "Feedback not deleted successfully";
        }
        
    }
    else{
        echo  "Error While deleting the feedback!";
    }
}

