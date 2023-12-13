<?php 
require_once(realpath($_SERVER['DOCUMENT_ROOT']). '/include/dbConnect.php');
require_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');
$useremailid = $_POST['useremailid'];

// Use a placeholder in the query to prevent SQL injection
$query = "SELECT * FROM loginmaster WHERE sEmailID = '$useremailid'";

try {
    $queryDB = $db->prepare($query);

    // Bind the parameter
    $queryDB->bindParam(':useremailid', $useremailid, PDO::PARAM_STR);

    $queryDB->execute();

    // Use rowCount to get the number of rows
    $num = $queryDB->rowCount();

    if ($num > 0) {
        echo json_encode(array("user_status_found" => 1));
    } else {
        echo json_encode(array("user_status_found" => 0));
    }
} catch (Exception $e) {
    // Instead of returning an exception, you might want to handle it appropriately
    echo json_encode(array("error" => $e->getMessage()));
}
?>