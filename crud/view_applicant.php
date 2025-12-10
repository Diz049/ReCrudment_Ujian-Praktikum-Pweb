<?php
include 'connection.php';
$job_id = intval($_GET['job_id']);

// get applicantions title 
$query_job = "SELECT title FROM jobs WHERE job_id = $job_id";
$result_job = mysqli_query($conn, $query_job);
$job = mysqli_fetch_assoc($result_job);
$job_title = $job ? $job['title'] : "Unknown Job";

// get applicants data
$query = "SELECT * FROM applications WHERE job_id = $job_id";
$result = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Applicants for <?= $job_title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .page-header {
      background: #0d6efd;
      color: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: center;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .table th {
      background-color: #f1f3f5;
    }
    .btn-back {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
          <img src="../img/teto_black.gif" alt="footer_gif" style="width: 3%; height: auto;">
      <a class="navbar-brand" href="../admin_page.php">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link btn btn-danger btn-sm text-white px-3" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>



  <div class="container my-4">
    <div class="page-header">
      <h2>Applicants for: <?= htmlspecialchars($job_title) ?></h2>
    </div>

    <a href="../admin_page.php" class="btn btn-secondary btn-back"><- Back</a>

    <div class="card p-3">      
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>CV</th>
              <th>Date Applied</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_array($result)): ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><a class="btn btn-sm btn-outline-primary" href="uploads/cv/<?= htmlspecialchars($row['cv_file']) ?>" target="_blank">View CV</a></td>
              <td><?= htmlspecialchars($row['date_applied']) ?></td>
            </tr>
            <?php $no++; endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
