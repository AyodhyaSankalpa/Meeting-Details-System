<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit User
                <a href="users.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }

                $user = getById('users', $paramValue);
                if ($user) {
                    if ($user['status'] == 200) {

                ?>

                        <input type="hidden" name="user_id" value="<?= $user['data']['id']; ?>" />

                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="">Name </label>
                                <input type="text" name="name" required value="<?= $user['data']['name']; ?>" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Email </label>
                                <input type="email" name="email" required value="<?= $user['data']['email']; ?>" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Designation </label>
                                <input type="text" name="designation" value="<?= $user['data']['designation']; ?>" class="form-control">
                            </div>


                            <input type="hidden" name="type" value="user" class="form-control">


                            <div class="col-md-12 mb-3">
                                <label for="">Password </label>
                                <input type="text" name="password" value="<?= $user['data']['password']; ?>" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="">Image</label>
                                <br />
                                <img src="<?= $user['data']['image']; ?>" style="width: 150px;height: 150px;" alt="Img">
                                <br />
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <br />
                                <button type="submit" name="updateUser" class="btn btn-primary">Save</button>
                            </div>

                        </div>
                <?php
                    } else {
                        echo '<h5>' . $user['message'] . '</h5>';
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