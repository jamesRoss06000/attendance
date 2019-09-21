<?php
if (!isset($_SESSION['admin'])) {
        echo "<b>Please login to use this system</b>";
        echo "<td><a class='btn btn-danger btn-modal btn-md' id='login' href='index.php'>Click To Login</a></td>";
        echo "<script>$(':button').prop('disabled', true);</script>";
}
