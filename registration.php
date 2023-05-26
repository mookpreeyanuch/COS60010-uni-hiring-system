<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");

// DB connect
$dbConn = @mysqli_connect($host, $user, $pwd, $sqlDb);

// Check connection
if ($dbConn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_SESSION['flash_success'])) {
	$flashSuccess = $_SESSION['flash_success'];
	unset($_SESSION['flash_success']);
}

if (isset($_SESSION['flash_validate'])) {
	$flashValidate = $_SESSION['flash_validate'];
	unset($_SESSION['flash_validate']);
}

if (checkLogin()) {
    redirect("manage.php", false);
} else {
    $checkAdminTableExistsQuery = "SHOW TABLES LIKE \"admin\"";
    $checkAdminTableExists = mysqli_query($dbConn, $checkAdminTableExistsQuery);
    $checkAdminTableExistsNum = mysqli_num_rows($checkAdminTableExists);
    // var_dump("$checkAdminTableExistsNum: " . $checkAdminTableExistsNum);

    if ($checkAdminTableExistsNum == 0) { // admin table don't exists
        $createAdminTableQuery = "CREATE TABLE `admin` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL,
            `username` VARCHAR(20) NOT NULL,
            `password` VARCHAR(32) NOT NULL,
            `name` VARCHAR(40) NOT NULL,
            `email` VARCHAR(40) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `username` (`username` ASC));";
        $createAdminTable = mysqli_query($dbConn, $createAdminTableQuery);
        // var_dump("$createAdminTable: " . $createAdminTable);
    }

    if (! empty($_POST["action"]) && $_POST["action"] == "insert") {
        $errorArray = [];

        if (issetNotEmpty($_POST["username"])) {
            if (strlen($_POST["username"]) <= 20 && preg_match("/^[A-Za-z0-9]*$/", $_POST["username"])) {
                $username = sanitiseInput($_POST["username"]);

                $selectAdminQuery = "SELECT * FROM `admin` WHERE `username` = \"{$username}\" LIMIT 1;";
                // var_dump($selectAdminQuery);
                $selectAdminResult = mysqli_query($dbConn, $selectAdminQuery);
                $checkAdminNum = mysqli_num_rows($selectAdminResult);

                if ($checkAdminNum) {
                    $errorArray[] = "Username: is already in use.";
                } else {
                    
                }
            } else {
                $errorArray[] = "Username: max 20 alpha numeric characters.";
            }
        } else {
            $errorArray[] = "Username: required.";
        }

        if (issetNotEmpty($_POST["password"])) {
            if (strlen($_POST["password"]) >= 6 && strlen($_POST["password"]) <= 20 && preg_match("/^[A-Za-z0-9]*$/", $_POST["password"])) {
                $password = sanitiseInput($_POST["password"]);
            } else {
                $errorArray[] = "Password: min 6 max 20 alpha numeric characters.";
            }
        } else {
            $errorArray[] = "Password: required.";
        }

        if (issetNotEmpty($_POST["name"])) {
            if (strlen($_POST["name"]) <= 20 && preg_match("/^[A-Za-z0-9]*$/", $_POST["name"])) {
                $name = sanitiseInput($_POST["name"]);

                $selectAdminQuery = "SELECT * FROM `admin` WHERE `name` = \"{$name}\" LIMIT 1;";
                // var_dump($selectAdminQuery);
                $selectAdminResult = mysqli_query($dbConn, $selectAdminQuery);
                $checkAdminNum = mysqli_num_rows($selectAdminResult);

                if ($checkAdminNum) {
                    $errorArray[] = "Name: is already in use.";
                } else {
                    
                }
            } else {
                $errorArray[] = "Name: max 20 alpha numeric characters.";
            }
        } else {
            $errorArray[] = "Name: required.";
        }

        if (issetNotEmpty($_POST["email"])) {
            if (strlen($_POST["email"]) <= 40 && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $_POST["email"])) {
                $email = sanitiseInput($_POST["email"]);

                $selectAdminQuery = "SELECT * FROM `admin` WHERE `email` = \"{$email}\" LIMIT 1;";
                // var_dump($selectAdminQuery);
                $selectAdminResult = mysqli_query($dbConn, $selectAdminQuery);
                $checkAdminNum = mysqli_num_rows($selectAdminResult);

                if ($checkAdminNum) {
                    $errorArray[] = "Email: is already in use.";
                } else {
                    
                }
            } else {
                $errorArray[] = "Email: max 40 alpha numeric characters.";
            }
        } else {
            $errorArray[] = "Email: required.";
        }

        // If have error, error page should be displayed to the user
        if (count($errorArray) > 0) {
            $_SESSION["flash_validate"] = $errorArray;

            redirect("registration.php", false);
        }

        $item = [
            "type" => "insert",
            "table" => "admin",
            "columnList" => [
                "username" => $username,
                "password" => md5($password),
                "name" => $name,
                "email" => $email,
            ],
        ];
    
        $insertAdminQuery = generateQuery($item);
    
        if (mysqli_query($dbConn, $insertAdminQuery)) {
            $adminId = mysqli_insert_id($dbConn);
            $_SESSION["flash_success"] = $adminId;
    
            redirect("registration.php", false);
        } else {
            die("Error: " . $insertEoiQuery . "<br>" . mysqli_error($dbConn));
        }
    }
}

mysqli_close($dbConn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Registration">
    <meta name="keywords" content="registration">
    <meta name="author" content="Palida Parichayawong">

    <title>Registration</title>

    <!-- References to external CSS files -->
    <link href="styles/style.css" rel="stylesheet">
</head>
<body>

	<?php include_once("header.inc"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col">

                <?php
                if (checkLogin()) {
                ?>

				

                <?php
                } else {
                ?>

                <?php
                if (isset($flashSuccess)) {
					echo "<div class=\"alert alert-success mt-2\" role=\"alert\">";
					echo "<h4 class=\"alert-heading mt-0 mb-0\">Success</h4>";
					echo "Successfully registered. ID is <strong>{$flashSuccess}</strong>";
					echo "</div>";
				}

				if (isset($flashValidate) && is_array($flashValidate) && count($flashValidate) > 0) {
					echo "<div class=\"alert alert-danger mt-2\" role=\"alert\">";
					echo "<h4 class=\"alert-heading mt-0 mb-0\">Validate</h4>";
					echo "<ul class=\"mb-0\">";
					foreach ($flashValidate as $flashValidateItem) {
						echo "<li>{$flashValidateItem}</li>";
					}
					echo "</ul>";
					echo "</div>";
				}
				?>

                <h1>Registration</h1>

                <form method="post" action="registration.php" id="registration-form">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" maxlength="20" required pattern="[A-Za-z0-9]{1,20}" title="max 20 alpha numeric characters">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" maxlength="20" required pattern="[A-Za-z0-9]{6,20}" title="min 6 max 20 alpha numeric characters">
					</div>

                    <div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" maxlength="20" required pattern="[A-Za-z0-9]{1,20}">
					</div>

                    <div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" maxlength="255" required pattern="[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+">
					</div>

                    <input type="hidden" name="action" value="insert">
						
					<button type="submit" class="btn btn-primary">Apply</button>
					<button type="reset" class="btn btn-light">Reset Form</button>
                    <a href="manage.php" class="btn btn-light">Login</a>
				</form>

                <?php
                }
                ?>

			</div>
		</div>
	</div>

	<?php include_once("footer.inc"); ?>
	
</body>
</html>
