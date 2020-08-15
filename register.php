<?php
require_once './f-config.php';
require_once 'g-config.php';
$gSignupUrl = $gClient->createAuthUrl();
$gloginUrl = $gClient->createAuthUrl();
$fbRedirectUrl="http://localhost/community/f-callback";

$permissions = ['email','user_link', 'user_gender','user_birthday']; // optional
$fbRegisterUrl=$helper->getLoginUrl($fbRedirectUrl, $permissions);

include_once './include/User.php';
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
if (isset($_POST['register']) && !empty($_POST['fname']) && !empty($_POST['lname'])) {
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $fname = $POST['fname'];
    $lname = $POST['lname'];
    $email = $POST['email'];
    $username = $POST['username'];
    $password = $POST['password'];
    $rePass = $POST['repassword'];
    $sex = $POST['userSex'];
    $phone = $POST['phone'];
    
    if ($password === $rePass) {
        if(strlen($password)>=8){
           if(strlen($fname)>=2 || strlen($lname)>=2){
               if(empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)){
                   if(!empty(trim($username))){
                       if(strlen($phone)>9 && strlen($phone)<15){
                            $userObj=new User();
                            if(!empty($email) && $userObj->checkIfEmailExists($email)==0){
                                if (!empty($username) && $userObj->checkIfUsernameExists($username) == 0) {
                                    if($userObj->register($fname, $lname, $username, $password, $sex, $phone, $email)){
                                        if($userObj->checkIfUsernameExists($username) > 0){
                                            $msg = "You have Registered successfully. Please complete your profile";
                                            $type = 'success';
                                            $_SESSION['username'] = $username;
                                            $_SESSION['role'] = 'volunteer';
                                            header("location:profile?msg=$msg&type=$type");
                                            exit(0);
                                        } else {
                                            $msg = "User Registration is failed! Please try again";
                                            $type = 'danger';
                                            header("location:register?msg=$msg&type=$type");
                                            exit(0);
                                        }
                                    }else{
                                        $msg = "User Registration is failed! Please try again";
                                        $type = 'danger';
                                        header("location:register?msg=$msg&type=$type");
                                        exit(0);
                                    }
                                } else {
                                    $msg = "This username is already used by other user. Please use another unique username!";
                                    $type = 'danger';
                                    header("location:register?msg=$msg&type=$type");
                                    exit(0);
                                }
                            }else{
                               $msg = "This email is already taken by other user. Please use another email address!";
                                $type = 'danger';
                                header("location:register?msg=$msg&type=$type");
                                exit(0); 
                            }
                       }else{
                           $msg = "Please enter correct phone number!";
                            $type = 'danger';
                            header("location:register?msg=$msg&type=$type");
                            exit(0); 
                       }
                     
                       
                   }else{
                        $msg = "Please enter your username!";
                        $type = 'danger';
                        header("location:register?msg=$msg&type=$type");
                        exit(0);
                    }
               }else{
                   $msg = "Please enter correct email address!";
                   $type = 'danger';
                   header("location:register?msg=$msg&type=$type");
                   exit(0);    
               }
           } else{
                $msg = "Please enter your name!";
                $type = 'danger';
                header("location:register?msg=$msg&type=$type");
                exit(0);  
           }
        } else {
            $msg = "Your Password is too short. Please enter at least 8 characters!";
            $type = 'danger';
            header("location:register?msg=$msg&type=$type");
            exit(0);  
        }
    } else {
        $msg = "Please Confirm Your Password";
        $type = 'danger';
        header("location:register?msg=$msg&type=$type");
        exit(0);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Registration</title>
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
        <link rel="stylesheet" href="dist/css/bootstrapValidator.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
             <div class="login-logo">
                <a href="index"><b>Serve <span class="fa fa-globe text-fuchsia"></span> Global</b></a>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">Registration Form</p>
                <?php
                if ($msg != '') {
                    ?>
                    <div class="alert alert-<?php echo $type; ?>" role='alert'> 
                        <button type='button' class='close' data-dismiss='alert'>
                            <span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span>
                        </button><?php echo $msg; ?>
                    </div>
                    <?php
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registrationForm">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="First name" name="fname" id="fnameInput">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Father name" name="lname" id="lnameInput">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="emailInput">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="tel" class="form-control" placeholder="Phone Number" name="phone" id="phoneInput">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Usename" name="username" id="usernameInput">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="repassword" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="form-group">

                        <select class="form-control" name="userSex">
                            <option value="">Select Sex</option>
                            <option value="M"> Male</option>
                            <option value="F"> Female</option>
                        </select>

                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="register">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="<?php echo $fbRegisterUrl;?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                        Facebook</a>
                    <a href="<?php echo $gSignupUrl;?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google"></i> Sign up using
                        Google</a>
                </div>

                <a href="login" class="text-center">I already have an account</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->

        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- bootstrap validator  -->
        <script src="dist/js/bootstrapValidator.min.js"></script>

        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
                $('#registrationForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        fname: {
                            message: 'Your First name  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'First name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 25,
                                    message: 'First name must be more than 2 and less than 25 characters long'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\. ]+$/,
                                    message: 'First name can only consist of alphabetical'
                                }
                            }
                        },
                        lname: {
                            message: 'Your Father name  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Father name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 25,
                                    message: 'Father name must be more than 2 and less than 25 characters long'
                                },
                                different: {
                                    field: 'fname',
                                    message: 'Father name can\'t be the same as your name'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\. ]+$/,
                                    message: 'Father name can only consist of alphabetical'
                                }
                            }
                        },
                        phone: {
                            validators: {
                                notEmpty: {
                                    message: 'Phone number is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 9,
                                    max: 10,
                                    message: 'Phone number must beless than 15 characters long'
                                },
                                digits: {
                                    message: 'Phone number value can contain only digits'
                                }
                            }
                        },
                        email: {
                            validators: {

                                emailAddress: {
                                    message: 'Please insert correct email format'
                                }
                            }
                        },
                        username: {
                            message: 'Username is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Username is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 64,
                                    message: 'Username must be more than 6 and less than 64 characters long'
                                },
                                different: {
                                    field: 'password',
                                    message: 'Username can\'t be the same as password'
                                }
                            }
                        },
                        password: {
                            message: 'Password is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Password is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 8,
                                    max: 132,
                                    message: 'Password must be more than 8 and less than 132 characters long'
                                },
                                different: {
                                    field: 'username',
                                    message: 'Password can\'t be the same as username'
                                }
                            }
                        },
                        repassword: {
                            message: 'Please confirm your password',
                            validators: {
                                notEmpty: {
                                    message: 'This field is required and can\'t be empty'
                                },
                                identical: {
                                    field: 'password',
                                    message: 'Please confirm your password'
                                }
                            }
                        },
                        userSex: {
                            validators: {
                                notEmpty: {
                                    message: 'Sex is required and can\'t be empty'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </body>
</html>
