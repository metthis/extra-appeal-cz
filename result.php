<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

<?php

/* echo '<pre>';
    print_r($_POST);
echo '</pre>'; */

$reasonsArray = array(
    'fullFormInadm' => array(),
    'rect' => array(),
    'condFormInadm' => array()
);
$errorsArray = array();
$admissibleMatters = array(
    'form' => array(),
    'mat' => array()
);

$timeLimit = array(
    'start' => '',
    'length_0' => '',
    'length_1' => '',
    'altLength_0' => '',
    'altLength_1' => '',
    'ref' => '',
    'end' => ''
);

$matter = array();
$grounds = array();
$matAdmReasons = array(
    6 => 'The appellate court deviated from the Supreme Court’s stable case law.',
    7 => 'The Supreme Court has not yet dealt with this legal issue.',
    8 => 'The Supreme Court’s case law regarding this legal issue is not stable.',
    9 => 'The Supreme Court’s case law regarding this legal issue is stable but should be changed.'
);

foreach ($_POST AS $key => $value)
{$$key = $value;}
unset ($value);

if (!$appellateCourt)
{$errorsArray['appellateCourt empty'] = 'whether the court was acting as an appellate court.';}
elseif ($appellateCourt == 'n')
{$reasonsArray['fullFormInadm']['appellateCourt false'] = 'The court wasn\'t acting as an appellate court.';}

if (!$decisionFinal)
{$errorsArray['decisionFinal empty'] = 'whether the decision was final.';}
elseif ($decisionFinal == 'n')
{$reasonsArray['fullFormInadm']['decisionFinal false'] = 'The decision wasn\'t final.';}

if (!$endedProceedings)
{$errorsArray['endedProceedings empty'] = 'whether the decision ended the appellate court\'s proceedings.';}
elseif ($endedProceedings == 'n')
{$reasonsArray['fullFormInadm']['endedProceedings false'] = 'The decision didn\'t end the appellate court\'s proceedings.';}

if (!$verdict)
{$errorsArray['verdict empty'] = 'how the appellate court decided.';}
elseif ($verdict >= 1 AND $verdict <= 4)
{
    switch ($verdict)
    {
        case 1:
            $reasonsArray['fullFormInadm']['verdict 1'] = 'The appellate court quashed the decision of the court of first instance and referred the case back to it. Such decision can be challenged by action for nullity, not by extraordinary appeal.';
            break;
        case 2:
            $reasonsArray['fullFormInadm']['verdict 2'] = 'The appellate court rejected to admit an appeal. Such decision can be challenged by action for nullity, not by extraordinary appeal.';
            break;
        case 3:
            $reasonsArray['fullFormInadm']['verdict 3'] = 'The appellate court halted the appellate proceedings. Such decision can be challenged by action for nullity, not by extraordinary appeal.';
            break;
        case 4:
            $reasonsArray['fullFormInadm']['verdict 4'] = 'The appellate court upheld or changed a resolution of a court of first instance by which the court rejected to admit an appeal or an extraordinary appeal on grounds of it being filed too late. Such decision can be challenged by action for nullity, not by extraordinary appeal.';
            break;
    }
}

if (!$decisionDeliveryDate)
{
   $errorsArray['decisionDeliveryDate empty'] = 'when the decision was delivered to you.';
    if (!$correctingResolution)
    {$errorsArray['correctingResolution empty'] = 'whether there was a resolution that corrected the decision.';}
}
elseif (!$correctingResolution)
{$errorsArray['correctingResolution empty'] = 'whether there was a resolution that corrected the decision.';}
elseif ($correctingResolution == 'y')
{
    if (!$correctingResolutionDeliveryDate)
    {$errorsArray['correctingResolutionDeliveryDate empty'] = 'when the correcting resolution was delivered to you.';}
    else
    {$timeLimit['start'] = $correctingResolutionDeliveryDate;}
}
elseif ($correctingResolution == 'n')
{$timeLimit['start'] = $decisionDeliveryDate;}

if (!$advice)
{$errorsArray['advice empty'] = 'what the advice at the very end of the decision said.';}
elseif ($advice == 1)
{
    $timeLimit['length_1'] = 'm';
    if (!$adviceCourt)
    {$timeLimit['length_0'] = '2';}
    else
    {$timeLimit['length_0'] = '3';}
}
elseif ($advice == 2)
{
    if (!$advice2_1)
    {$errorsArray['advice2_1 empty'] = 'the time for which it is possible to file an extraordinary appeal according to the advice.';}
    else
    {
        $timeLimit['length_1'] = 'm';
        $timeLimit['altLength_0'] = $advice2_1;
        $timeLimit['altLength_1'] = $advice2_2;
        if (!$adviceCourt)
        {$timeLimit['length_0'] = '2';}
        else
        {$timeLimit['length_0'] = '3';}
    }
}
elseif ($advice >= 3 AND $advice <= 5)
{
    $timeLimit['length_0'] = '3';
    $timeLimit['length_1'] = 'm';
}

$timeLimit['ref'] = gmdate('Y-m-d');

include_once 'timelimits.php';

if (strtotime($timeLimit['ref']) > strtotime($timeLimit['end']))
{$reasonsArray['fullFormInadm']['past timelimit'] = 'The last day on which you could have filed the extraordinary appeal was '.gmdate('j F Y', strtotime($timeLimit['end'])).'.';}

if (!$representation)
{$errorsArray['representation empty'] = 'whether an attorney is going to represent you.';}
elseif ($representation == 'n')
{$reasonsArray['rect']['representation false'] = 'An attorney won\'t be representing you. The Supreme Court will ask you to rectify this by getting an attorney. If you don\'t do so, the extraordinary appeal won\'t be admissible.';}

if (!$money)
{$errorsArray['money empty'] = 'whether the decision directly concerns money.';}
elseif ($money == 'y')
{
    foreach ($matter as $value)
    {
        if ($value == 1)
        {$admissibleMatters['form']['money matter '.$value] = 'Money rooted in a consumer contract';}
        elseif ($value == 2)
        {$admissibleMatters['form']['money matter '.$value] = 'Money rooted in labour law';}
    }
    unset ($value);

    if (!(in_array('1', $matter, true) OR in_array('2', $matter, true)))
    {
        if ($moneyAmount > 50000)
        {$admissibleMatters['form']['money over 50000'] = 'Money over the value of 50,000 CZK';}
        else
        {$reasonsArray['condFormInadm']['low money'] = 'Money below the amount of 50,000 CZK';}
    }
}

if ($matter AND !in_array('1', $matter, true) AND !in_array('2', $matter, true))
{
    foreach ($matter as $value) {
        switch ($value) {
            case 3:
                $reasonsArray['condFormInadm']['matter 3'] = 'Family law (except matrimonial property law)';
                break;
            case 4:
                $reasonsArray['condFormInadm']['matter 4'] = 'Registered partnership';
                break;
            case 5:
                $reasonsArray['condFormInadm']['matter 5'] = 'Postponement of execution of a court decision';
                break;
            case 6:
                $reasonsArray['condFormInadm']['matter 6'] = 'Preliminary measure or order measure';
                break;
            case 7:
                $reasonsArray['condFormInadm']['matter 7'] = 'Expert fees or interpreter fees';
                break;
            case 8:
                $reasonsArray['condFormInadm']['matter 8'] = 'Possessory protection (a resolution, not a judgment)';
                break;
            case 9:
                $reasonsArray['condFormInadm']['matter 9'] = 'Compensation for costs of proceedings';
                break;
            case 10:
                $reasonsArray['condFormInadm']['matter 10'] = 'Obligation to pay a court fee or exemption from court fees';
                break;
            case 11:
                $reasonsArray['condFormInadm']['matter 11'] = 'Designation of an attorney';
                break;
        }
    }
}
unset ($value);

foreach ($grounds AS $value)
{
    switch ($value)
    {
        case 1:
            $admissibleMatters['mat']['matter grounds '.$value] = 'Party\'s procedural successor in the appellate proceedings';
            unset($reasonsArray['fullFormInadm']['endedProceedings false']);
            break;
        case 2:
            $admissibleMatters['mat']['matter grounds '.$value] = 'Passive substitution of a party during the appellate proceedings';
            unset($reasonsArray['fullFormInadm']['endedProceedings false']);
            break;
        case 3:
            $admissibleMatters['mat']['matter grounds '.$value] = 'Active substitution of a party during the appellate proceedings';
            unset($reasonsArray['fullFormInadm']['endedProceedings false']);
            break;
        case 4:
            $admissibleMatters['mat']['matter grounds '.$value] = 'Accession of a new party to the appellate proceedings';
            unset($reasonsArray['fullFormInadm']['endedProceedings false']);
            break;
        case 5:
            $reasonsArray['condFormInadm']['grounds facts'] = 'You want to argue that the appellate court got the facts wrong. Such arguments are inadmissible because the Supreme Court only reviews points of law.';
            break;
    }
}
unset ($value);

if (!$otherMatter)
{$errorsArray['otherMatter empty'] = 'whether the decision directly concerns any other matter.';}
elseif ($otherMatter == 'y')
{$admissibleMatters['form']['other matter'] = 'Some other admissible matter';}

/* echo '<br /><br />errorsArray, reasonsArray, admissibleMatters:<br /><pre>';
    print_r($errorsArray);
    print_r($reasonsArray);
    print_r($admissibleMatters);
echo '</pre>'; */

echo '<div class="tricolour" id="white"></div>';
echo '<div class="tricolour" id="red"></div>';
echo '<div class="tricolour" id="blue"></div>';

if ($errorsArray)
{
    echo '<h1>The evaluation cannot be completed.</h1>
    <p>You did\'t specify:</p>
    <ul>';
    foreach ($errorsArray AS $value)
    {
        echo '<li>'.$value.'</li>';
    }
    echo '</ul>';
}
else {
    if ($reasonsArray['fullFormInadm'])
    {
        echo '<h1>Your extraordinary appeal is inadmissible.</h1>
    <p>These are the reasons:</p>
    <ul>';
        foreach ($reasonsArray['fullFormInadm'] as $value) {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
        if ($reasonsArray['rect'] or $reasonsArray['condFormInadm']) {
            echo '<p>Other issues with your extraordinary appeal are these:</p>
    <ul>';
            foreach ($reasonsArray['rect'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            foreach ($reasonsArray['condFormInadm'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        }
    } elseif ($reasonsArray['condFormInadm'] and !$admissibleMatters['form']) {
        echo '<h1>Your extraordinary appeal is inadmissible.</h1>
    <p>These are the inadmissible matters:</p>
    <ul>';
        foreach ($reasonsArray['condFormInadm'] as $value) {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
        if ($reasonsArray['rect']) {
            echo '<p>Other issues with your extraordinary appeal are these:</p>
    <ul>';
            foreach ($reasonsArray['rect'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        }
    } elseif ($admissibleMatters['mat']) {
        echo '<h1>Your extraordinary appeal is admissible</h1>
    <h2>You have until ' . gmdate('j F Y', strtotime($timeLimit['end'])) . ' to file it.</h2>
    <p>This is the admissible matter:</p>
    <ul>';
        foreach ($admissibleMatters['mat'] as $value) {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
        if ($reasonsArray['rect']) {
            echo '<p>However, there are these issues with your extraordinary appeal:</p>
        <ul>';
            foreach ($reasonsArray['rect'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        }
    } elseif ($admissibleMatters['form'] and $reasonsArray['condFormInadm']) {
        if
        (
            in_array('6', $grounds, true)
            or in_array('7', $grounds, true)
            or in_array('8', $grounds, true)
            or in_array('9', $grounds, true)
        ) {
            echo '<h1>Your extraordinary appeal is partially admissible.</h1>
        <h2>You have until ' . gmdate('j F Y', strtotime($timeLimit['end'])) . ' to file it.</h2>
    <p>These are the admissible matters:</p>
    <ul>';
            foreach ($admissibleMatters['form'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            echo '<p>You chose the following arguments, about which you\'ll have to convince the Supreme Court in order to succeed:</p>
        <ul>';
            foreach ($grounds as $value) {
                if ($value >= 6 and $value <= 9) {
                    echo '<li>' . $matAdmReasons[$value] . '</li>';
                }
            }
            echo '</ul>';
            echo '<p>These are the inadmissible matters:</p>
    <ul>';
            foreach ($reasonsArray['condFormInadm'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            if ($reasonsArray['rect']) {
                echo '<p>Other issues with your extraordinary appeal are these:</p>
        <ul>';
                foreach ($reasonsArray['rect'] as $value) {
                    echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
            }
        } else {
            echo '<h1>Your extraordinary appeal could be partially admissible.</h1>
    <h2>You could file it until ' . gmdate('j F Y', strtotime($timeLimit['end'])) . '</h2>
    <p>These are the potentially admissible matters:</p>
    <ul>';
            foreach ($admissibleMatters['form'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            echo '<p>However, you\'d have to convince the Supreme Court about at least one of the following arguments in order to succeed:</p>';
            echo '<ul>';
            foreach ($matAdmReasons as $value) {
                echo '<li>$value</li>';
            }
            echo '</ul>';
            echo '<p>These are the inadmissible matters:</p>
    <ul>';
            foreach ($reasonsArray['condFormInadm'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            if ($reasonsArray['rect']) {
                echo '<p>Other issues with your extraordinary appeal are these:</p>
        <ul>';
                foreach ($reasonsArray['rect'] as $value) {
                    echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
            }

        }
    } elseif ($admissibleMatters['form'] and !$reasonsArray['condFormInadm']) {
        if
        (
            in_array('6', $grounds, true)
            or in_array('7', $grounds, true)
            or in_array('8', $grounds, true)
            or in_array('9', $grounds, true)
        ) {
            echo '<h1>Your extraordinary appeal is admissible.</h1>
    <h2>You have until ' . gmdate('j F Y', strtotime($timeLimit['end'])) . ' to file it.</h2>
    <p>These are the admissible matters:</p>
    <ul>';
            foreach ($admissibleMatters['form'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            echo '<p>You chose the following arguments, about which you\'ll have to convince the Supreme Court in order to succeed:</p>
        <ul>';
            foreach ($grounds as $value) {
                if ($value >= 6 and $value <= 9) {
                    echo '<li>' . $matAdmReasons[$value] . '</li>';
                }
            }
            echo '</ul>';
            if ($reasonsArray['rect']) {
                echo '<p>However, there are these issues with your extraordinary appeal:</p>
        <ul>';
                foreach ($reasonsArray['rect'] as $value) {
                    echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
            }
        } else {
            echo '<h1>Your extraordinary appeal could be admissible.</h1>
    <h2>You could file it until ' . gmdate('j F Y', strtotime($timeLimit['end'])) . '.</h2>
    <p>These are the admissible matters:</p>
    <ul>';
            foreach ($admissibleMatters['form'] as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
            echo '<p>However, you\'d have to convince the Supreme Court about at least one of the following arguments in order to succeed:</p>';
            echo '<ul>';
            foreach ($matAdmReasons as $value) {
                echo '<li>$value</li>';
            }
            echo '</ul>';
            if ($reasonsArray['rect']) {
                echo '<p>Also, there are these issues with your extraordinary appeal:</p>
        <ul>';
                foreach ($reasonsArray['rect'] as $value) {
                    echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
            }
        }
    }
}


?>

</body>

</html>
