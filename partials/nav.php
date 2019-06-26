<nav class="grey darken-3">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/project/index.php" class="brand-logo center">Task</a>
            <!-- RIGHT NAV -->
            <ul class="right hide-on-small-only">
                <?php
                    if (!isset($_SESSION["id"]) && !isset($_COOKIE["id"])) {
                        echo '<li><a class="btn red darken-1" href="signin.php">Sign In</a></li>';
                        echo '<li><a class="btn green darken-1" href="signup.php">Sign Up</a></li>';
                    } else {
                        echo '<li><a class="btn gray darken-1" href="logout.php">Logout</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>