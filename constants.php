<?php
define("BASE_URL", "http://localhost:8888/Y2S1/BelteiTourAndTravels");
// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASSWORD", "root");
// define("PORTFOLIO_UPLOAD_DIR", "uploads/portfolios");
// define("PORTFOLIO_PAGINATION_LIMIT", 3);
// define("CONTACT_FORM_PAGINATION_LIMIT", 3);

function getFullUrl($uri) {
    return BASE_URL . '/' . $uri;
}
?>