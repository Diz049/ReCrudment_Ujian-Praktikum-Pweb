<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['job_id']; // use POST only

    $query = "DELETE FROM jobs WHERE job_id = '$id'";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        echo "<script>
            alert('Job deleted successfully');
            location.replace('../admin_page.php');
        </script>";
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
} else {
    echo "No POST received.";
}
?>
