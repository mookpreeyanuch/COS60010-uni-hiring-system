<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");
include_once("db-conn.php");
include_once("create-table.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // var_dump($_POST);

    $errorArray = [];

    if (issetNotEmpty($_POST["jobref"])) {
        if (strlen($_POST["jobref"]) == 5) {
            $jobref = sanitiseInput($_POST["jobref"]);
        } else {
            $errorArray[] = "Job reference number: exactly 5 alphanumeric characters.";
        }
    } else {
        $errorArray[] = "Job reference number: required";
    }

    if (issetNotEmpty($_POST["firstname"])) {
        if (strlen($_POST["firstname"]) <= 20 && preg_match("/^[A-Za-z ]*$/", $_POST["firstname"])) {
            $firstname = sanitiseInput($_POST["firstname"]);
        } else {
            $errorArray[] = "First name: max 20 alpha characters.";
        }
    } else {
        $errorArray[] = "First name: required.";
    }

    if (issetNotEmpty($_POST["lastname"])) {
        if (strlen($_POST["lastname"]) <= 20 && preg_match("/^[A-Za-z ]*$/", $_POST["lastname"])) {
            $lastname = sanitiseInput($_POST["lastname"]);
        } else {
            $errorArray[] = "Last name: max 20 alpha characters.";
        }
    } else {
        $errorArray[] = "Last name: required.";
    }

    if (issetNotEmpty($_POST["date_of_birth"])) {
        $age = calculateAge($_POST["date_of_birth"]);
        if ($age >= 15 && $age <= 80  && preg_match("/\d{2}\/\d{2}\/\d{4}/", $_POST["date_of_birth"])) {
            $dateOfBirth = sanitiseInput($_POST["date_of_birth"]);
        } else {
            $errorArray[] = "Date of birth: dd/mm/yyyy between 15 and 80.";
        }
    } else {
        $errorArray[] = "Date of birth: required.";
    }

    if (issetNotEmpty($_POST["gender"])) {
        $gender = sanitiseInput($_POST["gender"]);
    } else {
        $errorArray[] = "Gender: required.";
    }

    if (issetNotEmpty($_POST["street"])) {
        if (strlen($_POST["street"]) <= 40) {
            $street = sanitiseInput($_POST["street"]);
        } else {
            $errorArray[] = "Street Address: max 40 characters.";
        }
    } else {
        $errorArray[] = "Street Address: required.";
    }

    if (issetNotEmpty($_POST["suburb"])) {
        if (strlen($_POST["suburb"]) <= 40) {
            $suburb = sanitiseInput($_POST["suburb"]);
        } else {
            $errorArray[] = "Suburb/town: max 40 characters.";
        }
    } else {
        $errorArray[] = "Suburb/town: required.";
    }

    if (issetNotEmpty($_POST["state"])) {
        if (in_array($_POST["state"], $stateArray)) {
            $state = sanitiseInput($_POST["state"]);
        } else {
            $errorArray[] = "State: One of VIC, NSW, QLD, NT, WA, SA, TAS, ACT.";
        }
    } else {
        $errorArray[] = "State: required.";
    }

    if (issetNotEmpty($_POST["postcode"])) {
        $prefixPostcode = substr($_POST["postcode"], 0, 1);
        $currentStatePostcode = array_key_exists($_POST["state"], $statePrefixArray) ? $statePrefixArray[$_POST["state"]] : [];
        if (strlen($_POST["postcode"]) == 4 && in_array($prefixPostcode, $currentStatePostcode)) {
            $postcode = sanitiseInput($_POST["postcode"]);
        } else {
            $errorArray[] = "Postcode: exactly 4 digits - matches state.";
        }
    } else {
        $errorArray[] = "Postcode: required.";
    }

    if (issetNotEmpty($_POST["email"])) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = sanitiseInput($_POST["email"]);
        } else {
            $errorArray[] = "Email address: validate format.";
        }
    } else {
        $errorArray[] = "Email address: required.";
    }

    if (issetNotEmpty($_POST["phone"])) {
        if (preg_match("/[\d ]{8,12}/", $_POST["phone"])) {
            $phone = sanitiseInput($_POST["phone"]);
        } else {
            $errorArray[] = "Phone number: 8 to 12 digits, or spaces.";
        }
    } else {
        $errorArray[] = "Phone number: required.";
    }

    $skills = [];
    $isOtherSkillCheck = false;
    if (isset($_POST["skills"]) && is_array($_POST["skills"])) {
        foreach ($_POST["skills"] as $skillItem) {
            $skills[] = sanitiseInput($skillItem);
            if ($skillItem == "skill6") {
                $isOtherSkillCheck = true;
            }
        }
    }

    $otherSkills = null;
    if (isset($_POST["other_skills"])) {
        $otherSkills = sanitiseInput($_POST["other_skills"]);
    }
    if ($isOtherSkillCheck) {
        if (issetNotEmpty($_POST["other_skills"])) {
            
        } else {
            $errorArray[] = "Other skills: not empty if check box selected.";
        }
    } else {
        $otherSkills = null;
    }

    // If have error, error page should be displayed to the user
    if (count($errorArray) > 0) {
        $_SESSION["flash_validate"] = $errorArray;

        redirect("apply.php", false);
    }

    $availability = [];
    if (isset($_POST["availability"]) && is_array($_POST["availability"])) {
        foreach ($_POST["availability"] as $availabilityItem) {
            $availability[] = sanitiseInput($availabilityItem);
        }
    }

    $item = [
        "type" => "insert",
        "table" => "eoi",
        "columnList" => [
            "jobref" => $jobref,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "date_of_birth" => dateToDbFormat($dateOfBirth),
            "gender" => $gender,
            "street" => $street,
            "suburb" => $suburb,
            "state" => $state,
            "postcode" => $postcode,
            "email" => $email,
            "phone" => $phone,
            "skills" => arrayToDbFormat($skills),
            "other_skills" => $otherSkills,
            "availability" => arrayToDbFormat($availability),
        ],
    ];

    $insertEoiQuery = generateQuery($item);

    if (mysqli_query($dbConn, $insertEoiQuery)) {
        $eoiNumber = mysqli_insert_id($dbConn);
        $_SESSION["flash_success"] = $eoiNumber;

        redirect("apply.php", false);
    } else {
        die("Error: " . $insertEoiQuery . "<br>" . mysqli_error($dbConn));
    }

    mysqli_close($dbConn);
    exit();
} else {
    redirect("apply.php", false);
}
?>