<?php
$currentPage = 'Projects';
include('includes/header.php');
require "config.php";
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper kanban">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Projects</h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">All Projects</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content pb-3">
      <div class="container-fluid h-100">
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">
              Backlog
            </h3>
          </div>
          <div class="card-body">
	<?php
	$sql = "SELECT * FROM projects WHERE user_uuid = ? AND status = 'On Hold';";
	if($stmt = $mysqli->prepare($sql)){
	    $stmt->bind_param("s", $param_uuid);
	    $param_uuid = $_SESSION['uuid'];
	    if($stmt->execute()){
	        $result = $stmt->get_result();
	        if($result->num_rows == 0){
                    echo "<h5>No projects here!</h5>";
	        }
	        while($row = $result->fetch_assoc()) {
            ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title"><?php echo $row['project_name']; ?></h5>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-link"><b><?php echo $row['id']; ?></b></a>
                  <a href="/projects/edit/<?php echo $row['id']; ?>" class="btn btn-tool">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p><b>Project description</b>: <br><?php echo $row['project_description']; ?><br>
                <b>Client</b>:<br><?php echo $row["client"]; ?><br>
                <b>Est. budget</b>:<br><?php echo $row["est_budget"]; ?><br>
                <b>Total Spent</b>:<br><?php echo $row["total_spent"]; ?><br>
                <b>Est. duration</b>:<br><?php echo $row["est_duration"]; ?></p>
              </div>
            </div>
            <?php
                }
            }
	    $stmt->close();
        }
            ?>
          </div>
        </div>
        <div class="card card-row card-primary">
          <div class="card-header">
            <h3 class="card-title">
              To Do
            </h3>
          </div>
          <div class="card-body">
        <?php
        $sql = "SELECT * FROM projects WHERE user_uuid = ? AND status = 'Planned';";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_uuid);
            $param_uuid = $_SESSION['uuid'];
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 0){
                    echo "<h5>No projects here!</h5>";
                }
                while($row = $result->fetch_assoc()) {
          ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title"><?php echo $row['project_name']; ?></h5>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-link"><?php echo $row['id']; ?></a>
                    <a href="/projects/edit/<?php echo $row['id']; ?>" class="btn btn-tool">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p><b>Project description</b>: <br><?php echo $row['project_description']; ?><br>
                <b>Client</b>:<br><?php echo $row["client"]; ?><br>
                <b>Est. budget</b>:<br><?php echo $row["est_budget"]; ?><br>
                <b>Total Spent</b>:<br><?php echo $row["total_spent"]; ?><br>
                <b>Est. duration</b>:<br><?php echo $row["est_duration"]; ?></p>
              </div>
            </div>
          <?php
              }
          }
          $stmt->close();
      }
          ?>
          </div>
        </div>
        <div class="card card-row card-default">
          <div class="card-header bg-info">
            <h3 class="card-title">
              In Progress
            </h3>
          </div>
          <div class="card-body">
          <?php
        $sql = "SELECT * FROM projects WHERE user_uuid = ? AND status = 'In Progress';";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_uuid);
            $param_uuid = $_SESSION['uuid'];
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 0){
                    echo "<h5>No projects here!</h5>";
                }
                while($row = $result->fetch_assoc()) {
          ?>
            <div class="card card-light card-outline">
              <div class="card-header">
                <h5 class="card-title"><?php echo $row['project_name']; ?></h5>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-link"><?php echo $row['id']; ?></a>
                    <a href="/projects/edit/<?php echo $row['id']; ?>" class="btn btn-tool">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p><b>Project description</b>: <br><?php echo $row['project_description']; ?><br>
                <b>Client</b>:<br><?php echo $row["client"]; ?><br>
                <b>Est. budget</b>:<br><?php echo $row["est_budget"]; ?><br>
                <b>Total Spent</b>:<br><?php echo $row["total_spent"]; ?><br>
                <b>Est. duration</b>:<br><?php echo $row["est_duration"]; ?></p>
              </div>
            </div>
          <?php
              }
          }
          $stmt->close();
      }
          ?>
          </div>
        </div>
        <div class="card card-row card-success">
          <div class="card-header">
            <h3 class="card-title">
              Done
            </h3>
          </div>
          <div class="card-body">
          <?php
        $sql = "SELECT * FROM projects WHERE user_uuid = ? AND status = 'Success';";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_uuid);
            $param_uuid = $_SESSION['uuid'];
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 0){
                    echo "<h5>No projects here!</h5>";
                }
                while($row = $result->fetch_assoc()) {
          ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title"><?php echo $row['project_name']; ?></h5>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-link"><?php echo $row['id']; ?></a>
                    <a href="/projects/edit/<?php echo $row['id']; ?>" class="btn btn-tool">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p><b>Project description</b>: <br><?php echo $row['project_description']; ?><br>
                <b>Client</b>:<br><?php echo $row["client"]; ?><br>
                <b>Est. budget</b>:<br><?php echo $row["est_budget"]; ?><br>
                <b>Total Spent</b>:<br><?php echo $row["total_spent"]; ?><br>
                <b>Est. duration</b>:<br><?php echo $row["est_duration"]; ?></p>
              </div>
            </div>
          <?php
          }}
          $stmt->close();
      }
          ?>
          </div>
        </div>
        <div class="card card-row card-danger">
          <div class="card-header">
            <h3 class="card-title">
              Cancelled
            </h3>
          </div>
          <div class="card-body">
          <?php
        $sql = "SELECT * FROM projects WHERE user_uuid = ? AND status = 'Cancelled';";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_uuid);
            $param_uuid = $_SESSION['uuid'];
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 0){
                    echo "<h5>No projects here!</h5>";
                }
                while($row = $result->fetch_assoc()) {

          ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title"><?php echo $row['project_name']; ?></h5>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-link"><?php echo $row['id']; ?></a>
                    <a href="/projects/edit/<?php echo $row['id']; ?>" class="btn btn-tool">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p><b>Project description</b>: <br><?php echo $row['project_description']; ?><br>
                <b>Client</b>:<br><?php echo $row["client"]; ?><br>
                <b>Est. budget</b>:<br><?php echo $row["est_budget"]; ?><br>
                <b>Total Spent</b>:<br><?php echo $row["total_spent"]; ?><br>
                <b>Est. duration</b>:<br><?php echo $row["est_duration"]; ?></p>
              </div>
            </div>
          <?php
          }}
          $stmt->close();
       }
          ?>
          </div>
        </div>
      </div>
    </section>
<?php
include("includes/footer.php");
?>