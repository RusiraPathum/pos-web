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
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="../../vendor/login/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../../vendor/login/css/style.css">

</head>

<body>

<div class="main">

    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image" style="margin-top: -50px">
                    <figure><img src="../../vendor/img/logo.png" alt="sing up image"></figure>
                </div>

                <div class="signin-form" style="margin-top: 50px">
                    <?php
                    if ($_GET['key'] && $_GET['token']) {
                        include_once "../../config/database.php";

                        $db = new database();
                        $conn = $db->getConnection();

                        $email = $_GET['key'];
                        $token = $_GET['token'];
                        $rs = $query = $db->Search("SELECT * FROM user 
                                            WHERE email_verification_link='" . $token . "' 
                                            and email='" . $email . "';");

                        $d = date('Y-m-d H:i:s');

                        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                            $action = $row['email_verified_at'];

                            if ($action == null) {
                                $db->IUD("UPDATE user set email_verified_at ='" . $d . "' WHERE email='" . $email . "'");
                                $msg = "Congratulations! Your email has been verified.{$action}";
                            } else {
                                $msg = "You have already verified your account with us";
                            }
                        }
                    } else {
                        $msg = "Danger! Your something goes to wrong.";
                    }
                    ?>
                    <div class="mt-3">
                        <div class="card">
                            <div class="card-header text-center">
                                User Account Activation by Email Verification using PHP
                            </div>
                            <div class="card-body">
                                <p><?php echo $msg; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- JS -->
<script src="../../vendor/login/vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/login/js/main.js"></script>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../public/js/login.js"></script>

</body>

</html>