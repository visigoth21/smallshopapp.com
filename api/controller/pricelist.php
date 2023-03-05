<?php
// tblpricelists
// id	
// partnumber	
// upc	
// description	
// mfg	
// list	
// cost	
// supersedesto	
// weight
//
// id, partnumber, upc, description, mfg, list, cost, supersedesto, weight

// date_default_timezone_set('America/New_York');

require_once('db.php');
require_once('../model/item.php');
require_once('../model/response.php');

// attempt to set up connections to read and write db connections
try {
  $writeDB = DB::connectWriteDB();
  $readDB = DB::connectReadDB();
}
catch(PDOException $ex) {
  // log connection error for troubleshooting and return a json error response
  error_log("Connection Error: ".$ex, 0);
  errorResponse(500, "Database connection error");
  exit;
}

if (array_key_exists("upccheck",$_GET)) {
    // get task id from query string
    $upccheck = $_GET['upccheck'];
  
    //check to see if task id in query string is not empty and is number, if not return json error
    if($upccheck == '') {
      errorResponse(400, "Task ID cannot be blank");
      exit;
    }
    
    // if request is a GET, e.g. get task
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      // attempt to query the database
      try {
        // create db query
        // ADD AUTH TO QUERY
        $query = $readDB->prepare('SELECT id, partnumber, upc, description, mfg, list, cost, supersedesto, weight from tblpricelists where upc = :upccheck or partnumber = :upccheck');

        $query->bindParam(':upccheck', $upccheck, PDO::PARAM_INT);
        //$query->bindParam(':userid', $returned_userid, PDO::PARAM_INT);
            $query->execute();
  
        // get row count
        $rowCount = $query->rowCount();
  
        // create task array to store returned task
        $taskArray = array();
  
        if($rowCount === 0) {
          // set up response for unsuccessful return
          errorResponse(404, "Item not found");
          exit;
        }
  
        // for each row returned
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
          // create new task object for each row
          // id, partnumber, upc, description, mfg, list, cost, supersedesto, weight
          $task = new Item($row['id'], $row['partnumber'], $row['upc'], $row['description'], $row['mfg'], $row['list'], $row['cost'], $row['supersedesto'], $row['weight']);
  
          // create task and store in array for return in json data
            $itemArray[] = $Item->returnItemAsArray();
        }
  
        // bundle tasks and rows returned into an array to return in the json data
        $returnData = array();
        $returnData['rows_returned'] = $rowCount;
        $returnData['tasks'] = $itemArray;
  
        // set up response for successful return
        $response = new Response();
        $response->setHttpStatusCode(200);
        $response->setSuccess(true);
        $response->toCache(true);
        $response->setData($returnData);
        $response->send();
        exit;
      }
      // if error with sql query return a json error
      catch(TaskException $ex) {
        errorResponse(500, $ex->getMessage());
        exit;
      }
      catch(PDOException $ex) {
        error_log("Database Query Error: ".$ex, 0);
        errorResponse(500, "Failed to get task");
        exit;
      }
    }
// if any other request method apart from GET, PATCH, DELETE is used then return 405 method not allowed
    else {
      errorResponse(405, "Request method not allowed");
      exit;
    } 
  }
//-----------------------------------------------------------------------------------------------//
function errorResponse($failureCode, $failureMessage)
{
  $response = new Response();
  $response->setHttpStatusCode($failureCode);
  $response->setSuccess(false);
  $response->addMessage($failureMessage);
  $response->send();
}
//-----------------------------------------------------------------------------------------------//