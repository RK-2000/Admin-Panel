<?php
session_start();
include 'conn.php';

//Print Message
if ($_SESSION['message']){
  echo $_SESSION['message'];
  unset($_SESSION['message']);
}

//Authentication
if (!$_SESSION['authenticated']){
  header('Location:login.php');
}

// To logout user
    if (isset($_POST['logout'])){
    unset($_SESSION['authenticated']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    header('Location:login.php');
    }

// Get Basic details   
$email = $_SESSION['email'];
$password = $_SESSION['password'];


if (isset($_POST['delete'])){
  $q="delete from user where email='$email' and password='$password';";
  echo $q;
  $query = mysqli_query($con,$q) or trigger_error("Cannot be deleted ".mysqli_error($con),E_USER_NOTICE);
  if ($query){ 
      unset($_SESSION['authenticated']);
      unset($_SESSION['email']);
      unset($_SESSION['password']);
      header('Location:register.php');
  }
}

// Handle products
if(isset($_POST['submit'])){
  $product_name = $_POST['product-name'];
  $product_desc = $_POST['product-desc'];
  $product_cost = $_POST['product-cost'];
  $id = $_SESSION['id'];
  if (!empty($_FILES['img']))
        {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES["img"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // if file is png, jpeg or jpg
            if ($imageFileType == 'png' or $imageFileType == 'jpeg' or $imageFileType == 'jpg'){
                if(move_uploaded_file($_FILES['img']['tmp_name'],$target_file)){
                    $q = "insert into product (id,product_name,product_desc,product_cost,image) values ($id,'$product_name','$product_desc',$product_cost,'$target_file');";
                    $query = mysqli_query($con,$q) or trigger_error($q,E_USER_ERROR);
                    if($query){
                        $_SESSION['message'] = "<div class='alert alert-success'>Product Added</div>";
                        header('location:gallery.php');
                    }
                    else{
                        $_SESSION['message'] = "<div class='alert alert-danger'>Image can not be saved in database.</div>";
                    }
                }
                else{
                    $_SESSION['message'] = "<div class='alert alert-danger'>Cannot be uploaded</div>";
                }
            }
            else{
                $_SESSION['message'] = "<div class='alert alert-'>Please choose an image with proper extensions!</div>";    
            }
            
            header("location:product-add.php");
        }
        else{
            $_SESSION['message'] = "<div class='alert alert-danger'>Please upload an image upload!</div>";
            header("location:product-add.php");    

        }    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Product Add</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['name'];?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Widgets
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Add Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="gallery.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Product Gallery
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Project Add</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Product Add</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Project Name</label>
                                        <input type="text" id="inputName" class="form-control" name="product-name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescription">Project Description</label>
                                        <textarea id="inputDescription" class="form-control" rows="4"
                                            name="product-desc" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputProjectLeader">Cost</label>
                                        <input type="number" id="inputCost" class="form-control" name="product-cost"
                                            pattern="(^\d*\.?\d*[1-9]+\d*$)|(^[1-9]+\d*\.\d*$)" min=0
                                            oninvalid="setCustomValidation('Cost cannot be negetive')" required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Images</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group" id="x">
                                        <input type="file" name="img" id="uploadFile" class="form-control"
                                            onchange="preview_image();" multiple required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="btn btn-secondary">Cancel</a>
                            <input type="submit" name="submit" value="Add new Product"
                                class="btn btn-success float-right">
                        </div>
                    </div>
                    </for m>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <script>
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadFile").files[0]);
        var div = document.getElementById("x");
        div.innerHTML += "<img id='uploadPreview' style='width:auto;height: 100px;'/>";
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

    function preview_image() {
        var total_file = document.getElementById("uploadFile").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#x').append("<img  style='width:auto;height: 100px;' src='" + URL.createObjectURL(event.target.files[
                i]) + "'>");
        }
    };
    </script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>