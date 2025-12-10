<?php
session_start();
if ($_SESSION['role'] != 'admin') {
  header("Location: index.php");
  exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <img src="img/teto_black.gif" alt="footer_gif" style="width: 3%; height: auto;">
      <a class="navbar-brand" href="admin_page.php">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link btn btn-danger btn-sm text-white px-3" href="crud/logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- MAIN CONTENT -->
      <div class="col-md-9 col-lg-12 p-4">
        <h2>Welcome, Admin</h2>
        <p class="lead">Use the menu to manage job listings and applicants.</p>

        <!-- contoh ringkasan statistik -->
        <div class="row">



          <?php
              include "crud/connection.php"; 

              //total jobs
              $sql_count = "SELECT COUNT(*) AS total_jobs FROM jobs";
              $result_count_job = $conn->query($sql_count);
              $total_jobs = 0;

              if ($result_count_job && $row = $result_count_job->fetch_assoc()) {
                  $total_jobs = $row['total_jobs'];
              }

              //total applicants
              $sql_count = "SELECT COUNT(*) AS total_applicants FROM applications";
              $result_count_applicants = $conn->query($sql_count);
              $total_applicants = 0;

              if ($result_count_applicants && $row = $result_count_applicants->fetch_assoc()) {
                  $total_applicants = $row['total_applicants'];
              }
            ?>

          <!-- //job count -->
          <div class="col-md-6">
            <div class="card text-bg-primary mb-3">
              <div class="card-body">
                <h5 class="card-title">Total Jobs</h5>
                <p class="card-text display-6"><?= $total_jobs ?></p>
              </div>
            </div>
          </div>


          <!-- Applicants count -->
          <div class="col-md-6">
            <div class="card text-bg-success mb-3">
              <div class="card-body">
                <h5 class="card-title">Applicants</h5>
                <p class="card-text display-6"><?= $total_applicants ?></p>
              </div>
            </div>
          </div>


          <!-- Create Jobs         -->
          <div class="col-md-12 ">
            <div class="card text-bg-light mb-3">
              <div class="card-body text-center">
                <h5 class="card-title ">Create New Job Listing</h5>

                <!-- Button pop up form modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJobModal">
                  Create Job
                </button>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="createJobModal" tabindex="-1" aria-labelledby="createJobModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="createJobModalLabel">Create New Job Listing</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="crud/insert_job.php" method="POST">
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Job Title</label>
                      <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Requirements</label>
                      <textarea class="form-control" name="requirements" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Location</label>
                      <input type="text" class="form-control" name="location">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Salary</label>
                      <input type="text" class="form-control" name="salary">
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Job</button>
                  </div>
                </form>

              </div>


            </div>
          </div>


          <!-- <div class="col-md-6">
            <div class="card text-bg-light mb-3">
              <div class="card-body">
                <h5 class="card-title">View Job List</h5>
                <a class="btn btn-primary" href="view_job.php" role="button">Link</a>
              </div>
            </div>
          </div> -->

          <!-- <div class="col-md-4">
          <div class="card text-bg-light mb-3">
            <div class="card-body">
              <h5 class="card-title">Applicants</h5>
              <button type="button" class="btn btn-success">Success</button>
            </div>
          </div>
        </div> -->

        </div>

      </div>


    </div>


    <!-- View detailed job desc -->
    <?php
    include "crud\connection.php";

    $sql = "SELECT * FROM jobs ORDER BY job_id DESC";
    $result = $conn->query($sql);

    $count = "SELECT j.*, COUNT(a.application_id) AS applicant_count
    FROM jobs j
    LEFT JOIN applications a ON j.job_id = a.job_id
    GROUP BY j.job_id
    ORDER BY j.job_id DESC";

    $count_result = $conn->query($count);

    if (!$result) {
        die("Query error: " . $conn->error);
    }
    ?>


    <!-- job list modal -->
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

              <!-- BUTTONS -->

              <!-- View details -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#viewJobModal<?= $row['job_id'] ?>">
                View Details
              </button>

              <!-- Edit -->
              <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#editJobModal<?= $row['job_id'] ?>">
                Edit
              </button>

              <!-- Delete -->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#deleteJobModal<?= $row['job_id'] ?>">
                Delete
              </button>

              <!-- View Applicant -->
              <?php
              // Get applicant count for this job
              $jobId = (int)$row['job_id'];
              $appCount = 0;

              $resultCount = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE job_id = $jobId");
              if ($resultCount && $countRow = $resultCount->fetch_assoc()) {
                  $appCount = (int)$countRow['total'];
              }

              ?>

              <a type="button" class="btn btn-info" href="crud/view_applicant.php?job_id=<?= $jobId ?>">
                Applicants <span class="badge bg-light text-dark"><?= (int)$appCount ?></span>
              </a>

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
                <p><strong>Requirements:</strong><br><?= nl2br(htmlspecialchars($row['requirements'])) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                <p><strong>Salary:</strong> <?= htmlspecialchars($row['salary']) ?></p>
                <p><strong>Date Posted:</strong> <?= htmlspecialchars($row['date_posted']) ?></p>
              </div>
            </div>
          </div>
        </div>


        <!-- Edit Job modal -->
        <div class="modal fade" id="editJobModal<?= $row['job_id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form method="POST" action="crud/update_job.php">
                <div class="modal-body">
                  <input type="hidden" name="job_id" value="<?= $row['job_id'] ?>">
                  <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                      class="form-control"><?= htmlspecialchars($row['description']) ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Requirements</label>
                    <textarea name="requirements"
                      class="form-control"><?= htmlspecialchars($row['requirements']) ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                      value="<?= htmlspecialchars($row['location']) ?>">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Salary</label>
                    <input type="text" name="salary" class="form-control"
                      value="<?= htmlspecialchars($row['salary']) ?>">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Delete Job Modal -->
        <div class="modal fade" id="deleteJobModal<?= $row['job_id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete <strong><?= htmlspecialchars($row['title']) ?></strong>?
              </div>
              <div class="modal-footer">
                <form method="POST" action="crud/delete_job.php">
                  <input type="hidden" name="job_id" value="<?= $row['job_id'] ?>">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>



        <?php endwhile; ?>
        <?php else: ?>
        <p>No job listings available.</p>
        <?php endif; ?>

      </div>
    </div>






  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
