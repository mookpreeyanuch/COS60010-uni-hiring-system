<?php

$jobrefArray = [
    "ICT01",
    "ICT02",
];

$stateArray = [
    "VIC",
    "NSW",
    "QLD",
    "NT",
    "WA",
    "SA",
    "TAS",
    "ACT",
];

$statePrefixArray = [
    "VIC" => [3, 8],
    "NSW" => [1, 2],
    "QLD" => [4, 9],
    "NT" => [0],
    "WA" => [6],
    "SA" => [5],
    "TAS" => [7],
    "ACT" => [0],
];

$skillsArray = [
    "skill1" => "Cloud Arcitecture",
    "skill2" => "HTML",
    "skill3" => "JavaScript",
    "skill4" => "PHP",
    "skill5" => "MySQL",
    "skill6" => "Other",
];

$availabilityArray = [
    "mon1" => "Monday-Morning",
    "mon2" => "Monday-Afternoon",
    "mon3" => "Monday-Evening",
    "tue1" => "Tueday-Morning",
    "tue2" => "Tueday-Afternoon",
    "tue3" => "Tueday-Evening",
    "wed1" => "Wednesday-Morning",
    "wed2" => "Wednesday-Afternoon",
    "wed3" => "Wednesday-Evening",
    "thu1" => "Thursday-Morning",
    "thu2" => "Thursday-Afternoon",
    "thu3" => "Thursday-Evening",
    "fri1" => "Friday-Morning",
    "fri2" => "Friday-Afternoon",
    "fri3" => "Friday-Evening",
];

function redirect($url, $permanent = false) {
    header("Location: " . $url, true, $permanent ? 301 : 302);
    exit();
}

function sanitiseInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function dateToDbFormat($date) {
    $dateArray = explode("/", $date);
    return "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]}";
}

function dbToDateFormat($date) {
    $dateArray = explode("-", $date);
    return "{$dateArray[2]}/{$dateArray[1]}/{$dateArray[0]}";
}

function arrayToDbFormat($array) {
    if (is_array($array)) {
        return implode(",", $array);
    }
    return null;
}

function getSkillsTxt($skills) {
    $array = [];
    $skillsArray = [
        "skill1" => "Doctoral degree",
        "skill2" => "Masters degree",
        "skill3" => "Graduate diploma",
        "skill4" => "Graduate certificate",
        "skill5" => "Bachelor degree",
        "skill6" => "Other",
    ];

    if (! empty($skills)) {
        $skillsExplode = explode(",", $skills);
        if (! empty($skillsExplode) && is_array($skillsExplode)) {
            foreach ($skillsExplode as $skillsItem) {
                if (array_key_exists($skillsItem, $skillsArray)) {
                    $array[] = $skillsArray[$skillsItem];
                }
            }
        }
        return implode(", ", $array);
    }
    return null;
}

function getAvailabilityTxt($availability) {
    $array = [];
    $availabilityArray = [
        "mon1" => "Monday-Morning",
        "mon2" => "Monday-Afternoon",
        "mon3" => "Monday-Evening",
        "tue1" => "Tueday-Morning",
        "tue2" => "Tueday-Afternoon",
        "tue3" => "Tueday-Evening",
        "wed1" => "Wednesday-Morning",
        "wed2" => "Wednesday-Afternoon",
        "wed3" => "Wednesday-Evening",
        "thu1" => "Thursday-Morning",
        "thu2" => "Thursday-Afternoon",
        "thu3" => "Thursday-Evening",
        "fri1" => "Friday-Morning",
        "fri2" => "Friday-Afternoon",
        "fri3" => "Friday-Evening",
    ];

    if (! empty($availability)) {
        $availabilityExplode = explode(",", $availability);
        if (! empty($availabilityExplode) && is_array($availabilityExplode)) {
            foreach ($availabilityExplode as $availabilityItem) {
                if (array_key_exists($availabilityItem, $availabilityArray)) {
                    $array[] = $availabilityArray[$availabilityItem];
                }
            }
        }
        return implode(", ", $array);
    }
    return null;
}


function issetNotEmpty($data) {
    if (isset($data) && $data != "") {
        return true;
    }
    return false;
}

function generateQuery($item) {
    $type = $item["type"];
    if ($type == "insert") {
        return generateInsertQuery($item);
    } else if ($type == "update") {
        return generateUpdateQuery($item);
    }
}

function generateInsertQuery($item) {
    $tableTxt = $item["table"];
    $columnTxt = "";
    $valueTxt = "";

    $item["columnList"]["created_at"] = date("Y-m-d H:i:s");
    $item["columnList"]["updated_at"] = date("Y-m-d H:i:s");

    foreach ($item["columnList"] as $column => $value) {
        $columnTxt .= ", `{$column}`";
        if (is_null($value)) {
            $valueTxt .= ", NULL";
        } else {
            $valueTxt .= ", \"{$value}\"";
        }
    }

    $columnTxt = trim($columnTxt, ", ");
    $valueTxt = trim($valueTxt, ", ");

    return "INSERT INTO `{$tableTxt}` ({$columnTxt}) VALUES ({$valueTxt});";
}

function generateUpdateQuery($item) {
    $tableTxt = $item["table"];
    $id = $item["id"];
    $setTxt = [];

    $item["columnList"]['updated_at'] = date('Y-m-d H:i:s');

    foreach ($item["columnList"] as $column => $value) {
        if (is_null($value)) {
            $setTxt[] = "`{$column}` = NULL";
        } else {
            $setTxt[] = "`{$column}` = \"{$value}\"";
        }
    }

    $setTxt = implode(", ", $setTxt);

    return "UPDATE `{$tableTxt}` SET {$setTxt} WHERE id = {$id};";
}

// birthDate format dd/mm/YYYY
function calculateAge($birthDate) {
    // explode the date to get day, month and year
    $birthDateArray = explode("/", $birthDate);
    // get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDateArray[1], $birthDateArray[0], $birthDateArray[2]))) > date("md")
        ? ((date("Y") - $birthDateArray[2]) - 1)
        : (date("Y") - $birthDateArray[2]));
    return $age;
}

function checkLogin() {
    return (isset($_SESSION["id"], $_SESSION["logged_in"]) && $_SESSION["id"] > 0 && $_SESSION["logged_in"]);
}