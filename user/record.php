<?php
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$userId = $_SESSION['user_id'];  // Get the logged-in user ID

// Sanitize the designation parameter from the URL
$des = isset($_GET['designation']) ? mysqli_real_escape_string($conn, $_GET['designation']) : null;

// Fetch user details based on designation (optional)
$userQuery = "SELECT * FROM designation WHERE designation = '$des'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Fetch meetings for the user based on user ID and designation
$query = "SELECT details.*, meeting_attendees.designation
          FROM details
          LEFT JOIN meeting_attendees ON details.id = meeting_attendees.meeting_id
          WHERE details.userid = '$userId' AND meeting_attendees.designation = '$des'
          ORDER BY details.id DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Meeting Record</h3>
    <ol class="breadcrumb mb-4"></ol>

    <!-- Display any alert messages -->
    <?php alertMessage(); ?>

    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Division</th>
                        <th>Topic</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Division</th>
                        <th>Topic</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    // Check if there are any results for the current user
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through the fetched data and display it in the table
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['division']; ?></td>
                                <td><?php echo $row['topic']; ?></td>
                                <td>
                                    <div class="text-center">
                                        <a href="view_meeting.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="edit_meeting.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="delete_meeting.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No meeting details found for this user.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
