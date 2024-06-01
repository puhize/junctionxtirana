<?php
    session_start();
    include('../dashboards/employee.php');
    include('../config/config.php');
    include('includes/header.php');
    

?>
<style>
    body {
        padding-top: 70px;
    }
    .row{
        margin-top: 50px;
        margin-left: 30px;
        margin-right: 30px;
    }
  .card-header {
    padding: 10px; 
    text-align: center; 
    max-height: 50px; 
  }
  
  .card-category {
    font-size: 14px; 
    color: white !important;
    margin-bottom: 10px; }
    .task {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    .task-title {
      margin: 0;
      font-size: 14px;
    }
    .task-icon {
      cursor: pointer;
    }
</style>
<div>
<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"> <?php echo $_SESSION['user']['name']." ".$_SESSION['user']['surname'] ?> </a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
           
            <ul class="navbar-nav">
             
             
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
</nav>
</div>
    <?php
    $sql = "SHOW COLUMNS FROM tasks WHERE Field = 'status'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch the column information
    $columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($columnInfo) {
        // Extract enum values from the column definition
        preg_match_all("/'([^']+)'/", $columnInfo['Type'], $matches);
        $enumValues = $matches[1];

        // Output the enum values
 } ?>
    <div class="content">
        <div class="row">
            <?php
            foreach($enumValues as $status){ ?>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header" style="background-color: #00344F; color: white;">
                            <h5 class="card-category"><?php echo $status; ?></h5>
                        </div>
                        <div class="card-body" style="max-height: 300px; height: 300px; overflow-y: auto;"  id="backlogCardBody">
                            <?php 
                                // $taskStmt = $conn->prepare("SELECT * FROM tasks WHERE status = :status");
                                // $taskStmt->bindParam(':status', $status);
                                // $taskStmt->execute();
                                // $tasks = $taskStmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($tasks as $task){ ?>
                                <?php if($task['status']==$status){ ?> 
                                    <?php $modalId = 'taskModal'.$task['id'];?>
                                    <div class="task">
                                    <span class="task-title">
                                    <?php echo $task['title']; ?>
                                      </span>
                                      <i class="fa fa-info-circle task-icon" data-toggle="modal" data-target="#<?php echo $modalId; ?>"></i>
                                
                                    </div>
                                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="<?php echo $modalId; ?>"><?php echo $task['title'];?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Task 1.1 details go here -->
                                            <?php echo $task['title'];?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                </div>
                                </div>
                               <?php } ?>
                        
                                 <?php } ?>
    
                        </div>
                    </div>
                </div>
      <?php  } ?> 
    </div>
    <!-- MODAL  -->
 </div>
 <?php include('includes/footer.php');?>
