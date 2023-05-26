<?php

$checkEoiTableExistsQuery = "SHOW TABLES LIKE \"eoi\"";
$checkEoiTableExists = mysqli_query($dbConn, $checkEoiTableExistsQuery);
$checkEoiTableExistsNum = mysqli_num_rows($checkEoiTableExists);
// var_dump("$checkEoiTableExistsNum: " . $checkEoiTableExistsNum);

if ($checkEoiTableExistsNum == 0) { // eoi table don't exists
    $createEoiTableQuery = "CREATE TABLE `eoi` (
        `EOInumber` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `created_at` DATETIME NULL,
        `updated_at` DATETIME NULL,
        `jobref` VARCHAR(5) NULL,
        `firstname` VARCHAR(20) NULL,
        `lastname` VARCHAR(20) NULL,
        `date_of_birth` DATE NULL,
        `gender` VARCHAR(10) NULL,
        `street` VARCHAR(40) NULL,
        `suburb` VARCHAR(40) NULL,
        `state` VARCHAR(10) NULL,
        `postcode` VARCHAR(4) NULL,
        `email` VARCHAR(255) NULL,
        `phone` VARCHAR(12) NULL,
        `skills` TEXT NULL,
        `other_skills` TEXT NULL,
        `availability` TEXT NULL,
        `status` VARCHAR(10) NULL DEFAULT \"New\",
        PRIMARY KEY (`EOInumber`));";
    $createEoiTable = mysqli_query($dbConn, $createEoiTableQuery);
    // var_dump("$createEoiTable: " . $createEoiTable);
}

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