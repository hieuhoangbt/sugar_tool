<?php

//WARNING: The contents of this file are auto-generated

/**
 * PARSE FIELD COMPLETION FOR TASK , QUEUE
 * @param string $completion
 * @return array
 */
function parsecompletionFunction($completion)
{
    $return = '';
    if (!empty($completion)) {
        $output = substr($completion, 1, -1);
        $return = explode('^,^', $output);
    }
    return $return;
}

/**
 * UNPARSE FIELD COMPLETION FOR TASK , QUEUE
 * @param array $completion
 * @return string
 */
function unparsecomletionFunction($completion)
{
    $return = '';
    if (!empty($completion) && is_array($completion)) {
        $return = '^';
        $return .= implode("^,^", $completion);
        $return .= '^';
    }
    return $return;
}

function getCurrentDate()
{
    $datetime = new DateTime();
    $targetTimezone = new DateTimeZone('GMT');
    $datetime->setTimeZone($targetTimezone);
    $startTime = $datetime->format('Y-m-d H:i:s');
    return $startTime;
}
