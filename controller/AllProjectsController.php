<?php
function __autoload($className) {
	require_once "../model/" . $className . '.php';
}

session_start();
if(!isset($_SESSION['user'])){
	header('Location:../view/index.php');
}


$sessionVars = json_decode($_SESSION['user'], true);
$user_id = $sessionVars['id'];
$user_email = $sessionVars['email'];
try{
	$projects = new ProjectDAO();
	$allProjects = $projects->getUserAllProjects($user_id);
	
	
}catch (Exception $e){
	$message =  $e->getMessage();
}
/* echo "<br/><br/><br/>";
var_dump($allProjects); */
include '../view/allprojects.php';
?>