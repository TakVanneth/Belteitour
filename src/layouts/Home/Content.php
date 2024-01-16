<?php
try {
    // Check if mainID and subID are set and not empty
    if ($_SERVER["REQUEST_METHOD"] !== "GET" || !isset($_GET['mainID']) || !isset($_GET['subID']) || empty($_GET['mainID']) || empty($_GET['subID'])) {
        // Display a welcome section with Bootstrap-styled divs, including images and links
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img class="img-fluid" src="./public/img/welcome_to_beltei_tour.png" alt="Welcome to BELTEI Tour">
                </div>
            </div>

            <div class="row text-center">
                <div class="col-6">
                    <a href="https://www.facebook.com/belteitour" target="_blank">
                        <img class="img-fluid" src="./public/img/tour_facebook.png" alt="Facebook">
                    </a>
                </div>
                <div class="col-6">
                    <a href="https://www.youtube.com/user/BELTEIGROUP" target="_blank">
                        <img class="img-fluid" src="./public/img/beltei_youtube.png" alt="YouTube">
                    </a>
                </div>
            </div>

            <div class="row" style="text-align: center;">
                <div class="col-12">
                    <p style="margin-top: 20px; color: rgb(41,100,193);">
                        Please click the image below for more details<br><br>
                        Congratulations on the Weekend Trip of BELTEI Group<br><br>
                        Management Team to Sihanoukville by traveling on the PPSHV Expressway
                    </p><br/>
                </div>
            </div>
        </div>
        <?php
    } else {
        // If mainID and subID are set, proceed with data retrieval
        $mainID = $_GET['mainID'];
        $subID = $_GET['subID'];

        // Check if mainID is 44
        if ($mainID == 44) {
            // Include the database connection file
            include './Connection/conn.php';

            // Retrieve data from the About_tbl table based on subID
            $sql = "SELECT * FROM About_tbl WHERE Sub1CategoryID = $subID";
            $result = $conn->query($sql);

            // Check if records are found
            if ($result->num_rows > 0) {
                // Loop through each record and display content and images
                while ($row = $result->fetch_assoc()) {
                    $content = $row['content'];

                    // Display content and the first image
                    ?>
                    <div class='container'>
                        <div class='row'>
                            <div class='col-12'>
                                <img class='img-fluid' style='width: 100%; margin-bottom: 10px; margin-top: 20px' src='./public/uploads/about/<?= $row['imagedetails_1'] ?>' alt='Image 1'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12'>
                                <?= $content ?>
                            </div>
                        </div>
                        <?php
                        // Loop through image details columns and display them in pairs
                        for ($i = 2; $i <= 10; $i += 2) {
                            $imageDetails1 = $row["imagedetails_$i"];
                            $imageDetails2 = $row["imagedetails_" . ($i + 1)];

                            // Check if both images are not empty
                            if (!empty($imageDetails1) && !empty($imageDetails2)) {
                                ?>
                                <div class="row">
                                    <div class='col-6'>
                                        <img class='img-fluid' style='width: 100%; margin-bottom: 10px;' src='./public/uploads/about/<?= $imageDetails1 ?>' alt=''>
                                    </div>
                                    <div class='col-6'>
                                        <img class='img-fluid' style='width: 100%; margin-bottom: 10px;' src='./public/uploads/about/<?= $imageDetails2 ?>' alt=''>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
            } else {
                // If no records found
                ?>
                <div class='container'>
                    <div class='row'>
                        <div class='col-12'>No records found</div>
                    </div>
                </div>
                <?php
            }

            // Close the database connection
            $conn->close();
        }
    }
} catch (Exception $e) {
    // Catch and display any exceptions that occur
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>
