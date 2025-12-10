<?php
session_start();
include 'connection.php'; // koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = $_POST['job_id'];
    $user_id = $_SESSION['user_id']; // pastikan user login
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // --- Upload CV ---
    $cv_file = null;
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == 0) {
        $uploadDir = "uploads/cv/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // bikin folder kalau belum ada
        }

        $fileExt = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid("cv_") . "." . $fileExt;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadPath)) {
            $cv_file = $fileName;
        } else {
            die("Upload CV gagal!");
        }
    }

    // --- Insert ke DB ---
    $sql = "INSERT INTO applications (job_id, user_id, name, email, phone, cv_file) 
             VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    echo $conn->error;
    $stmt->bind_param("iissss", $job_id, $user_id, $name, $email, $phone, $cv_file);

    if ($stmt->execute()) {
        echo "<script>alert('Lamaran berhasil dikirim!'); window.location.href='../job_list.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
