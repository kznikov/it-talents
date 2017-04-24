<?php
require_once "../model/IProjectDAO.php";
class ProjectDAO implements IProjectDAO {
	
	const INSERT_NEW_PROJECT = "INSERT INTO projects (id, name, description, prefix, create_date, admin_id, client, start_date, end_date, project_status_id) 
						VALUES (null, ?, ?, ?, now(), ?, ?, ?, ?, ?)";

	const GET_ADMIN_PROJECTS = "SELECT p.*, u.id as user_id, u.username, ps.name as status, COUNT(t.id) as 'all_tasks' FROM projects p JOIN users u JOIN project_status ps left JOIN tasks t
					 ON p.id = t.projects_id WHERE p.project_status_id = ps.id AND p.admin_id = u.id and p.admin_id =";
	
	const GET_ADMIN_ALL_OPEN_TASK_CNT = "SELECT p.id, count(t.id) as 'open_tasks' FROM projects p LEFT JOIN tasks t ON p.id = t.projects_id and t.task_status_id = 1 WHERE p.admin_id = ";

	
	const GET_PROJECT_PROGRESS = "SELECT p.id, ROUND(AVG(t.progress)) as 'avg_tasks_progress' FROM projects p left JOIN tasks t ON p.id = t.projects_id WHERE p.admin_id = ";
	
	const CHECK_IF_PROJECTNAME_EXIST = "SELECT name FROM projects WHERE name = ?";

	const CHECK_IF_PREFIXNAME_EXIST = "SELECT prefix FROM projects WHERE prefix = ?";
	
	
	const GET_USER_ASSOC_PROJECTS = "SELECT p.*, u.id as user_id, u.email as user_email, u.username, ps.name as status, COUNT(t.id) as all_tasks FROM projects p JOIN user_projects up JOIN users u JOIN project_status ps LEFT JOIN tasks t
							 ON p.id = t.projects_id  where p.project_status_id = ps.id and u.id = up.user_id and p.id = up.project_id AND u.id = up.user_id  and u.id = ";
	
	const GET_USER_ASSOC_PROJECTS_OPEN_TASKS_CNT = "SELECT p.id, count(t.id) as 'open_tasks' FROM projects p JOIN user_projects up LEFT JOIN tasks t 
											ON p.id = t.projects_id and t.task_status_id = 1 WHERE p.id = up.project_id and up.user_id = ";
	
	
	const GET_ASSOC_PROJECTS_PROGRESS = "SELECT p.id, ROUND(AVG(t.progress)) as 'avg_tasks_progress' FROM projects p JOIN user_projects up LEFT JOIN tasks t
											ON p.id = t.projects_id WHERE p.id = up.project_id and up.user_id = ";
	
	
	
	public function createProject(Project $project) {

		try{
			$db = DBConnection::getDb();
			
			$pstmt = $db->prepare(self::INSERT_NEW_PROJECT);
			
			$pstmt->execute(array($project->name, $project->description, $project->prefix, $project->adminId, $project->client, $project->startDate, 
								$project->endDate, $project->status));
			
			return true;
		}catch(Exception $e){
			throw new Exception("Failed to create new project!");
		}
	}
	
	
	public function getAdminProjects($id) {
		try{
			$db = DBConnection::getDb();
			
			$res = $db->query(self::GET_ADMIN_PROJECTS.$id." GROUP BY p.id");
			$res = $res->fetchAll(PDO::FETCH_ASSOC);
			$openTasks = $db->query(self::GET_ADMIN_ALL_OPEN_TASK_CNT.$id." GROUP BY p.id");
			$openTasks = $openTasks->fetchAll(PDO::FETCH_ASSOC);
			
			$projectProgress =  $db->query(self::GET_PROJECT_PROGRESS.$id." GROUP BY p.id");
			$projectProgress = $projectProgress->fetchAll(PDO::FETCH_ASSOC);
			
			for($index = 0;$index <= count($res)-1;$index++){
				$tmp[] = array_merge($res[$index], $openTasks[$index]);
			}
			
			for($index = 0;$index <= count($tmp)-1;$index++){
				$result[] = array_merge($tmp[$index], $projectProgress[$index]);
			}
			return $result;
		}catch(Exception $e){
			throw new Exception("Failed to get information from DB!");
		}
	}
	
	
	
	public function getUserAllProjects($id) {
		try{
			$db = DBConnection::getDb();
			
			$adminProjects = self::getAdminProjects($id);
			
			$assocProjects = $db->query(self::GET_USER_ASSOC_PROJECTS.$id." GROUP BY p.id");
			$assocProjects= $assocProjects->fetchAll(PDO::FETCH_ASSOC);
			 $openTasks = $db->query(self::GET_USER_ASSOC_PROJECTS_OPEN_TASKS_CNT.$id." GROUP BY p.id");
			$openTasks = $openTasks->fetchAll(PDO::FETCH_ASSOC);
			
			$projectProgress =  $db->query(self::GET_ASSOC_PROJECTS_PROGRESS.$id." GROUP BY p.id");
			$projectProgress = $projectProgress->fetchAll(PDO::FETCH_ASSOC);
			
			for($index = 0;$index <= count($assocProjects)-1;$index++){
				$tmp[] = array_merge($assocProjects[$index], $openTasks[$index]);
			}
			
			for($index = 0;$index <= count($tmp)-1;$index++){
				$result[] = array_merge($tmp[$index], $projectProgress[$index]);
			} 
			
			return array_merge($adminProjects, $result);
			
		}catch(Exception $e){
			throw new Exception("Failed to get information from DB!");
		}
	}

	public static function checkProjectName($name) {
		$db = DBConnection::getDb();
		
		$pstmt = $db->prepare(self::CHECK_IF_PROJECTNAME_EXIST);
		$pstmt->execute(array($name));
		
		$res = $pstmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($res) === 0) {
			return true;
		} else {
			return false;
		}
		
	}

	public static function checkPrefixName($name) {
		$db = DBConnection::getDb();
		
		$pstmt = $db->prepare(self::CHECK_IF_PREFIXNAME_EXIST);
		$pstmt->execute(array($name));
		
		$res = $pstmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($res) === 0) {
			return true;
		} else {
			return false;
		}
		
	}
	

}

?>