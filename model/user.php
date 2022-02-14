<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
session_start();

class user
{
    private $conn;
    private $table_name = "user";

    public $userId;
    public $name;
    public $email;
    public $password;

    //mail details
    public $globelEmail = "rpsandeepa@gmail.com";
    public $globelPassword = "rp19970520";

    public function __construct($db)
    {
        $this->conn = $db;

        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

    }

    public function readUser()
    {

        $query = " select * from user ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

    }

    public function singleUser()
    {

        $query = " select * from user where email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
//        $stmt->bindParam(2, $this->password);
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        $post_arr = array();

        if ($rowCount > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);
                $post_item = array(
                    'userId' => $row['userId'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => $row['password']
                );

                if (md5($this->password )== $row['password']) {

                    $_SESSION['name'] = $row['name'];
                    array_push($post_arr, $post_item);
                    return $post_arr;

                } else {
                    $empty = array();
                    array_push($post_arr, $empty);
                    array_push($post_arr, $empty);
                    return $post_arr;
                }

            }

        } else {
            return $post_arr;
        }
    }

    public function createUser()
    {
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $encyptPassword = md5($this->password = htmlspecialchars(strip_tags($this->password)));

        if ($this->checkEmail($this->email) == 1) {
            return false;
        } else {

            $token = md5($this->email).rand(10,9999);

            $link = "<a href='http://localhost:63342/pos-web/pages/auth/verify-email.php?key=".$this->email."&token=".$token."'>Click and Verify Email</a>";
            $this->sendMailer($this->email, $link);
            //query to insert record
            $query = "insert into user set name=:name, email=:email, email_verification_link=:email_verification_link, password=:password";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":email_verification_link", $token);
            $stmt->bindParam(":password", $encyptPassword);
            $stmt->execute();

            // execute query
//            if ($stmt->execute()) {
//                $_SESSION['name'] = $this->name;
//                return 1;
//            }

            //send mail verification email


            return true;

        }

    }

    public function sendMailer($recipientsEmail, $link){

        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->globelEmail;
            $mail->Password   = $this->globelPassword;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom($this->globelEmail, 'Verification Email');
            $mail->addAddress($recipientsEmail, 'Pos-Web');
            $mail->addReplyTo($this->globelEmail, 'Information');


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Web-Pos Account Verification Email';
            $mail->Body    = 'Click On This Link to Verify Email '.$link.'';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    public function update()
    {

        // query to insert record
        $query = "update user set name=:name, email=:email, password=:password where userId=:userId";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":userId", $this->userId);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

    public function checkEmail($checkEmail)
    {

        $query = " select * from user where email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $checkEmail);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        return $rowCount;

    }
}