<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
    	<div class="card-header">
    		<h4 class="mb-0">Update Division
    		  <a href="divisions.php" class="btn btn-danger float-end">Back</a>
            </h4>
    	</div>
        <div class="card-body">

        <?php alertMessage(); ?>

        <form action="code.php" method="POST">

        <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }

                $division = getById('divisions', $paramValue);
                if ($division) {
                    if ($division['status'] == 200) {

                ?>

                        <input type="hidden" name="division_id" value="<?= $division['data']['id']; ?>" />
                
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label for="">Division Code </label>
                        <input type="number" name="divisioncode" required value="<?= $division['data']['division_code']; ?>" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Division Name </label>
                        <input type="text" name="divisionname" required value="<?= $division['data']['division_name']; ?>" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="updateDivision" class="btn btn-primary">Save</button>
                    </div>


                </div>

                <?php
                    } else {
                        echo '<h5>' . $division['message'] . '</h5>';
                    }
                } else {
                    echo '<h5>Somthing Went Wrong</h5>';
                    return false;
                }
                ?>

        </form>

        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>