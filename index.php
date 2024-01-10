<?php 
    include './constants.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='./public/main.js'></script>
    <?php include_once 'src/layouts/Home/Script.php'; ?>
    <style>
        img {
            width: 100%;
        }
        .container-fluid {
            padding-bottom: 5px;
        }
        .container {
            background: white;
            
        }
        body {
            background: #7BA46A;
            width: 970px;
            margin: 0 auto;
            margin-top: 25px;
        }
        .left {
            border-right: 0.5px solid #7BA46A;
        }
        .header {
            /* padding-top: 3px !important; */
        }
    </style>
</head>
<body>
    <header class="container header" id="header">
    <?php include_once 'src/layouts/Home/Header.php'; ?>
    </div>
    </header>
    <main>
        <div class="container home">
            <div class="row">
                <div class="col-3 left">
                    <a href="<?=getFullUrl('Admin/')?>">Admin</a>
                    <?php include './src/layouts/Home/SidebarLeft.php' ?>
                </div>
                <div class="col-6">
                    <?php include_once './src/layouts/Home/Content.php' ?>
                </div>
                <div class="col-3 right">
                    <?php include './src/layouts/Home/SidebarRight.php' ?>
                </div>
            </div>
        </div>
    </main>
    <?php include './src/layouts/Home/Footer.php' ?>
</body>
</html>
<!DOCTYPE html>