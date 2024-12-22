<?php include('includes/header.php');

if (isset($_SESSION['loggedIn'])) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}

?>

<div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow rounded-4">


                    <?php alertMessage(); ?>

                    <div class="p-5">
                        <h4 class="text-dark mb-3">Sign into Meeting Details System</h4>

                        <form action="login-code.php" method="POST">

                            <div class="mb-3">
                                <label for="">Enter Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="">Enter Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="my-3">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">
                                    Sign In
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</main>
</div>
<div id="layoutAuthentication_footer shadow-lg">
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div><a href="https://www.slpa.lk/" target="_blank" class="text-muted" style="text-decoration: none;">Copyright &copy;All rights reserved.</a></div>
                <div>
                    <a href="">Created by: Ayodhya Sankalpa</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>

<!-- IF YOU HAVE ANY ERROR THIS SYSTEM PLEASE CONTACT :- https://www.linkedin.com/in/ayodhya-sankalpa-00abba2ba/ -->


</html>