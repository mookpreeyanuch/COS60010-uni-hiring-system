<nav class="row">
    <div class="col">
        <ul class="nav">
            <li class="nav-item">
                <img src="images/logo-menu.jpg" alt="Company Logo">
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jobs.php">Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="apply.php">Apply</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="manage.php">HR manager</a>
            </li>
            
            <?php
            if (checkLogin()) {
            ?>
            <li class="nav-item">
                <form method="post" action="logout.php" id="logout-form">
                    <button type="submit" class="nav-link">Logout</button>
                </form>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>