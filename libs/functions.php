<?php

function isZip($file)
{
    // get the first 7 bytes
    $bytes = file_get_contents($file, FALSE, NULL, 0, 7);
    $ext = strtolower(substr($file, - 4));
    // ZIP magic number: none, though PK\003\004, PK\005\006 (empty archive), 
    // or PK\007\008 (spanned archive) are common.
    // http://en.wikipedia.org/wiki/ZIP_(file_format)
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
