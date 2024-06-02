<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head content here -->
</head>

<body>
    <!-- Your existing HTML structure -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <p>Name: <?php echo $_SESSION['user']['name'] . " " . $_SESSION['user']['surname']; ?></p>
                                <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
                                <!-- Add more personal information fields as needed -->

                                <!-- Add an edit profile button linking to edit_profile.php -->
                                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                            </div>
                            <div class="col-md-6">
                                <h5>Profile Picture</h5>
                                <!-- Add profile picture display here -->
                                <img src="<?php echo $_SESSION['user']['profile_picture']; ?>" alt="Profile Picture" class="img-fluid">

                                <!-- Add an upload/change picture button linking to upload_picture.php -->
                                <a href="upload_picture.php" class="btn btn-primary">Upload/Change Picture</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add more sections for other features like activity log, performance metrics, etc. -->

    </div>

    <!-- Your existing HTML content continues -->
</body>

</html>