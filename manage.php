<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");
include_once("db-conn.php");
include_once("create-table.php");

if (isset($_SESSION['flash_login_success'])) {
	$flashLoginSuccess = $_SESSION['flash_login_success'];
	unset($_SESSION['flash_login_success']);
}

if (isset($_SESSION['flash_login_fail'])) {
	$flashLoginFail = $_SESSION['flash_login_fail'];
	unset($_SESSION['flash_login_fail']);
}

if (checkLogin()) {
    $whereTxt = "";
    if (! empty($_GET["action"]) && $_GET["action"] == "search") {
        if (! empty($_GET["jobref"])) {
            $jobrefSelected = $_GET["jobref"];

            if (! empty($whereTxt)) {
                $whereTxt .= "AND jobref = \"{$jobrefSelected}\"";
            } else {
                $whereTxt .= "WHERE jobref = \"{$jobrefSelected}\"";
            }
        }
        if (isset($_GET["firstname"]) && $_GET["firstname"] != "") {
            $firstnameSearch = $_GET["firstname"];

            if (! empty($whereTxt)) {
                $whereTxt .= "AND firstname LIKE \"%{$firstnameSearch}%\"";
            } else {
                $whereTxt .= "WHERE firstname LIKE \"%{$firstnameSearch}%\"";
            }
        }
        if (isset($_GET["lastname"]) && $_GET["lastname"] != "") {
            $lastnameSearch = $_GET["lastname"];

            if (! empty($whereTxt)) {
                $whereTxt .= "AND lastname LIKE \"%{$lastnameSearch}%\"";
            } else {
                $whereTxt .= "WHERE lastname LIKE \"%{$lastnameSearch}%\"";
            }
        }
    } else if (! empty($_GET["action"]) && $_GET["action"] == "delete") {
        if (! empty($_GET["jobref"])) {
            $jobrefSelected = $_GET["jobref"];

            $deleteEoiQuery = "DELETE FROM `eoi` WHERE `jobref` = \"{$jobrefSelected}\";";

            $deleteEoiResult = mysqli_query($dbConn, $deleteEoiQuery);

            redirect("manage.php", false);
        }
    } else if (! empty($_GET["action"]) && $_GET["action"] == "change") {
        if (! empty($_GET["EOInumber"]) && ! empty($_GET["status"])) {
            $now = date("Y-m-d H:i:s");
            $EOInumber = $_GET["EOInumber"];
            $status = $_GET["status"];

            $updateEoiQuery = "UPDATE `eoi` SET `updated_at` = \"{$now}\", `status` = \"{$status}\" WHERE `EOInumber` = {$EOInumber};";

            $updateEoiResult = mysqli_query($dbConn, $updateEoiQuery);

            redirect("manage.php", false);
        }
    } else if (! empty($_POST["post_action"]) && $_POST["post_action"] == "delete-checkbox") {
        if (! empty($_POST["eoi_number"])) {
            $eoiNumberList = $_POST["eoi_number"];
            $eoiNumberImplode = implode(", ", $eoiNumberList);

            $deleteEoiQuery = "DELETE FROM `eoi` WHERE `EOInumber` IN ({$eoiNumberImplode});";

            $deleteEoiResult = mysqli_query($dbConn, $deleteEoiQuery);

            redirect("manage.php", false);
        }

        redirect("manage.php", false);
    }

    $selectEoiQuery = "SELECT * FROM `eoi` {$whereTxt} ORDER BY `EOInumber` ASC;";
    // var_dump($selectEoiQuery);
    $selectEoiResult = mysqli_query($dbConn, $selectEoiQuery);
} else {
    if (! empty($_POST["action"]) && $_POST["action"] == "login") {
        $username = sanitiseInput($_POST["username"]);
        $password = sanitiseInput($_POST["password"]);

        $selectAdminQuery = "SELECT * FROM `admin` WHERE `username` = \"{$username}\" LIMIT 1;";
        // var_dump($selectAdminQuery);
        $selectAdminResult = mysqli_query($dbConn, $selectAdminQuery);
        $checkAdminNum = mysqli_num_rows($selectAdminResult);

        if ($checkAdminNum) {
            $admin = mysqli_fetch_object($selectAdminResult);
            
            if ($admin->password == md5($password)) {
                $_SESSION["id"] = $admin->id;
                $_SESSION["username"] = $admin->username;
                $_SESSION["logged_in"] = true;

                $_SESSION["flash_login_success"] = true;

                unset($_SESSION["flash_login_attempt"]);
                unset($_SESSION["flash_login_attempt_again"]);

                redirect("manage.php", false);
            } else {
                $_SESSION["flash_login_attempt"] = (isset($_SESSION["flash_login_attempt"]) ? $_SESSION["flash_login_attempt"] : 0) + 1;
                if ($_SESSION["flash_login_attempt"] >= 3) {
                    $_SESSION["flash_login_attempt_again"] = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                }
                $_SESSION["flash_login_fail"] = true;

                redirect("manage.php", false);
            }
        } else {
            $_SESSION["flash_login_attempt"] = (isset($_SESSION["flash_login_attempt"]) ? $_SESSION["flash_login_attempt"] : 0) + 1;
            if ($_SESSION["flash_login_attempt"] >= 3) {
                $_SESSION["flash_login_attempt_again"] = date("Y-m-d H:i:s", strtotime("+5 minutes"));
            }
            $_SESSION["flash_login_fail"] = true;

            redirect("manage.php", false);
        }
    }
}

mysqli_close($dbConn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="HR manager">
    <meta name="keywords" content="hr manager">
    <meta name="author" content="Palida Parichayawong">

    <title>HR manager</title>

    <!-- References to external CSS files -->
    <link href="styles/style.css" rel="stylesheet">

    <script src="scripts/manage.js"></script>
</head>
<body>

	<?php include_once("header.inc"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col">

                <?php
                if (checkLogin()) {

                    if (isset($flashLoginSuccess)) {
                        echo "<div class=\"alert alert-success mt-2\" role=\"alert\">";
                        echo "<h4 class=\"alert-heading mt-0 mb-0\">Login succcess</h4>";
                        echo "</div>";
                    }
                ?>

				<h1>HR manager</h1>
                    <div class="col-6">
                        <form method="get" action="manage.php">
                            <div class="row">
                                <div class="col-12">
                                    <label>Search by name:</label> 
                                </div>
                                <div class="col-4">
                                    <input type="text" name="firstname" value="<?php echo (isset($_GET["firstname"]) ? $_GET["firstname"] : "") ?>" class="form-control" maxlength="20" placeholder="First name">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="lastname" value="<?php echo (isset($_GET["lastname"]) ? $_GET["lastname"] : "") ?>" class="form-control" maxlength="20" placeholder="Last name">
                                </div>
                                <div class="col-4">
                                    <input type="hidden" name="action" value="search">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                <form method="post" action="manage.php" id="delete-checkbox-form">
                    <input type="hidden" name="post_action" value="delete-checkbox">
                    <table class="table table-bordered text-size12">
                        <thead>
                            <tr>
                                <th><button type="submit" class="btn btn-danger">Delete</button></th>
                                <th>EOInumber</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Job ref</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Date of birth</th>
                                <th>Gender</th>
                                <th>Street Address</th>
                                <th>Suburb/town</th>
                                <th>State</th>
                                <th>Postcode</th>
                                <th>Email address</th>
                                <th>Phone number</th>
                                <th>Qualifications</th>
                                <th>Other Qualifications</th>
                                <th>Availability</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($selectEoiResult) > 0) {
                                while($row = mysqli_fetch_assoc($selectEoiResult)) {
                                    $changeFormId = "change-form-{$row["EOInumber"]}";
                            ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="eoi_number[]" value="<?php echo $row["EOInumber"]; ?>"></td>
                                    <td class="text-center"><?php echo $row["EOInumber"]; ?></td>
                                    <td class="text-center"><?php echo $row["created_at"]; ?></td>
                                    <td class="text-center"><?php echo $row["updated_at"]; ?></td>
                                    <td class="text-center"><?php echo $row["jobref"]; ?></td>
                                    <td class="text-center"><?php echo $row["firstname"]; ?></td>
                                    <td class="text-center"><?php echo $row["lastname"]; ?></td>
                                    <td class="text-center"><?php echo dbToDateFormat($row["date_of_birth"]); ?></td>
                                    <td class="text-center"><?php echo ucfirst($row["gender"]); ?></td>
                                    <td class="text-center"><?php echo $row["street"]; ?></td>
                                    <td class="text-center"><?php echo $row["suburb"]; ?></td>
                                    <td class="text-center"><?php echo $row["state"]; ?></td>
                                    <td class="text-center"><?php echo $row["postcode"]; ?></td>
                                    <td class="text-center"><?php echo $row["email"]; ?></td>
                                    <td class="text-center"><?php echo $row["phone"]; ?></td>
                                    <td class="text-center"><?php echo getSkillsTxt($row["skills"]); ?></td>
                                    <td class="text-center"><?php echo $row["other_skills"]; ?></td>
                                    <td class="text-center"><?php echo getAvailabilityTxt($row["availability"]); ?></td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1"><?php echo $row["status"]; ?></div>
                                            </div>
                                            <div class="col-12">
                                                <form method="get" action="manage.php" id="<?php echo $changeFormId; ?>">
                                                    <select name="status" class="form-control form-control-sm" data-id="<?php echo $row["EOInumber"]; ?>">
                                                        <option value=""></option>
                                                        <option value="New">New</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                    <input type="hidden" name="action" value="change">
                                                    <input type="hidden" name="EOInumber" value="<?php echo $row["EOInumber"]; ?>">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="17" class="text-center">No results</td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>

                <?php
                } else {
                ?>

                <h1>HR manager</h1>

                <div class="row mb-2">
                    <div class="col-6 offset-3">

                        <?php
                        if (isset($flashLoginFail)) {
                            echo "<div class=\"alert alert-danger mt-2\" role=\"alert\">";
                            echo "<h4 class=\"alert-heading mt-0 mb-0\">Login fail</h4>";
                            echo "</div>";
                        }
                        ?>
                        
                        <form method="post" action="manage.php" id="login-form">

                            <h2>Login</h2>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" maxlength="5" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" maxlength="20" required>
                            </div>

                            <input type="hidden" name="action" value="login">

                            <?php
                            if (isset($_SESSION["flash_login_attempt_again"])) {
                                if ($_SESSION["flash_login_attempt_again"] <= date("Y-m-d H:i:ss")) {
                                    unset($_SESSION["flash_login_attempt"]);
                                    unset($_SESSION["flash_login_attempt_again"]);
                                    echo "<button type=\"submit\" class=\"btn btn-primary\">Login</button>";
                                } else {
                                    echo "<p>Three or more invalid login attempts. You can attempt again after {$_SESSION["flash_login_attempt_again"]}</p>";
                                }
                            } else {
                                echo "<button type=\"submit\" class=\"btn btn-primary\">Login</button>";
                            }
                            ?>
					        <!-- <a href="registration.php" class="btn btn-light">Register</a> -->
                        </form>

                    </div>
                </div>

                <?php
                }
                ?>

			</div>
		</div>
	</div>

	<?php include_once("footer.inc"); ?>
	
</body>
</html>
