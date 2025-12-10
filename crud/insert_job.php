<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST received<br>";

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $requirements = $_POST['requirements'] ?? null;
    $location = $_POST['location'] ?? null;
    $salary = $_POST['salary'] ?? null;

    echo "Title: $title<br>";

    $query = "INSERT INTO jobs (title, description, requirements, location, salary) 
              VALUES ('$title','$description','$requirements','$location','$salary')";
    echo "Query: $query<br>";

    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        echo "<script>
            alert('Data berhasil disimpan');
            location.replace('../admin_page.php');
        </script>";
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
} else {
    echo "No POST received.";
}
