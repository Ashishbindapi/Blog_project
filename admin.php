<h1>Welocome</h1>
<?php
session_start();
if (isset($_SESSION['user_data'])) {
    echo $_SESSION['user_data']['0'];
}
?>