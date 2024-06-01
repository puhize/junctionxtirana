<?php include('../task_manager/create_task.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>
<h2>Create Task</h2>
<form method="post" action="../task_manager/create_task.php">
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" required><br>
  
  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea><br>
  
  <label for="status">Status:</label>
  <select id="status" name="status" required>
  <?php foreach($enumStatus as $status){ ?>
    <option value="<?php echo $status;?>"><?php echo $status;?></option>
     <?php } ?>
  </select><br>
  
  <label for="priority">Priority:</label>
  <select id="priority" name="priority" required>
  <?php foreach($enumPriority as $priority){ ?>
    <option value="<?php echo $priority;?>"><?php echo $priority;?></option>
     <?php } ?>
  </select><br>
  </select><br>
  
  <label for="deadline">Deadline:</label>
  <?php $today = date('Y-m-d'); ?>
  <input type="date" id="deadline" name="deadline" required min="<?php echo $today;?>" ><br>
  
  <label for="assigned_to">Assigned To:</label>
  <select id="assigned_to" name="assigned_to" required>
    <?php echo getUsersDropdown($conn); ?>
  </select><br>

  <input type="submit" value="Submit">
</form>
</body>
</html>