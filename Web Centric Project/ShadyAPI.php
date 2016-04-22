<?php

require("DemoCreds.php");

echo $_POST["method"]();

function sanitize($str, $quotes = ENT_NOQUOTES) {
    $str = htmlspecialchars($str, $quotes);
    return $str;
}

function getDatabases() {
    // retrieve and sanitize posted values.
    if (isset($_POST['server'])) {
        $server = json_decode(sanitize($_POST['server']));
    }
    if (isset($_POST['username'])) {
        $username = json_decode(sanitize($_POST['username']));
    }
    if (isset($_POST['password'])) {
        $password = json_decode(sanitize($_POST['password']));
    }
    $databaseNames = array();

    $dbConn = mysqli_connect($server, $username, $password);
    $query = "SHOW DATABASES";
    $result = $dbConn->query($query);

    if ($result) {
        while ($row = $result->fetch_array()) {
            array_push($databaseNames, $row[0]);
        }
    }

    $return = new stdClass;
    $return->credentials = $server + "  " + $username + "   " + $password;
    $return->success = true;
    $return->errorMessage = "";
    $return->data['database_names'] = $databaseNames;
    $json = json_encode($return);
    return $json;
}

function insertPrimary() {
    // retrieve and sanitize posted values.

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

    if (isset($_POST['Impact'])) {
        $Impact = json_decode(sanitize($_POST['Impact']));
    }

    if (isset($_POST['Trigger'])) {
        $Trigger = json_decode(sanitize($_POST['Trigger']));
    }
	
	if (isset($_POST['FireRate'])) {
        $Impact = json_decode(sanitize($_POST['FireRate']));
    }
	
	if (isset($_POST['Critical'])) {
        $Impact = json_decode(sanitize($_POST['Critical']));
    }
	
	if (isset($_POST['Status'])) {
        $Impact = json_decode(sanitize($_POST['Status']));
    }

    $dbConn = mysqli_connect(demoServer(), demoUsername(), demoPassword(), demoDB());
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    $query = "INSERT INTO Primary ( DmgID, Name, Slash, Puncture, Impact, Trigger, FireRate, Critical, Status ) " .
            "VALUES ( " .
            "" . $DmgID . ", " .
            "'" . $Name . "', " .
            "" . $Slash . ", " .
            "" . $Puncture . ", " .
            "" . $Impact . ", " .
            "" . $Trigger . ");";
			"" . $FireRate . ");";
			"" . $Critical . ");";
			"" . $Status . ");";
    $result = $dbConn->query($query);
    $return = new stdClass;
    $return->querystring = $query;
    if ($result) {
        //$return->connection = $dbConn;
        // $return->credentials = (string) (demoUsername() . demoPassword() . demoDB() . " on " . demoServer());
        $return->success = true;
    } else {
        $return->success = false;
    }
    return json_encode($return);
}

function updatePrimary() {
    // retrieve and sanitize posted values.

    if (isset($_POST['ID'])) {
      $ID = json_decode(sanitize($_POST['ID']));
    }
    if (isset($_POST['newDmgID'])) {
        $newDmgID = json_decode(sanitize($_POST['newDmgID']));
    }

    if (isset($_POST['newName'])) {
        $newName = json_decode(sanitize($_POST['newName']));
    }

    if (isset($_POST['newSlash'])) {
        $newSlash = json_decode(sanitize($_POST['newSlash']));
    }

    if (isset($_POST['newPuncture'])) {
        $newPuncture = json_decode(sanitize($_POST['newPuncture']));
    }

    if (isset($_POST['newImpact'])) {
        $newImpact = json_decode(sanitize($_POST['newImpact']));
    }

    if (isset($_POST['newTrigger'])) {
        $newTrigger = json_decode(sanitize($_POST['newTrigger']));
    }
	
	if (isset($_POST['newFireRate'])) {
        $newTrigger = json_decode(sanitize($_POST['newFireRate']));
    }
	
	if (isset($_POST['newCritical'])) {
        $newTrigger = json_decode(sanitize($_POST['newCritical']));
    }
	
	if (isset($_POST['newStatus'])) {
        $newTrigger = json_decode(sanitize($_POST['newStatus']));
    }

    $dbConn = mysqli_connect(demoServer(), demoUsername(), demoPassword(), demoDB());
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    $query = "UPDATE Primary " + 
             "SET DmgID='" + $newDmgID + "'" + 
             "SET Name='" + $newName + "'" + 
             "SET Slash='" + $newSlash + "'" + 
             "SET Puncture='" + $newPuncture + "'" + 
             "SET Impact='" + $newImpact + "'" + 
             "SET Trigger='" + $newTrigger + "'" +           
			 "SET FireRate='" + $newFireRate + "'" +
			 "SET Critical='" + $newCritical + "'" +
			 "SET Status='" + $newStatus + "'" +
             "WHERE ID=" + $ID;
    $result = $dbConn->query($query);
    $return = new stdClass;
    $return->querystring = $query;
    if ($result) {
        $return->success = true;
    } else {
        $return->success = false;
    }
    return json_encode($return);
}

/**
 * function getGardens()
 * 
 * preconditions: a file of the form given in DemoCreds.php that contains
 *                the credentials that will be used to access the database.
 *                This is not secure -- just for demo purposes.
 * 
 * arguments: none
 *
 * action: retrieves all of the rows from table RectGardens and returns
 *         them in toto in the gardens property of the returned object.  
 *
 * return An object that has the following fields:
 *     connect_error: error returned from mysqli_connect but only if an error 
 *                    occured.  null otherwise
 *     success: a boolean indicating if the call was successful (true) or not
 *     gardens: an array of rows as arrays of columns
 *     querystring: the query string that was executed
 *     credentials: is this a bad idea or what?
 * 
 * postconditions
 */

function getPrimary() {
    $dbConn = mysqli_connect(demoServer(), demoUsername(), demoPassword(), demoDB());

    $query = "SELECT * FROM ncJeffH.'Primary';";
    $result = $dbConn->query($query);
    if ($dbConn->connect_error) {
        $return->connect_error = "Connection failed: " . $dbConn->connect_error;
        $return->success = false;
        return json_encode($return);
    }

    $primary = array();

    if ($result) {
        while ($row = $result->fetch_array()) {
            $allColumns = array();
            for ($i = 0; $i < 10; $i++) {
                array_push($allColumns, $row[$i]);
            }
            array_push($primary, $allColumns);
        }
    }
    
    $return = new StdClass();
    $return->success = true;
    $return->primary = $primary;
    $return->querystring = $query;
    $return->credentials = 
            demoUsername() . 
            demoPassword() . 
            demoDB() . 
            " on " . 
            demoServer();
    return json_encode($return);
}
