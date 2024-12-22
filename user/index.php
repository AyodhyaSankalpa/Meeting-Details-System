<?php
include('includes/header.php');


$query = "SELECT * FROM designation";  // Fetch records where userid matches
$result = mysqli_query($conn, $query);

?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Organizational Structure</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Display any alert messages -->
    <?php alertMessage(); ?>

    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Description</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Designation</th>
                        <th>Description</th>
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    // Check if there are any results for the current user
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through the fetched data and display it in the table
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Limit the description to the first 8 words
                            $description = $row['description'];
                            $descriptionWords = explode(' ', $description);
                            $shortDescription = implode(' ', array_slice($descriptionWords, 0, 20)) . '...';  // Get the first 8 words
                    ?>
                    <tr>
                        <td><?php echo $row['designation']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <div class="text-center">
                                <a href="record.php?designation=<?php echo $row['designation']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No meeting details found for this user.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
