<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
    	<div class="card-header">
    		<h4 class="mb-0">Divisions
    			<a href="add-divisions.php" class="btn btn-primary float-end">Add Division</a>
    		</h4>
    	</div>
    	<div class="card-body">

		<?php alertMessage(); ?>

		<?php
			$divisions = getAll('divisions');
			if(!$divisions){
				echo '<h4>somthing Went Wrong!</h4>';
				return false;
			}
			if(mysqli_num_rows($divisions) > 0)
			{

			
		?>

    		<div class="table-responsive">
    			<table class="table table-striped table-bordered">
    				<thead>						
    					<tr>
    						<th>Division Code</th>
    						<th>Division Name</th>    				
    						<th>Action</th>
    					</tr>
    				</thead>
    				<tbody>
						
					<?php foreach($divisions as $div) : ?>
						
    					<tr>
    						<td><?= $div['division_code'] ?></td>
    						<td><?= $div['division_name'] ?></td>
                            <td>
								<a href="divisions-edit.php?id=<?= $div['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
								<a href="divisions-delete.php?id=<?= $div['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure, You want to delete this user.')">
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