<?php
$packages = scandir("deploy");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Download package</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <h2>Package List Deploy</h2>
            <p>All package to deploy to host.</p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Packge Size</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($packages) > 2) {
                        for ($i = 2; $i < count($packages); $i++) {
                            ?>
                            <tr>
                                <td><?php echo $packages[$i]; ?></td>
                                <td><?php echo filesize("deploy/" . $packages[$i]); ?></td>
                                <td>
                                    <a href="<?php echo "deploy/" . $packages[$i]; ?>" class="btn btn-small btn-primary"><i class="glyphicon glyphicon-download"></i></a>
                                    <a href="remove.php?f=<?php echo $packages[$i]; ?>" class="btn btn-small btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>

    </body>
</html>

