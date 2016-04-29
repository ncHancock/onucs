<?php
require("DemoCreds.php");
echo $_POST["method"]();
function sanitize($str, $quotes = ENT_NOQUOTES) {
    $str = htmlspecialchars($str, $quotes);
    return $str;
}
function getPrimary() {
    $dbConn = mysqli_connect(server(), username(), password(), db());
    $query = "select * from Primary";
    $result = $dbConn->query($query);
    if ($dbConn->connect_error) {
        $return->connect_error = "Connection failed: " . $dbConn->connect_error;
        $return->success = false;
        return json_encode($return);
    }
    $Primary = array();
    if ($result) {
        while ($row = $result->fetch_array()) {
            $allColumns = array();
            for ($i = 0; $i < 6; $i++) {
                array_push($allColumns, $row[$i]);
            }
            array_push($Primary, $allColumns);
        }
    }
    $return = new stdClass();
    $return->success = true;
    $return->Primary = $Primary;
    $return->querystring = $query;
    return json_encode($return);
}
function getDmgCategories() {
    $dbConn = mysqli_connect(server(), username(), password(), db());
    $query = "SELECT * FROM DmgCategories";
    $result = $dbConn->query($query);
    if ($dbConn->connect_error) {
        $return->connect_error = "Connection failed: " . $dbConn->connect_error;
        $return->success = false;
        return json_encode($return);
    }
    $DmgCategories = array();
    if ($result) {
        while ($row = $result->fetch_array()) {
            $allColumns = array();
            for ($i = 0; $i < 2; $i++) {
                array_push($allColumns, $row[$i]);
            }
            array_push($DmgCategories, $allColumns);
        }
    }
    $return = new stdClass();
    $return->success = true;
    $return->DmgCategories = $DmgCategories;
    $return->querystring = $query;
    return json_encode($return);
}
function insertPrimary() {

    if (isset($_POST['DmgID'])) {
        $DmgID = json_decode(sanitize($_POST['DmgID']));
    }
    if (isset($_POST['Name'])) {
        $Name = json_decode(sanitize($_POST['Name']));
    }
    if (isset($_POST['Slash'])) {
        $Slash = json_decode(sanitize($_POST['Slash']));
    }
    if (isset($_POST['Puncture'])) {
        $Puncture = json_decode(sanitize($_POST['Puncture']));
    }
    if (isset($_POST['Imapact'])) {
        $Impact = json_decode(sanitize($_POST['Impact']));
    }
    $dbConn = mysqli_connect(server(), username(), password(), db());
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    $query = "INSERT INTO Primary ( DmgID, Name, Slash, Puncture, Impact ) " .
        "VALUES ( " .
        "'" . $DmgID . "'," .
        "'" . $Name . "'," .
        "'" . $Slash . "'," .
        "'" . $Puncture . "'," .
        "'" . $Impact . "');";
    $result = $dbConn->query($query);
    $return = new stdClass;
    $return->querystring = (string) $query;
    if ($result) {
        $return->success = true;
    } else {
        $return->success = false;
    }
    return json_encode($return);
}
