<?php

session_start();
include 'conn.php';

//Print Message
if (isset($_SESSION['message'])){
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
$id = $_SESSION['id'];


//pagination

$results_per_page = 3;
$result = mysqli_query($con,"select * from product where id='$id' ORDER BY product_id DESC;") or trigger_error(mysqli_error($con));
$number_of_results=mysqli_num_rows($result);

$number_of_page = ceil($number_of_results / $results_per_page);

if(!isset($_GET['page']) or $_GET['page'] < 1 ){
    $page = 1;
}else{
    $page = $_GET['page'];
}

$page_first_result = ($page-1) * $results_per_page; 
$query = "select * from product where id='$id' ORDER BY product_id DESC LIMIT ".$page_first_result.",".$results_per_page;
$result = mysqli_query($con,$query);

//Delete Product
if(isset($_POST['delete'])){
  $product_id = $_POST['id'];
  mysqli_query($con,"delete from product where product_id = '$product_id';");
  $_SESSION['message'] = "Product deleted";
  header('location:gallery.php');
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Gallery</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"
        integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous">
    </script>

</head>

<body class="hold-transition sidebar-mini">
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
                <!-- Navbar Search -->
                <li class="nav-item d-none d-sm-inline-block">
                    <form method="POST" name="logout-form">
                        <button class="btn btn-warning m-1" name="logout" type="submit">Log Out</button>
                    </form>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <form method="POST" name="delete-for">
                        <button class="btn btn-danger m-1" name="delete" type="submit">Delete</button>
                    </form>
                </li>
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
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
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
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
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
                            <a href="product-add.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Add Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Product Gallery
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="compose.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    MailBox
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
                            <h1>Product Gallery</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Gallery</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Manage your products</h4>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="filter-container p-0 row">
                                            <div class="card-columns">
                                                <?php 
                                                while($row = mysqli_fetch_array($result)){
                                                ?>
                                                <div class="card shadow-lg mx-1 " style="width: 18rem;">
                                                    <div class="card-body">
                                                        <div id="carouselExampleControls<?php echo $row['product_id']; ?>"
                                                            class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php $var = 0;
                                                                $product_id = $row['product_id']; 
                                                            $q = "select * from images where product_id='$product_id'";
                                                            $images = mysqli_query($con,$q) or trigger_error(mysqli_error($con));
                                                                while($image = mysqli_fetch_array($images)){
                                                            ?>
                                                                <div
                                                                    class="carousel-item <?php echo $var==0 ? 'active':''; ?>">
                                                                    <img src="<?php echo $image['url']; ?>"
                                                                        class="d-block w-100 card-img-top" alt="...">
                                                                </div>
                                                                <?php $var++; } ?>
                                                            </div>
                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#carouselExampleControls<?php echo $row['product_id']; ?>"
                                                                data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#carouselExampleControls<?php echo $row['product_id']; ?>"
                                                                data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </button>
                                                        </div>
                                                        <h4 class="card-title"><?php echo $row['product_name'] ?>
                                                        </h4>
                                                        <p class="card-text small"><?php echo $row['product_desc'] ?>
                                                        </p>
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">MRP : &#8377;
                                                            <?php echo $row['product_cost'] ?></li>
                                                    </ul>

                                                    <form method="POST">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $row['product_id']; ?>">
                                                        <div class=" card-body">
                                                            <a class="card-link btn btn-warning"
                                                                href="product-add.php?product_id=<?php echo $row['product_id']; ?>">Update</a>
                                                            <button type="submit" class="card-link btn btn-danger"
                                                                name="delete">Delete</button>
                                                            </br>
                                                            <a class="pt-4 small"
                                                                href="invoice.php?product_id=<?php echo $row['product_id'] ?>">Generate
                                                                invoice</a>
                                                    </form>
                                                </div>
                                            </div>

                                            <?php } ?>
                                        </div>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item">
                                                    <a class="page-link" href='gallery.php?page=<?php echo --$page; ?>'
                                                        aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                </li>

                                                <?php
                                                for($page = 1; $page<= $number_of_page; $page++) {
                                                echo '<li class="page-item"><a class="mx-1 page-link" href = "gallery.php?page=' . $page . '">' . $page . ' </a></l1>' ; 
                                                }
                                                ?>
                                                <li class="page-item">
                                                    <a class="page-link" href='gallery.php?page=<?php echo $page++; ?>'
                                                        aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
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

    <!-- jQuery -->



    <!-- Ekko Lightbox -->
    <script src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Filterizr-->
    <script src="plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->

</body>

</html>