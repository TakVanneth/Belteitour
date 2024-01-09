<?php 
    include './constants.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'src/layouts/Home/Script.php'; ?>
    <style>
        img {
            width: 100%;
        }
        .container-fluid {
            padding-bottom: 15px;
        }
        .container {
            background: white;
        }
        body {
            background: #7BA46A;
        }
    </style>
</head>
<body>
    <header class="container header" id="header">
    <?php include_once 'src/layouts/Home/Header.php'; ?>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="<?=getFullUrl('Admin/')?>">Admin</a>
                    <?php include './src/layouts/Home/SidebarLeft.php' ?>
                    <?php include './src/layouts/Home/SidebarRight.php' ?>
                </div>
                <div class="col-6">
                    <?php include_once './src/layouts/Home/Content.php' ?>
                </div>
                <div class="col-3">
                    <?php include './src/layouts/Home/SidebarRight.php' ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
