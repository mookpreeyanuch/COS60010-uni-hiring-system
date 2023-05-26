<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");
include_once("db-conn.php");
include_once("create-table.php");

$flashSuccess = null;
$flashError = null;

if (isset($_SESSION['flash_success'])) {
	$flashSuccess = $_SESSION['flash_success'];
	unset($_SESSION['flash_success']);
}

if (isset($_SESSION['flash_validate'])) {
	$flashValidate = $_SESSION['flash_validate'];
	unset($_SESSION['flash_validate']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Apply Jobs">
	<meta name="keywords" content="apply, apply jobs">
	<meta name="author" content="Palida Parichayawong">

	<title>Apply Jobs</title>

	<!-- References to external CSS files -->
	<link href="styles/style.css" rel="stylesheet">

	<script src="scripts/apply.js"></script>
	<script src="scripts/enhancements.js"></script>
</head>
<body>

	<?php include_once("header.inc"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<?php
				if (isset($flashSuccess)) {
					echo "<div class=\"alert alert-success mt-2\" role=\"alert\">";
					echo "<h4 class=\"alert-heading mt-0 mb-0\">Success</h4>";
					echo "Successfully applied. EOInumber is <strong>{$flashSuccess}</strong>";
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

				<h1>Apply</h1>

				<div class="mb-2 countdown">
					<div class="d-inline-block">Countdown </div> <div id="hours" class="d-inline-block">--</div> : <div id="minutes" class="d-inline-block">--</div> : <div id="seconds" class="d-inline-block">--</div>
				</div>

				<form method="post" action="processEOI.php" id="apply-job">
					<!--Note we have to use a special escape character to print an apostrophe on the Web page -->

					<div class="form-group">
						<label for="jobref">Job reference number</label>
						<input type="text" name="jobref" id="jobref" class="form-control" maxlength="5" required pattern="[A-Za-z0-9]{5}" title="exactly 5 alphanumeric characters">
					</div>

					<div class="form-group">
						<label for="firstname">First name</label>
						<input type="text" name="firstname" id="firstname" class="form-control" maxlength="20" required pattern="[A-Za-z ]{1,20}" title="max 20 alpha characters">
					</div>

					<div class="form-group">
						<label for="lastname">Last name</label>
						<input type="text" name="lastname" id="lastname" class="form-control" maxlength="20" required pattern="[A-Za-z ]{1,20}" title="max 20 alpha characters">
					</div>

					<div class="form-group">
						<label for="date_of_birth">Date of birth</label>
						<input type="text" name="date_of_birth" id="date_of_birth" class="form-control" maxlength="10" placeholder="dd/mm/yyyy" pattern="\d{2}\/\d{2}\/\d{4}" required>
						<small id="date_of_birth_error" class="form-text text-danger d-none">
							Applicants must be at between 15 and 80 years old.
						</small>
					</div>

					<div class="form-group">
						<fieldset>
							<legend>Gender</legend>
							<div class="form-check form-check-inline">
								<input type="radio" name="gender" id="gender-male" value="male" class="form-check-input" checked required>
								<label for="gender-male" class="form-check-label">Male</label>
							</div>
							<div class="form-check form-check-inline">
								<input type="radio" name="gender" id="gender-female" value="female" class="form-check-input">
								<label for="gender-female" class="form-check-label">Female</label>
							</div>
							<div class="form-check form-check-inline">
								<input type="radio" name="gender" id="gender-other" value="other" class="form-check-input">
								<label for="gender-other" class="form-check-label">Other</label>
							</div>
						</fieldset>
					</div>

					<div class="form-group">
						<label for="street">Street Address</label>
						<input type="text" name="street" id="street" class="form-control" maxlength="40" required>
					</div>

					<div class="form-group">
						<label for="suburb">Suburb/town</label>
						<input type="text" name="suburb" id="suburb" class="form-control" maxlength="40" required>
					</div>

					<div class="form-group">
						<label for="state">State</label>
						<select name="state" id="state" class="form-control">
							<option value="VIC">VIC</option>
							<option value="NSW">NSW</option>
							<option value="QLD">QLD</option>
							<option value="NT">NT</option>
							<option value="WA">WA</option>
							<option value="SA">SA</option>
							<option value="TAS">TAS</option>
							<option value="ACT">ACT</option>
						</select>
					</div>

					<div class="form-group">
						<label for="postcode">Postcode</label>
						<input type="text" name="postcode" id="postcode" class="form-control" maxlength="4" required pattern="[\d]{4}" title="exactly 4 digits">
						<small id="postcode_error" class="form-text text-danger d-none">
						
						</small>
					</div>

					<div class="form-group">
						<label for="suburb">Email address</label>
						<input type="email" name="email" id="email" class="form-control" maxlength="255" required>
					</div>

					<div class="form-group">
						<label for="phone">Phone number</label>
						<input type="tel" name="phone" id="phone" class="form-control" maxlength="12" required pattern="[\d ]{8,12}" title="8 to 12 digits, or spaces">
					</div>

					<div class="form-group">
						<label>Qualifications</label>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-dd" value="skill1" class="form-check-input">
							<label for="skill-dd" class="form-check-label">Doctoral degree</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-md" value="skill2" class="form-check-input">
							<label for="skill-md" class="form-check-label">Masters degree</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-gd" value="skill3" class="form-check-input">
							<label for="skill-gd" class="form-check-label">Graduate diploma</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-gc" value="skill4" class="form-check-input">
							<label for="skill-gc" class="form-check-label">Graduate certificate</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-bd" value="skill5" class="form-check-input">
							<label for="skill-bd" class="form-check-label">Bachelor degree</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="skills[]" id="skill-other" value="skill6" class="form-check-input">
							<label for="skill-other" class="form-check-label">Other</label>

							<div class="form-group" id="skill-other-box">
								<label for="other_skills">Other skills</label>
								<textarea name="other_skills" id="other_skills" class="form-control" rows="5" placeholder="Please write other skills here..."></textarea>
								<small id="skill-other-box_error" class="form-text text-danger d-none">
									The Other Skills text area cannot be blank.
								</small>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label>Availability</label>
						<div class="form-check">
						Please select the days and times that you are available:
						<p>Monday</p>
						<div class="form-check">
							<input type="checkbox" id="monday-morning" name="availability[]" value="mon1">
							<label for="monday-morning">Morning</label>
							<input type="checkbox" id="monday-afternoon" name="availability[]" value="mon2">
							<label for="monday-afternoon">Afternoon</label>
							<input type="checkbox" id="monday-evening" name="availability[]" value="mon3">
							<label for="monday-evening">Evening</label>					
						</div>

					<p>Tuesday</p>
					<div class="form-check">
						<input type="checkbox" id="tuesday-morning" name="availability[]" value="tue1">
						<label for="tuesday-morning">Morning</label>
						<input type="checkbox" id="tuesday-afternoon" name="availability[]" value="tue2">
						<label for="tuesday-afternoon">Afternoon</label>
						<input type="checkbox" id="tuesday-evening" name="availability[]" value="tue3">
						<label for="tuesday-evening">Evening</label>
					</div>

					<p>Wednesday</p>
					<div class="form-check">
						<input type="checkbox" id="wednesday-morning" name="availability[]" value="wed1">
						<label for="wednesday-morning">Morning</label>
						<input type="checkbox" id="wednesday-afternoon" name="availability[]" value="wed2">
						<label for="wednesday-afternoon">Afternoon</label>
						<input type="checkbox" id="wednesday-evening" name="availability[]" value="wed3">
						<label for="wednesday-evening">Evening</label>
					</div>

					<p>Thursday</p>
					<div class="form-check">
						<input type="checkbox" id="thursday-morning" name="availability[]" value="thu1">
						<label for="thursday-morning">Morning</label>
						<input type="checkbox" id="thursday-afternoon" name="availability[]" value="thu2">
						<label for="thursday-afternoon">Afternoon</label>
						<input type="checkbox" id="thursday-evening" name="availability[]" value="thu3">
						<label for="thursday-evening">Evening</label>
					</div>

					<p>Friday</p>
					<div class="form-check">
						<input type="checkbox" id="friday-morning" name="availability[]" value="fri1"> 
						<label for="friday-morning">Morning</label>
						<input type="checkbox" id="friday-afternoon" name="availability[]" value="fri2">
						<label for="friday-afternoon">Afternoon</label>
						<input type="checkbox" id="friday-evening" name="availability[]" value="fri3">
						<label for="friday-evening">Evening</label>
					</div>
					</div>

  
						
					<button type="submit" class="btn btn-primary">Apply</button>
					<button type="reset" class="btn btn-light">Reset Form</button>
				</form>
			</div>
		</div>
	</div>

	<?php include_once("footer.inc"); ?>
	
</body>
</html>
