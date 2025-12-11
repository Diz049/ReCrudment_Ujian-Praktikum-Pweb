<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Portal</title>
  <!-- Bootstrap local -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <img src="img/teto.gif" alt="footer_gif" style="width: 3%; height: auto;">
    <a class="navbar-brand" href="index.php">ReCrudment</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <a class="nav-link disabled">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="crud/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="crud/login.php">Login / Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Welcome User -->

<div class="container mt-4">
  <h1>Home Page</h1>
  <p>
    <?php if (isset($_SESSION['username'])): ?>
      You are logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
    <?php else: ?>
      You are not logged in. Please <a href="crud/login.php">Login</a>.
    <?php endif; ?>
  </p>
</div>





<!-- CAROUSEL -->

<?php
include 'crud/connection.php';

$query = "SELECT title, location, salary FROM jobs ORDER BY date_posted DESC LIMIT 5";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$jobs = $result;
?>

<div id="carouselExampleDark" class="carousel slide">
  <div class="carousel-inner">
    <?php 
    $first = true;
    while ($job = mysqli_fetch_assoc($result)): ?>
      <div class="carousel-item <?= $first ? 'active' : '' ?>" data-bs-interval="3000">
        <img src="img/Group 33.png" class="d-block w-100" alt="Job Image">
        <div class="carousel-caption bg-light text-start ps-4 text-dark">
          <h5><?= htmlspecialchars($job['title']) ?></h5>
          <p>Location: <?= htmlspecialchars($job['location']) ?> | Salary: <?= htmlspecialchars($job['salary']) ?></p>
        </div>
      </div>
    <?php 
      $first = false;
    endwhile; 
    ?>
  </div>

  <!--Carausel Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



<!-- SEE MORE JOBS -->
<div class="container text-center my-4">
  <a href="job_list.php" class="btn btn-primary btn-lg">See More Job Listings</a>

<!-- See Applied Application -->
  <?php if (isset($_SESSION['user_id'])): ?>
  <a href="crud\view_applicant_aplication.php" class="btn btn-primary btn-lg">My Applications</a>
  <?php endif; ?>
</div>



<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; 2025 Project Praktikum</p>
</footer>

  <!-- Bootstrap JS local -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
