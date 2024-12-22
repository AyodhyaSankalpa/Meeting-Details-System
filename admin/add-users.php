<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
    	<div class="card-header">
    		<h4 class="mb-0">Add Users
    		  <a href="users.php" class="btn btn-danger float-end">Back</a>
            </h4>
    	</div>
        <div class="card-body">

        <?php alertMessage(); ?>

        <form action="code.php" method="POST" enctype="multipart/form-data">
                
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label for="">Name </label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Email </label>
                        <input type="email" name="email" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Designation </label>
                        <input type="text" name="designation" required class="form-control">
                    </div>

                    
                        <input type="hidden" name="type" value="user" class="form-control">
                    

                    <div class="col-md-12 mb-3">
                        <label for="">Password </label>
                        <input type="text" name="password" required class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="saveUser" class="btn btn-primary">Save</button>
                    </div>

                </div>
        </form>

        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>