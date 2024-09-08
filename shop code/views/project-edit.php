<?php
require "config.php";
$currentPage = 'Edit Project';
include('includes/header.php');
$sql = "SELECT * FROM projects WHERE user_uuid = ? AND id = ?";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("ss", $param_uuid,$param_id);
    $param_uuid = $_SESSION['uuid'];
    $param_id = $id;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            echo "<h1>Unable to retrieve database values!</h1>";
        }
        while($row = $result->fetch_assoc()) {
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Projects</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" id="pageTitle" value="Edit Project">Edit Project</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div id="output"></div>
    <div id="alerts"></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <form id="form-projects-edit">
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Project Name</label>
                <input type="text" id="inputName" value="<?php echo $row['project_name']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputDescription">Project Description</label>
                <textarea id="inputDescription" class="form-control" rows="4"><?php echo $row['project_description']; ?></textarea>
              </div>
              <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option <?php if($row['status'] == 'Planned') { echo "selected"; } ?>>Planned</option>
                  <option <?php if($row['status'] == 'On Hold') { echo "selected"; } ?>>On Hold</option>
                  <option <?php if($row['status'] == 'In Progress') { echo "selected"; } ?>>In Progress</option>
                  <option <?php if($row['status'] == 'Success') { echo "selected"; } ?>>Success</option>
                  <option <?php if($row['status'] == 'Cancelled') { echo "selected"; } ?>>Cancelled</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Client Company</label>
                <input type="text" id="inputClientCompany" value="<?php echo $row['client']; ?>" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Budget</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputEstimatedBudget">Estimated budget</label>
                <input type="number" id="inputEstimatedBudget" value="<?php echo $row['est_budget']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Total amount spent</label>
                <input type="number" id="inputSpentBudget" value="<?php echo $row['total_spent']; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputEstimatedDuration">Estimated project duration</label>
                <input type="number" id="inputEstimatedDuration" value="<?php echo $row['est_duration']; ?>" class="form-control">
              </div>
	      <input id="id" value="<?php echo $id; ?>" hidden></input>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="/projects" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Edit Project" class="btn btn-success float-right">
        </div>
      </div>
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../../assets/plugins/sparklines/sparkline.js"></script>
<script src="../../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="../../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../../assets/plugins/moment/moment.min.js"></script>
<script src="../../assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../assets/js/adminlte.js"></script>
<script src="../../assets/js/demo.js"></script>
<script src="../../assets/js/pages/dashboard.js"></script>
<script src="../../assets/js/api.js"></script>
</body>
</html>
<?php
        }
    }
}