<?php
include_once '../models/Testimonial.php';
if(isset($_POST['testimonialId'])){
    $testimonialId=$_POST['testimonialId'];
    if(filter_var($testimonialId, FILTER_VALIDATE_INT)) {
        $testimonial = new Testimonial();
        if ($testimonial->removeTestimonial($testimonialId)) {
            echo "Testimonial deleted successfully";
        } else {
            echo "Testimonial Not deleted successfully";
        }
    }
    else{
        echo "Error While Deleting the Testimonial";
    }
}

