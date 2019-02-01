<?php
if(isset($_GET['f']) && trim($_GET['f']) != ''){
    $path = "deploy/".$_GET['f'];
    @unlink($path);
    header("location: package.php");
}