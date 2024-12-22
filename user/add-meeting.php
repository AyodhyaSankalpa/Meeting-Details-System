<?php include('includes/header.php');

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

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Meeting
                <a href="meeting.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <input type="hidden" name="userid" value="<?php echo $user['id']; ?>" class="form-control">

                    <div class="col-md-12 mb-3">
                        <label for="">Date *</label>
                        <input type="date" name="date" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Division *</label>
                        <select name="division" id="" class="form-select">
                            <option value="">Select Division</option>
                            <?php
                            $divisions = getAll('divisions');
                            if ($divisions) {
                                if (mysqli_num_rows($divisions) > 0) {
                                    foreach ($divisions as $divItem) {
                                        echo '<option value="' . $divItem['division_name'] . '">' . $divItem['division_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No divisions Found</option>';
                                }
                            } else {
                                echo '<option value="">Something Went Wrong</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="" for="">Topic *</label>
                        <input type="text" name="topic" required class="form-control">
                    </div>

                    <label>Present</label>
                    <div id="presentFields">
                        <div class="row mb-2 align-items-center">

                            <div class="col">
                                <input type="text" name="present_name[]" class="form-control" placeholder="Name">
                            </div>
                            <div class="col">
                                <select name="designation[]" class="form-select">
                                    <option>Select Designation</option>
                                    <?php
                                    $designations = getAll('designation');
                                    if (mysqli_num_rows($designations) > 0) {
                                        while ($designation = mysqli_fetch_assoc($designations)) {
                                            echo '<option value="' . $designation['designation'] . '">' . $designation['designation'] . '</option>';
                                        }
                                    } else {
                                        echo '<option>No Designations Found</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0);" class="btn btn-success" id="addPresentBtn">
                                    +
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>

                        <!-- Radio buttons with options in one line -->
                        <div id="descriptionFields">
                            <div class="row mb-2 align-items-center">
                                <div class="col">
                                    <textarea name="description[]" class="form-control" rows="1" placeholder="Enter description"></textarea>
                                </div>
                                <div class="col-auto">
                                    <label><input type="radio" name="option[0]" value="Option 1"> Option 1</label>
                                </div>
                                <div class="col-auto">
                                    <label><input type="radio" name="option[0]" value="Option 2"> Option 2</label>
                                </div>
                                <div class="col-auto">
                                    <label><input type="radio" name="option[0]" value="Option 3"> Option 3</label>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0);" class="btn btn-success" id="addDescriptionBtn">
                                        +
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="saveMeeting" class="btn btn-primary">Save</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // Add new "Present" fields dynamically
    document.getElementById('addPresentBtn').addEventListener('click', function() {
        const presentFields = document.getElementById('presentFields');

        // Create a new row for the "Present" fields
        const newFieldRow = document.createElement('div');
        newFieldRow.classList.add('row', 'mb-2', 'align-items-center');

        newFieldRow.innerHTML = `
        
        <div class="col">
            <input type="text" name="present_name[]" class="form-control" placeholder="Name">
        </div>
        <div class="col">
            <select name="designation[]" class="form-select">
                <option>Select Designation</option>
                <?php
                $designations = getAll('designation');
                if (mysqli_num_rows($designations) > 0) {
                    while ($designation = mysqli_fetch_assoc($designations)) {
                        echo '<option value="' . $designation['designation'] . '">' . $designation['designation'] . '</option>';
                    }
                } else {
                    echo '<option>No Designations Found</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <a href="javascript:void(0);" class="btn btn-danger removeField">
                - 
            </a>
        </div>
    `;

        // Append the new row to the presentFields div
        presentFields.appendChild(newFieldRow);

        // Add event listener to the remove button
        newFieldRow.querySelector('.removeField').addEventListener('click', function() {
            newFieldRow.remove();
        });
    });

    let descriptionIndex = 0; // Start index for description/option pairs

    document.getElementById('addDescriptionBtn').addEventListener('click', function() {
        descriptionIndex++; // Increment the index for the new set

        const descriptionFields = document.getElementById('descriptionFields');

        const newDescriptionRow = document.createElement('div');
        newDescriptionRow.classList.add('row', 'mb-2', 'align-items-center');

        newDescriptionRow.innerHTML = `
        <div class="col">
            <textarea name="description[]" class="form-control" rows="1" placeholder="Enter description"></textarea>
        </div>
        <div class="col-auto">
            <label><input type="radio" name="option[${descriptionIndex}]" value="Option 1"> Option 1</label>
        </div>
        <div class="col-auto">
            <label><input type="radio" name="option[${descriptionIndex}]" value="Option 2"> Option 2</label>
        </div>
        <div class="col-auto">
            <label><input type="radio" name="option[${descriptionIndex}]" value="Option 3"> Option 3</label>
        </div>
        <div class="col-auto">
            <a href="javascript:void(0);" class="btn btn-danger removeDescriptionField">
                - 
            </a>
        </div>
    `;

        descriptionFields.appendChild(newDescriptionRow);

        newDescriptionRow.querySelector('.removeDescriptionField').addEventListener('click', function() {
            newDescriptionRow.remove();
        });
    });
</script>

<?php include('includes/footer.php'); ?>