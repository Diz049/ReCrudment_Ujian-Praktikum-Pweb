<?php
session_start();
require "crud/connection.php"; // file koneksi

// cek kalau user admin langsung redirect ke admin_page
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: admin_page.php");
    exit();
}

// ambil semua pekerjaan (atau limit kalau mau pagination)
$sql = "SELECT * FROM jobs ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <img src="img/teto.gif" alt="footer_gif" style="width: 3%; height: auto;">
      <a class="navbar-brand" href="index.php">ReCrudment</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item"><span class="nav-link">Hi, <?= $_SESSION['username'] ?></span></li>
          <li class="nav-item"><a class="nav-link" href="crud/logout.php">Logout</a></li>
          <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="crud/login.php">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container mt-4">
    <h2 class="mb-4">Daftar Pekerjaan</h2>
    <a href="index.php" class="btn text-white btn-lg" style="background-color: blue;">Kembali</a>
  </div>


  <!-- Job list -->
  <?php
    include "crud\connection.php"; // koneksi

    $sql = "SELECT * FROM jobs ORDER BY job_id DESC";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query error: " . $conn->error);
    }
    ?>


  <div class="container py-4">
    <div class="row g-4">

      <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="card h-100">
          <img src="img\istockphoto-1289354739-612x612.jpg" class="card-img-top" alt="job image">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="card-text">
              <?= nl2br(htmlspecialchars(substr($row['description'], 0, 100))) ?>...
            </p>
            <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
            <p><strong>Salary:</strong> <?= htmlspecialchars($row['salary']) ?></p>

            <!-- View details -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#viewJobModal<?= $row['job_id'] ?>">
              View Details
            </button>


            <!-- Apply Button -->
            <?php if (isset($_SESSION['user_id'])): ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal"
              data-bs-target="#applyJobModal<?= $row['job_id'] ?>">
              Apply
            </button>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- View job details Modal -->
      <div class="modal fade" id="viewJobModal<?= $row['job_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><?= htmlspecialchars($row['title']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($row['description'])) ?></p>
              <p><strong>Requirements:</strong><br><?= nl2br(htmlspecialchars($row['requirements'])) ?>
              </p>
              <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
              <p><strong>Salary:</strong> <?= htmlspecialchars($row['salary']) ?></p>
              <p><strong>Date Posted:</strong> <?= htmlspecialchars($row['date_posted']) ?></p>
            </div>
          </div>
        </div>
      </div>


      <!-- Apply job modal -->
      <div class="modal fade" id="applyJobModal<?= $row['job_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <form action="crud/insert_applicants.php" method="POST" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Apply for <?= htmlspecialchars($row['title']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="job_id" value="<?= $row['job_id'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? '' ?>">

                <div class="mb-3">
                  <label for="fullname<?= $row['job_id'] ?>" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="fullname<?= $row['job_id'] ?>" name="name" required>
                </div>

                <div class="mb-3">
                  <label for="email<?= $row['job_id'] ?>" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email<?= $row['job_id'] ?>" name="email" required>
                </div>

                <div class="mb-3">
                  <label for="phone<?= $row['job_id'] ?>" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" id="phone<?= $row['job_id'] ?>" name="phone" required>
                </div>

                <div class="mb-3">
                  <label for="cv<?= $row['job_id'] ?>" class="form-label">Upload CV</label>
                  <input type="file" class="form-control" id="cv<?= $row['job_id'] ?>" name="cv_file">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit Application</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>



      <?php endwhile; ?>
      <?php else: ?>
      <p>No job listings available.</p>
      <?php endif; ?>

    </div>
  </div>

  <!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; 2025 Project Praktikum</p>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
