<?php
require_once ('./include/Db.php');
include_once './include/User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require'vendor/autoload.php';
$msg = '';
if (isset($_GET['msg']))
    $msg = $_GET['msg'];
$type = 'info';
if (isset($_GET['type']))
    $type = $_GET['type'];
if (isset($_POST['forgotPassBtn']) && isset($_POST['email'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "https://africanviewbycalyo.com/recover-password?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date('U') + 1800;
    $userEmail = $_POST['email'];
    $email = filter_var($userEmail, FILTER_SANITIZE_EMAIL);
    $userObj = new User();
    $db = new Db();
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($userObj->checkIfEmailExists($email) > 0) {
            $email = mysqli_real_escape_string($db->conn, $email);
            $query = "DELETE FROM password_reset WHERE email='$email'";
            mysqli_query($db->conn, $query);
        } else {
            header("location: forgot-password?msg=User with this Email Does not Exist&type=danger");
            exit(1);
        }
    } else {
        header("location: forgot-password?msg=Please Enter Correct Email");
        exit(1);
    }
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $sql = "INSERT INTO password_reset(`email`, `resetSelector`, `resetToken`, `resetExpires`) "
            . "VALUES ('$email','$selector','$hashedToken','$expires')";
    if (mysqli_query($db->conn, $sql)) {
        
    } else {
        header("location: forgot-password?msg=Password Reset Link Does not Sent to your Email. Please Try again!. &type=danger");
        exit(1);
    }
    mysqli_close($db->conn);

    //Send Reset Link to User Email Address
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
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
        // Name is optional
        $mail->addReplyTo('aemiromekete12@gmail.com', 'Serve Global');
        //Server settings
        $mail->addAddress($email, 'Reset Password');     // Add a recipient
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Reset Your Password";

        $mail->Body = "<p>We have Recieved a password reset request. The link to reset your password is <a href=" . $url . ">$url</a></p>";
        $mail->AltBody = "We have Recieved a password reset request. The link to reset your password is " . $url;

        if ($mail->send()) {
            $msg = "Password Reset Link Sent to Your Email. Please Check Your Email";
            $type = "success";
        }
    } catch (Exception $e) {
        $msg = "Password reset link could not be sent. Please try again!";
        $type = "danger";
    }
    header("location: forgot-password?msg=$msg&type=$type");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Forgot Password</title>
        <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index"><b>Serve <span class="fa fa-globe text-fuchsia"></span> Global</b></a>
            </div>
            <!-- /.login-logo -->

            <div class="login-box-body">
                <?php
                if ($msg != '') {
                    ?>
                    <div class="alert alert-<?php echo trim($type); ?>" role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span></button> <?php echo $msg; ?>
                    </div>
                    <?php
                }
                ?>
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="forgotPassBtn">Request new password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="login">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->

        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>
