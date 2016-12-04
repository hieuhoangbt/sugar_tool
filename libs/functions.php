<?php

function isZip($file)
{
    $bytes = file_get_contents($file, FALSE, NULL, 0, 7);
    $ext = strtolower(substr($file, - 4));
    if ($ext == '.zip' && substr($bytes, 0, 2) == 'PK') {
        return TRUE;
    }

    return FALSE;
}

function createCopyArray($path, $tmpPath = "")
{
    global $arr, $langArr;
    $dirs = scandir($path);
    foreach ($dirs as $dir) {
        if ($dir == "." || $dir == "..") {
            continue;
        }
        $currentPath = $path . "/" . $dir;
        if (is_file($currentPath)) {
            $a = $tmpPath . "/" . $dir;
            $from = "<basepath>/SugarModules" . $a;
            if (!in_array($from, $langArr)) {
                $to = $a;
                $tmp = array(
                    "from" => $from,
                    "to" => substr($to, 1, strlen($to))
                );
                $arr[count($arr)] = $tmp;
            }
        } else {
            $tmpPath1 = $tmpPath . "/" . $dir;
            createCopyArray($currentPath, $tmpPath1);
        }
    }
}
