<?php

session_start();

class user
{
    private $conn;
    private $table_name = "user";

    public $userId;
    public $name;
    public $email;
    public $password;
//    public $created;
//    public $conform_password;

    public function __construct($db)
    {
        $this->conn = $db;
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

//
//            $mail = new PHPMailer();
//
//            $mail->CharSet =  "utf-8";
//            $mail->IsSMTP();
//            // enable SMTP authentication
//            $mail->SMTPAuth = true;
//            // GMAIL username
//            $mail->Username = "rusira.pathum20@gmail.com";
//            // GMAIL password
//            $mail->Password = "your_gmail_password";
//            $mail->SMTPSecure = "ssl";
//            // sets GMAIL as the SMTP server
//            $mail->Host = "smtp.gmail.com";
//            // set the SMTP port for the GMAIL server
//            $mail->Port = "465";
//            $mail->From='rusira.pathum20@gmail.com';
//            $mail->FromName='your_name';
//            $mail->AddAddress('reciever_email_id', 'reciever_name');
//            $mail->Subject  =  'Reset Password';
//            $mail->IsHTML(true);
//            $mail->Body    = 'Click On This Link to Verify Email';
//            if($mail->Send())
//            {
//                echo "Check Your Email box and Click on the email verification link.";
//            }
//            else
//            {
//                echo "Mail Error - >".$mail->ErrorInfo;
//            }

            // query to insert record
            $query = "insert into user set name=:name, email=:email, email_verification_link=:email_verification_link, password=:password";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":email_verification_link", $token);
            $stmt->bindParam(":password", $encyptPassword);

            // execute query
            if ($stmt->execute()) {
                $_SESSION['name'] = $this->name;
                return true;
            }
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