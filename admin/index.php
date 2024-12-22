<?php 

include('includes/header.php'); 


// Query to count users
$userCountQuery = "SELECT COUNT(*) as user_count FROM users WHERE type='user'";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['user_count'];

// Query to count divisions
$divisionCountQuery = "SELECT COUNT(*) as division_count FROM divisions";
$divisionCountResult = mysqli_query($conn, $divisionCountQuery);
$divisionCount = mysqli_fetch_assoc($divisionCountResult)['division_count'];


?>


<div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <!-- <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->

        <?php alertMessage(); ?>

    <div class="row custom-mt">
        <div class="card shadow custom-margin" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-user"></i> Users</h5>
                <h6 class="card-subtitle mb-2 text-muted">all Users</h6>
                <h3 class="text-center mt-3"><?php echo $userCount; ?></h3>
                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                <!-- <a href="#" class="card-link">Card link</a> -->
                <!-- <a href="#" class="card-link">Another link</a> -->
            </div>
        </div>

        <div class="card shadow custom-margin" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-sitemap"></i> Division</h5>
                    <h6 class="card-subtitle mb-2 text-muted">All Division</h6>
                    <h3 class="text-center mt-3"><?php echo $divisionCount; ?></h3>
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                    <!-- <a href="#" class="card-link">Card link</a> -->
                    <!-- <a href="#" class="card-link">Another link</a> -->
                </div>
        </div>
</div>




</div>


<?php include('includes/footer.php'); ?>