<?php

date_default_timezone_set('UTC');

/* $timeLimit = array(              // This is a tool for testing this file on its own.
    'start' => '2021-04-04',
    'length_0' => '34',
    'length_1' => 'm',
    'altLength_0' => '49',
    'altLength_1' => 'w',
    'ref' => '2020-04-20',
    'end' => ''
); */

if ($timeLimit['start']) {
    $startString = $timeLimit['start'];
    $startArray = explode('-', $startString);
    $lengthArray = array($timeLimit['length_0'], $timeLimit['length_1']);
    $altLengthArray = array($timeLimit['altLength_0'], $timeLimit['altLength_1']);
    $refString = $timeLimit['ref'];
    $refArray = explode('-', $refString);
    $endString = '';
    $endArray = array();
    $altEndString = '';
    $altEndArray = array();

    $errorsArrayTL = array();
    $extraYears = NULL;
    $holidays = array(
        0 => array('01', '01'),
        1 => array('05', '01'),
        2 => array('05', '08'),
        3 => array('07', '05'),
        4 => array('07', '06'),
        5 => array('09', '28'),
        6 => array('10', '28'),
        7 => array('11', '17'),
        8 => array('12', '24'),
        9 => array('12', '25'),
        10 => array('12', '26')
    ); // Doesn't include Easter Friday and Easter Monday

    if ($lengthArray[1] == 'm') {
        $endArray = $startArray;
        $endArray[1] = $endArray[1] + $lengthArray[0];
        $extraYears = floor($endArray[1] / 12);
        $endArray[1] = $endArray[1] - ($extraYears * 12);
        $endArray[0] = $endArray[0] + $extraYears;
        if ($endArray[2] > cal_days_in_month(CAL_GREGORIAN, $endArray[1], $endArray[0])) {
            $endArray[2] = cal_days_in_month(CAL_GREGORIAN, $endArray[1], $endArray[0]);
        }
        $endString = implode('-', $endArray);
    } elseif ($lengthArray[1] == 'y') {
        $endArray = $startArray;
        $endArray[0] = $endArray[0] + $lengthArray[0];
        $endString = implode('-', $endArray);
    } elseif ($lengthArray[1] == 'd') {
        $endString = gmdate('Y-m-d', (strtotime($startString)) + ($lengthArray[0] * 86400));
        $endArray = explode('-', $endString);
    } elseif ($lengthArray[1] == 'w') {
        $endString = gmdate('Y-m-d', (strtotime($startString)) + ($lengthArray[0] * 604800));
        $endArray = explode('-', $endString);
    } else {
        $errorsArrayTL[] = '$lengthArray[1] invalid value';
    }

    function checkWorkDay($endString, $endArray, $holidays)
    {
        if (gmdate('N', strtotime($endString)) >= 6) {
            return true;
        } elseif
        (
            (strtotime($endString) == strtotime($endArray[0] . '-03-21') + ((easter_days($endArray[0]) - 2) * 86400))
            or (strtotime($endString) == strtotime($endArray[0] . '-03-21') + ((easter_days($endArray[0]) + 1) * 86400))
        ) {
            return true;
        } else {
            foreach ($holidays as $value) {
                if (!array_diff_assoc(array($endArray[1], $endArray[2]), $value)) {
                    return true;
                }
            }
        }
    }

    while (checkWorkDay($endString, $endArray, $holidays)) {
        $endString = gmdate('Y-m-d', (strtotime($endString)) + 86400);
        $endArray = explode('-', $endString);
    }

    if (!($altLengthArray[0] or $altLengthArray[1])) {
    } elseif ($altLengthArray[0] and !$altLengthArray[1]) {
        $errorsArrayTL[] = 'only $altLengthArray[0]';
    } elseif (!$altLengthArray[0] and $altLengthArray[1]) {
        $errorsArrayTL[] = 'only $altLengthArray[1]';
    } elseif ($altLengthArray[0] and $altLengthArray[1]) {
        if ($altLengthArray[1] == 'm') {
            $altEndArray = $startArray;
            $altEndArray[1] = $altEndArray[1] + $altLengthArray[0];
            $extraYears = floor($altEndArray[1] / 12);
            $altEndArray[1] = $altEndArray[1] - ($extraYears * 12);
            $altEndArray[0] = $altEndArray[0] + $extraYears;
            if ($altEndArray[2] > cal_days_in_month(CAL_GREGORIAN, $altEndArray[1], $altEndArray[0])) {
                $altEndArray[2] = cal_days_in_month(CAL_GREGORIAN, $altEndArray[1], $altEndArray[0]);
            }
            $altEndString = implode('-', $altEndArray);
        } elseif ($altLengthArray[1] == 'y') {
            $altEndArray = $startArray;
            $altEndArray[0] = $altEndArray[0] + $altLengthArray[0];
            $altEndString = implode('-', $altEndArray);
        } elseif ($altLengthArray[1] == 'd') {
            $altEndString = gmdate('Y-m-d', (strtotime($startString)) + ($altLengthArray[0] * 86400));
            $altEndArray = explode('-', $altEndString);
        } elseif ($altLengthArray[1] == 'w') {
            $altEndString = gmdate('Y-m-d', (strtotime($startString)) + ($altLengthArray[0] * 604800));
            $altEndArray = explode('-', $altEndString);
        } else {
            $errorsArrayTL[] = '$altLengthArray[1] invalid value';
        }

        while (checkWorkDay($altEndString, $altEndArray, $holidays)) {
            $altEndString = gmdate('Y-m-d', (strtotime($altEndString)) + 86400);
            $altEndArray = explode('-', $altEndString);
        }

        if (strtotime($altEndString) > strtotime($endString)) {
            $endString = $altEndString;
            $endArray = explode('-', $endString);
        }
    }

    $timeLimit['end'] = $endString;
}
else
{}

/* echo '<pre>';
    print_r($timeLimit);
    print_r($startArray);
    print_r($lengthArray);
    print_r($refArray);
    print_r($endArray);
    print_r($errorsArrayTL);
    print_r($holidays);
echo '</pre>'; */

?>