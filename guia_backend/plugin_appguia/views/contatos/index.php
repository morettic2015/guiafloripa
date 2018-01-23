<?php
session_start();
$_SESSION['code']=$_GET['code'];
header('Location: https://app.guiafloripa.com.br/wp-admin/admin.php?page=app_guiafloripa_leads_imp&source=google&code=SET');
