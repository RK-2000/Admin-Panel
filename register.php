<?php
  include 'conn.php';
  session_start();


//Message
if ($_SESSION['message']){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
//If authenticated send to index
if ($_SESSION['authenticated']){
    header('Location:index.php');
}

//Handel add user
  if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    echo $name,$email;
    if ($password == $cpassword){
        $q = "select * from user where email='$email';";
        $query = mysqli_query($con,$q) or trigger_error("Query Failed".mysqli_error($con),E_USER_ERROR);
        $result=mysqli_fetch_assoc($query);
        if (!$result['email']){
            echo $q;
            $q = "insert into user(name,email,password) values('$name','$email','$password')";
            $query = mysqli_query($con,$q) or trigger_error("Query Failed".mysqli_error($con),E_USER_ERROR);
            
            if($query){
                
                $_SESSION['authenticated'] = "True";
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                
                header("Location:index.php");
            }
        else{
        $_SESSION['message']="<div class='alert alert-danger'>Something went wrong. Try again</div>";
        header('location:create.php');        
    }header('location:register.php');
        }
    else{
        $_SESSION['message']="<div class='alert alert-danger'>We have an account linked to this email. Try to log in</div>";
        header('location:register.php');    
    }
    }
    else{
        $_SESSION['message']= "<div class='alert alert-danger'>Password and Confirm password doesn't match!</div>";
        header('location:register.php');
    }
       

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdminLTE 3 | Registration Page (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form method="post" name="submit">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Full name" name="name" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required
                            oninvalid="setCustomValidity('Please enter correct email id.')" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$"
                            oninvalid="setCustomValidity('Password should contain minimun 7 characters, one uppercase letter, one lowercase letter and one special character.')" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" name="cpassword"
                            required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$"
                            oninvalid="setCustomValidity('Password should contain minimun 7 characters, one uppercase letter, one lowercase letter and one special character.')" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" />
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">
                                Register
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="login.php" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->

</body>

</html>