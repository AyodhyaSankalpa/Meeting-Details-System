<?php
include('includes/header.php');

// Check if meeting ID is passed
if (isset($_GET['id'])) {
    $meetingId = $_GET['id'];

    // Fetch meeting details based on the passed ID
    $query = "SELECT * FROM details WHERE id = '$meetingId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $meeting = mysqli_fetch_assoc($result); // Fetch the meeting data

        // Fetch attendees related to this meeting
        $attendeesQuery = "SELECT * FROM meeting_attendees WHERE meeting_id = '$meetingId'";
        $attendeesResult = mysqli_query($conn, $attendeesQuery);

        // Fetch descriptions and options related to this meeting
        $descriptionQuery = "SELECT * FROM meeting_description_options WHERE meeting_id = '$meetingId'";
        $descriptionResult = mysqli_query($conn, $descriptionQuery);
    } else {
        echo "No meeting found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<div class="container-fluid px-4">
    

    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h4><?php echo $meeting['topic']; ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Date: <?php echo $meeting['date']; ?></label>
                    <!-- <p><?php echo $meeting['date']; ?></p> -->
                </div>
                <br>
                <br>
                <div class="col-md-12">
                    <label>Division: <?php echo $meeting['division']; ?></label>
                    <!-- <p><?php echo $meeting['division']; ?></p> -->
                </div>
                
            </div>
            
            <h5 class="mt-4">Present</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($attendeesResult) > 0) {
                        while ($attendee = mysqli_fetch_assoc($attendeesResult)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($attendee['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($attendee['designation']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">No attendees found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <h5 class="mt-4">Descriptions</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($descriptionResult) > 0) {
                        while ($description = mysqli_fetch_assoc($descriptionResult)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($description['description']) . '</td>';
                            echo '<td>' . htmlspecialchars($description['option_selected']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">No descriptions found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            
            <a href="meeting.php" class="btn btn-danger float-end back-button">Back</a>
            <a href="" onclick="window.print()" class="btn btn-primary float-end" style="margin-right: 10px;"><i class="fa fa-print"></i></a>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>





