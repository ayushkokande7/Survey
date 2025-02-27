<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
        <div class="row">
          <a href="index.php?page=user_list" class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Subscribers</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type = 3")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
          <!-- /.col -->
          <a href="index.php?page=survey_list" class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Survey</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
          <!-- /.col -->
          <a href="index.php?page=survey_report" class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Survey Report</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
      </div>

<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
          <a href="index.php?page=user_servey" class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Surveys Taken</span>
                <span class="info-box-number">
                  <?php # echo $conn->query("SELECT distinct(survey_id) FROM answers  where user_id = {$_SESSION['login_id']}")->num_rows; ?>
                  <?php echo $conn->query("SELECT survey_count FROM users where id = {$_SESSION['login_id']}")->fetch_array()['survey_count']; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
          <!-- /.col -->
          <a href="index.php?page=survey_widget" class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Survey List</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
      </div>
          
<?php endif; ?>
