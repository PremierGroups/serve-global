<?php
require_once('../vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
//\Stripe\Stripe::setApiKey('sk_test_Fpzd9zJ2mTOEYHialubul3PG00B3fC5KdF');
if(isset($_POST['add'])){
    $stripe = new \Stripe\StripeClient(
  'sk_test_Fpzd9zJ2mTOEYHialubul3PG00B3fC5KdF'
);
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $name=$POST['name'];
    $price=$POST['price'];
$product=$stripe->products->create([
  'name' => $name,
  'type' => 'good',
  'description' => "Comfortable cotton t-shirt ".$name,
  'attributes' => ['size', 'gender'],
]);
$priceObj="";
   if ($product->active && isset($product->id)) {
       $priceObj=$stripe->prices->create([
  'unit_amount' => $price*100,
  'currency' => 'usd',
  'recurring' => ['interval' => 'month'],
  'product' => $product->id,
]);
   }
   echo "<pre>";
   var_dump($priceObj);
   exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="?" method="post">
            <input name="name" placeholder="Enter Product Name">
            <br>
            <input name="price" placeholder="Enter Product Price">
            <br>
            <button name="add">Save</button>
        </form>
    </body>
</html>
