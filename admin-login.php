<?php
session_start();

if (isset($_POST["submit"])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = ""; 
    $db_name = "gym_project";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header("Location: Billing.php");
            exit();
        } else {
            $error = "Username or Password is incorrect!";
        }
    } else {
        $error = "Username or Password is incorrect!";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <style>
        img{
            width: 100%;
        }
        .login {
            height: 1000px;
            width: 100%;
            background: radial-gradient(#653d84, #332042);
            position: relative;
        }
        .login_box {
            width: 1050px;
            height: 600px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background: #fff;
            border-radius: 10px;
            box-shadow: 1px 4px 22px -8px #0004;
            display: flex;
            overflow: hidden;
        }
        .login_box .left{
          width: 41%;
          height: 100%;
          padding: 25px 25px;
          
        }
        .login_box .right{
          width: 59%;
          height: 100%  
        }
        .left .top_link a {
            color: #452A5A;
            font-weight: 400;
        }
        .left .top_link{
          height: 20px
        }
        .left .contact{
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: center;
            height: 100%;
            width: 73%;
            margin: auto;
        }
        .left h3{
          text-align: center;
          margin-bottom: 40px;
        }
        .left input {
            border: none;
            width: 80%;
            margin: 15px 0px;
            border-bottom: 1px solid #4f30677d;
            padding: 7px 9px;
            width: 100%;
            overflow: hidden;
            background: transparent;
            font-weight: 600;
            font-size: 14px;
        }
        .left{
            background: linear-gradient(-45deg, #dcd7e0, #fff);
        }
        .submit {
            border: none;
            padding: 15px 70px;
            border-radius: 8px;
            display: block;
            margin: auto;
            margin-top: 120px;
            background: #583672;
            color: #fff;
            font-weight: bold;
            -webkit-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            -moz-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
        }
        .right {
            background: linear-gradient(212.38deg, rgba(2,2,2, 0.7) 0%, rgba(175, 70, 189, 0.71) 100%),url('img/gallery5.png');
            color: #fff;
            position: relative;
        }
        .right .right-text{
          height: 100%;
          position: relative;
          transform: translate(0%, 45%);
        }
        .right-text h2{
          display: block;
          width: 100%;
          text-align: center;
          font-size: 50px;
          font-weight: 500;
        }
        .right-text h5{
          display: block;
          width: 100%;
          text-align: center;
          font-size: 19px;
          font-weight: 400;
        }
        .right .right-inductor{
          position: absolute;
          width: 70px;
          height: 7px;
          background: #fff0;
          left: 50%;
          bottom: 70px;
          transform: translate(-50%, 0%);
        }
        .top_link img {
            width: 28px;
            padding-right: 7px;
            margin-top: -3px;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #583672;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section class="login">
        <div class="login_box">
            <div class="left">
                <div class="top_link"><a href="index.html"><img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
                <div class="contact">
                    <form action="" method="post">
                        <h3>SIGN IN</h3>
                        <input type="text" name="user" placeholder="USERNAME" required>
                        <input type="password" name="pass" placeholder="PASSWORD" required>
                        <button type="submit" name="submit" class="submit">LET'S GO</button>
                        <?php if(isset($error)) { ?>
                            <div class="error"><?php echo $error; ?></div>
                        <?php } ?>
                        <div class="login-link">
                            Don't have  an account? <a href="signUp.php">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="right-text">
                    <h2>TUITIONS TONIGHT</h2>
                    <h5>GYM MANAGEMENT SYSTEM</h5>
                </div>
                <div class="right-inductor"><img src="https://sumanonline.com/Projects/Ghibli/assets/img/Gemini_Generated_Image_anod90anod90anod.jpg" alt=""></div>
            </div>
        </div>
    </section>
</body>
</html>