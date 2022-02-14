<?php
session_start();
include_once "./config/database.php";
require_once 'google_api/vendor/autoload.php';

$db = new database();
$db->getConnection();

$clientID = '511918634590-43c86ldbmnqa5jkc8ub28me19pvbdvrn.apps.googleusercontent.com';
$ClientSecret = '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';
$redirectUrl = 'http://localhost:63342/pos-web/index.php';

//Creating client request to google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($ClientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope('profile');
$client->addScope('email');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    //Getting User Profile
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;
    $id = $google_info->id;
    $_SESSION['name'] = $name;
    $_SESSION['id'] = $id;

    if(isset($_SESSION['id'])){
        header("location: pages/dashboard/home.php");
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-Pos | Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="vendor/login/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="vendor/login/css/style.css">

</head>

<body>

<div class="main">

    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="vendor/img/logo.png" alt="sing up image"></figure>
                    <a href="pages/auth/register.php" class="signup-image-link">Create an account</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Sign In</h2>
                    <form class="register-form" id="quickForm">
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="email" name="email" id="email" placeholder="Your Email"/>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term"/>
                            <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                me</label>
                        </div>
                        <div id="alertSuccess" class="alert alert-success" style="display: none">
                        </div>
                        <div id="alertError" class="alert alert-danger" style="display: none">
                        </div>
                        <div id="alertWarning" class="alert alert-warning" style="display: none">
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="login" id="login" class="form-submit" value="Log in"/>
                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li>
                                <?php
                                    echo '<a href="'.$client->createAuthUrl().'"><i class="display-flex-center zmdi zmdi-google"></i></a>';
                                ?>
                            </li>
                            <!--                            <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>-->
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- JS -->
<script src="vendor/login/vendor/jquery/jquery.min.js"></script>
<script src="vendor/login/js/main.js"></script>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="public/js/login.js"></script>

</body>

</html>