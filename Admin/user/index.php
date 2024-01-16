<?php 
    session_start();
    if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'Manager')) {
        header('Location: index.php');
        exit();
      }
    include './../../Connection/conn.php';
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <?php include '../../src/layouts/Admin/script.php' ?>
    <script src="../../assets/js/color-modes.js"></script>
    <link href="./../../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../../public/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <?php include '../../src/layouts/Admin/icon.php' ?>
    <?php include '../../src/layouts/Admin/Header.php' ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../src/layouts/Admin/admin.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Main Right Menu</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                                <?php if ($_SESSION['role'] == 'Manager') { ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary"><a href="<?=getFullUrl('Admin/signup.php')?>">Add</a></button>
                                 <?php } ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                            <svg class="bi"><use xlink:href="#calendar3"/></svg>
                            This week
                        </button>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">role</th>
                                <th scope="col">username</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <?php include  '../../src/layouts/Admin/js.php' ?>
</body>
</html>
