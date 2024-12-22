<?php 
include('includes/header.php'); 

// Check if the user is logged in and fetch their details
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); // Fetch the user data
    } else {
        echo "No user found";
        exit();
    }
} else {
    // Redirect to login if the user is not logged in
    header('Location: index.php');
    exit();
}
?>

<!-- Hide navbar profile details (no profile icon and name) -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="../admin/index.php">Minutes System</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
</nav>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Change Password
                <a href="users.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />

                <div class="row">
                    <!-- Name (non-editable) -->
                    <div class="col-md-12 mb-3">
                        <label for="">Name </label>
                        <input type="text" name="name" value="<?php echo $user['name']; ?>" class="form-control" disabled>
                    </div>

                    <!-- Email (non-editable) -->
                    <div class="col-md-12 mb-3">
                        <label for="">Email </label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>" class="form-control" disabled>
                    </div>

                    <!-- Designation (non-editable) -->
                    <div class="col-md-12 mb-3">
                        <label for="">Designation </label>
                        <input type="text" name="designation" value="<?php echo $user['designation']; ?>" class="form-control" disabled>
                    </div>

                    <!-- Password (editable) -->
                    <div class="col-md-12 mb-3">
                        <label for="">New Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="updateProfile" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
