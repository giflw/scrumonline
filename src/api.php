<?php
// Bootstrap the application
require_once "bootstrap.php";
require_once "controllers/response.php";

$pathInfo = $_SERVER['PATH_INFO'];
$pathInfo = explode('/', $pathInfo);
array_shift($pathInfo);

// Parse controller and method
$controllerName = isset($_GET["c"]) ? $_GET["c"] : $pathInfo[0];
$method = isset($_GET['m']) ? $_GET['m'] : $pathInfo[1];

// Load controller and invoke method
$controller = include "controllers/" . $controllerName . "-controller.php";

$id = isset($_GET["id"]) ? $_GET["id"] : (count($pathInfo) > 2 ? $pathInfo[2] : null);
$mid = isset($_GET["mid"]) ? $_GET["mid"] : (count($pathInfo) > 3 ? $pathInfo[3] : null);

if ($id !== null && $mid !== null) {
  // Pass both query arguments
  $result = $controller->$method($id, $mid);
} else if ($id !== null) {
  // Pass only id
  $result = $controller->$method($id);
} else {
  // Pass no arguments
  $result = $controller->$method();
}
// Return reponse as JSON if this method has a return value
if (isset($result) && $result != null) {
  echo json_encode($result);
}
