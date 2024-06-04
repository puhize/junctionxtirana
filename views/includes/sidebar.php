<?php include('../dashboards/employee.php'); 
$userRole = $_SESSION['user']['role'];
?>
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">

        <a href="" class="simple-text logo-normal">
            <img src="https://cdn.discordapp.com/attachments/1239877130016264203/1246494735955398756/erta-logo.png?ex=665c982f&is=665b46af&hm=37da24a2c8e62d1df181f3041a913d796ff77b270f56268bd5996b06f7b9ec37&" alt="" style="width: 50px; height: auto;">
            Manage Mate
        </a>

    </div>
    <div class="sidebar-wrapper">

        <ul class="nav">
            <?php if($userRole == 'employee') { ?>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'e-dashboard.php' ? 'active' : '' ?>"><a href="e-dashboard.php"><i class="nc-icon nc-paper"></i><p>Tasks</p></a></li>
            <?php } else if($userRole == 'manager'){ ?>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'all_tasks.php' ? 'active' : '' ?>"><a href="all_tasks.php"><i class="nc-icon nc-watch-time"></i><p>Dashboard</p></a></li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'e-dashboard.php' ? 'active' : '' ?>"><a href="e-dashboard.php"><i class="nc-icon nc-paper"></i><p>Tasks</p></a></li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'reports_dashboard.php' ? 'active' : '' ?>"><a href="reports_dashboard.php"><i class="nc-icon nc-single-copy-04"></i><p>Reports</p></a></li>
            <?php } else if($userRole == 'admin') {?>
                <li class="<?= basename($_SERVER['PHP_SELF']) == '../dashboards/Admin.php' ? 'active' : '' ?>"><a href="../dashboards/Admin.php"><i class="nc-icon nc-watch-time"></i><p>Dashboard</p></a></li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'e-dashboard.php' ? 'active' : '' ?>"><a href="e-dashboard.php"><i class="nc-icon nc-paper"></i><p>Tasks</p></a></li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'reports_dashboard.php' ? 'active' : '' ?>"><a href="reports_dashboard.php"><i class="nc-icon nc-single-copy-04"></i><p>Reports</p></a></li>
                <?php } ?>
            
            <li><a href="../auth/logout-logic.php"><i class="nc-icon nc-button-power"></i><p>Logout</p></a></li>
        </ul>
    </div>
</div>