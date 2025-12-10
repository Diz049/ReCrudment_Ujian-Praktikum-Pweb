<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT jobs.job_id, jobs.title, jobs.description, jobs.location, jobs.salary, applications.date_applied
          FROM applications 
          JOIN jobs ON applications.job_id = jobs.job_id
          WHERE applications.user_id = $user_id
          ORDER BY applications.date_applied DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Applications</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="../img/teto.gif" alt="footer_gif" style="width: 3%; height: auto;">
            <a class="navbar-brand" href="../index.php">ReCrudment</a>
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
                        <a class="nav-link" href="logout.php">Logout</a>
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

    <div class="container mt-4">
        <h2 class="mb-4">My Applications</h2>
        <div class="mb-4">
            <a href="../index.php" class="btn text-white btn-lg" style="background-color: blue;">Kembali</a>
        </div>

        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="card-text">
                            <?= nl2br(htmlspecialchars(substr($row['description'], 0, 100))) ?>...
                        </p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                        <p><strong>Salary:</strong> <?= htmlspecialchars($row['salary']) ?></p>
                        <p><small class="text-muted">Applied on: <?= htmlspecialchars($row['date_applied']) ?></small>
                        </p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p class="text-muted">You haven’t applied for any jobs yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- FOOTER -->
    <!-- <footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; 2025 Project Lepkom</p>
</footer> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
