<?php
if ($_FILES) {
    require_once 'libs/functions.php';
    $path = $packageName = $_FILES['package']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $mime_type = $_FILES['package']['type'];
    if (($mime_type === 'application/octet-stream' || $mime_type === 'application/zip') && $ext === 'zip') {
        $dest = dirname(__FILE__) . "/packages/" . $path;
        if (move_uploaded_file($_FILES['package']['tmp_name'], $dest)) {
            $zip = new ZipArchive;
            if ($zip->open($dest) === TRUE) {
                $tmpPath = dirname(__FILE__) . "/tmp/" . uniqid() . "/";
                $zip->extractTo($tmpPath);
                $zip->close();
                $sugarModulePath = $tmpPath . "SugarModules";
                if (file_exists($tmpPath . "/manifest.php")) {
                    require_once $tmpPath . "/manifest.php";
                    $file = file_get_contents($tmpPath . "/manifest.php");
                    preg_match_all('/\$[A-Za-z0-9-_]+/', $file, $vars);
                    $newString = "<?php \n";
                    foreach ($vars[0] as $subvar) {
                        $newVar = substr($subvar, 1);
                        if ($subvar == '$installdefs') {
                            $langArr = [];
                            foreach(${$newVar}['language'] as $item){
                                $langArr[] = $item['from'];
                            }
                            $arr = array();
                            createCopyArray($sugarModulePath, "", $langArr);
                            ${$newVar}['copy'] = $arr;
                            echo var_export(${$newVar}['copy'], true); exit;
                        }

                        $str = $subvar . " = " . var_export(${$newVar}, true);
                        $newString .= $str . ";\n\n\n\n\n";
                    }
                    $newString .= "\n?>";
                    file_put_contents($tmpPath . "/manifest.php", $newString);
                }
                /**
                 * Zip file
                 */
                $nZip = new ZipArchive();
                if ($nZip->open("deploy/".$packageName, ZIPARCHIVE::CREATE) !== TRUE) {
                    die("Could not open archive");
                }
                $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($tmpPath), RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($tmpPath));
                        str_replace("\\", "\/", $filePath);
                        str_replace("\\", "\/", $relativePath);
                        $nZip->addFile($filePath, $relativePath);
                    }
                }
                $nZip->close();
                @unlink($tmpPath);
                @unlink($dest);
                header("location: package.php");
            } else {
                echo 'failed';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SUGAR MODULE GENERATE MANIFEST</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css" >
        <link rel="stylesheet" href="assets/css/screen.css" >

        <script src="assets/js/jquery-2.2.4.min.js" ></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="assets/js/bootstrap.min.js" ></script>
        <script src="assets/js/start.js"></script>
    </head>
    <body>
        <div class="jumbotron">
            <div class="container">
                <h3>Sugar Tool Render Manifest.</h3>
            </div>
        </div>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Upload Module</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="package" class="col-sm-2 control-label">Package:</label>
                            <span class="btn btn-default btn-file">
                                Browse Zip File<input type="file" name="package" id="package" onchange="$('#upload-file-info').html($(this).val());">
                            </span>
                            <span class='label label-info' id="upload-file-info"></span>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-warning">Render Manifest</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>
