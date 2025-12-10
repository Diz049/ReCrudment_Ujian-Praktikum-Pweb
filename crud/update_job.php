<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['job_id'];

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $requirements = $_POST['requirements'] ?? null;
    $location = $_POST['location'] ?? null;
    $salary = $_POST['salary'] ?? null;

    $query = "UPDATE jobs 
              SET 
                title = '$title', 
                description = '$description', 
                requirements = '$requirements', 
                location = '$location', 
                salary = '$salary'
              WHERE job_id = '$id'";

    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        echo "<script>
            alert('Job updated successfully');
            location.replace('../admin_page.php');
        </script>";
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
} else {
    echo "No POST received.";
}
