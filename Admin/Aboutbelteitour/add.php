<?php 
    session_start();
    // if (!isset($_SESSION['userID'])) {
    //   header('Location: ../login.php');
    //   exit();
    // }
    if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager'))) {
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
  <form action="action.php" method="post" enctype="multipart/form-data">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Sub Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="submit" class="btn btn-sm btn-outline-secondary" name="insert">insert</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi"><use xlink:href="#calendar3"/></svg>
            This week
          </button>
        </div>
      </div>
      <div class="table-responsive small">
        <table class="table table-striped table-sm">
        <div class="mb-3 px-1">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <!-- <div class="mb-3 px-1">
            <label for="sort_order" class="form-label">sort_order</label>
            <input type="text" class="form-control" id="sort_order" name="sort_order">
        </div> -->
        content :
        <textarea cols="30" rows="5" id="Description" name="content">

        </textarea>
        <div class="mb-3 px-1">
            <label for="DatePost" class="form-label">testing date</label>
            <input type="date" class="form-control" id="DatePost" name="DatePost">
        </div>
        <!-- <div class="mb-3 px-1">
            <label for="Category" class="form-label">Select Category</label>

            <select class="form-select" id="Category" name="Category">
                <option value="">Select Category</option>

                php
                include './../../Connection/conn.php';

                $CategoryQuery = "SELECT * FROM MainCategory_tbl";
                $CategoryResult = mysqli_query($conn, $CategoryQuery);

                while ($row = mysqli_fetch_assoc($CategoryResult)) {
                    // echo "<option value='" . $row['MainCategoryID'] . "'>" . $row['mainCategoryTitleKH'] . "</option>";

                    // Nested select for Sub1Category
                    echo "<optgroup label='" . $row['mainCategoryTitleKH'] . "'>";

                    $Sub1CategoryQuery = "SELECT * FROM Sub1Category_tbl WHERE MainCategoryID = " . $row['MainCategoryID'];
                    $Sub1CategoryResult = mysqli_query($conn, $Sub1CategoryQuery);

                    while ($subRow = mysqli_fetch_assoc($Sub1CategoryResult)) {
                        echo "<option value='" . $subRow['Sub1CategoryID'] . "'>" . $subRow['Sub1CategoryNameKH'] . "</option>";
                    }

                    echo "</optgroup>";
                }
                ?>
            </select>
        </div> -->
        <div class="mb-3 px-1">
            <label for="Category" class="form-label">Select Category</label>

            <select class="form-select" id="MainCategory" name="MainCategory">
                <option value="">Select Main Category</option>

                <?php
                include './../../Connection/conn.php';

                $CategoryQuery = "SELECT * FROM MainCategory_tbl";
                $CategoryResult = mysqli_query($conn, $CategoryQuery);

                while ($row = mysqli_fetch_assoc($CategoryResult)) {
                    echo "<option value='" . $row['MainCategoryID'] . "'>" . $row['mainCategoryTitleKH'] . "</option>";
                }
                ?>
            </select>
            </div>
            <div class="mb-3 px-1">
            <div id="SubCategoryContainer">
                <!-- Subcategories will be loaded here -->
            </div>
        </div>
        <script>
            document.getElementById('MainCategory').addEventListener('change', function() {
                var mainCategoryId = this.value;

                // Clear existing subcategories
                document.getElementById('SubCategoryContainer').innerHTML = '';

                // Fetch subcategories based on the selected main category using AJAX
                if (mainCategoryId !== '') {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'get_subcategories.php?mainCategoryId=' + mainCategoryId, true);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Append the received subcategories to the container
                            document.getElementById('SubCategoryContainer').innerHTML = xhr.responseText;
                        }
                    };

                    xhr.send();
                }
            });
        </script>
        <div class="mb-3 px-1">
            <label for="imagedetails_1" class="form-label">image Header</label>
            <input type="file" class="form-control" id="imagedetails_1" name="imagedetails_1">
        </div>
        <img id="preview-image" width="70" class="mb-2">
            <?php for ($i = 2; $i <= 11; $i++) : ?>
            <div class="mb-3 px-1">
            <label for="imagedetails_<?php echo $i; ?>" class="form-label">imagedetails_<?php echo $i - 1; ?></label>
            <input type="file" class="form-control" name="imagedetails_<?php echo $i; ?>">
            </div>
        <?php endfor; ?>
        </table>
      </div>
    </main>
    </form>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>
<script src="./../../public/tinymce/tinymce.min.js"></script>
<script src="./../../public/tinymce/tinymce.js"></script>
<script src="../../public/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        // Preview image
        $('#imagedetails_1').change(function() {

            let reader = new FileReader();

            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
                $("#errorMs").hide();
            }
            reader.readAsDataURL(this.files[0]);
        });

    });
</script>
</body>
</html>
