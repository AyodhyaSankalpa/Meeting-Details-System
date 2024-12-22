<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
    	<div class="card-header">
    		<h4 class="mb-0">Users
    			<a href="add-users.php" class="btn btn-primary float-end">Add User</a>
    		</h4>
    	</div>
    	<div class="card-body">

			<?php alertMessage(); ?>

			<?php
				$users = selectAll('users',"type = 'user'");
				if(!$users){
					echo '<h4>somthing Went Wrong!</h4>';
					return false;
				}
				if(mysqli_num_rows($users) > 0)
				{

				
			?>

    		<div class="table-responsive">
    			<table class="table table-striped table-bordered">
    				<thead>						
    					<tr>
    						<th>Name</th>
    						<th>Email</th>
    						<th>Designation</th>
    						<th>Password</th>
    						<th>Profile Picture</th>
    						<th>Action</th>
    					</tr>
    				</thead>
    				<tbody>
						
					<?php foreach($users as $user) : ?>
						
    					<tr>
    						<td><?= $user['name'] ?></td>
    						<td><?= $user['email'] ?></td>
    						<td><?= $user['designation'] ?></td>
    						<td><?= $user['password'] ?></td>
    						<td>
                                <img src="<?= $user['image'] ?>" style="width: 100px; height: 100px;" alt="Img">
                            </td>

                            <td>
								<a href="users-edit.php?id=<?= $user['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
								<a href="users-delete.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure, You want to delete this user.')">
									<i class="fa-solid fa-trash"></i>
								</a>
							</td>
                            
    					</tr>
						<?php endforeach; ?>
						
    				</tbody>
    			</table>
    		</div>

			<?php 
				}
				else
				{
					?>
					<tr>
						<h4 class="mb-0">No Record found</h4>
					</tr>
					<?php
				}
			?>
			
    	</div>
    </div>
</div>


<?php include('includes/footer.php'); ?>