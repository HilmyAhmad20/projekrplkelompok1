<?php
session_start();
session_destroy();
?>
<script language="javascript">
alert("Anda Yakin Akan Logout??");
document.location="login.php";
</script>