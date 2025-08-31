<?php
session_start();
$_SESSION['user_login'] == false;
// Destroy the session
session_unset();
session_destroy();

?>
<script language="javascript">
    document.location = "index.php";
</script>