<?php

require_once 'lib/classes/DBManager.class.php';

class VHSViewPlugin extends StudipPlugin implements SystemPlugin 
{
	public function __construct() {
	
	    parent::__construct();
	
	    PageLayout::addStylesheet($this->getPluginURL() . '/assets/courseware.css');
	    PageLayout::addScript($this->getPluginURL() . '/assets/script.js');
		
		global $auth, $perm, $user;
		$username = Request::get('username', $auth->auth['uname']);

		

	 $course_id = $_SESSION['SessSemName'][1];


	 if (Navigation::hasItem('/course/mooc_courseware')){
			$query = "SELECT content AS value
			FROM datafields_entries
			WHERE datafield_id = 'c7f844e04a4c354e1db9a9e78859e58c'
			AND range_id = '" . $course_id . "'
			AND content = '1'";
                            
			$statement = DBManager::get()->prepare($query);
			$statement->execute();
			$courseware = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			if (count($courseware)){
				Navigation::removeItem('/course/mooc_courseware');
			}
	}

	//Navigation::getItem('/search')->setTitle($course_id);


		if (!$perm->have_perm('admin') && $user->id != 'nobody') {
			if (Navigation::hasItem('/search')){
				
					Navigation::removeItem('/search');
				
				
			}
			
			if (Navigation::hasItem('/tools')){
				if (!$perm->have_perm('dozent')) {
					if (Navigation::hasItem('/tools/elearning')){
						Navigation::removeItem('/tools/elearning');
					}
					if (Navigation::hasItem('/tools/evaluation')){
						Navigation::removeItem('/tools/evaluation');
					}
				}
			}
	/**		
			if (Navigation::hasItem('/course/main/courses')){
			//	Navigation::removeItem('/course/main/courses');
			}
			
			if (Navigation::hasItem('/course/main/schedule')){
			//	Navigation::removeItem('/course/main/schedule');
			}
		**/	
			if (Navigation::hasItem('/tools')){
				Navigation::getItem('/tools')->setImage(NULL);
			}
			
			if (Navigation::hasItem('/tools/rss')){
				Navigation::removeItem('/tools/rss');
			}
			if (Navigation::hasItem('/tools/literature')){
				Navigation::removeItem('/tools/literature');
			}
			
			if (Navigation::hasItem('/profile/edit/study_data')){
				Navigation::removeItem('/profile/edit/study_data');
			}
			if (Navigation::hasItem('/start/search')){
				Navigation::removeItem('/start/search');
			}
			
			if (Navigation::hasItem('/browse')){
				
				
				$stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
					WHERE su.user_id = ?");
				$stmt->execute(array($GLOBALS['user']->id));
				$count = $stmt->rowCount();
				if($count == 1){
					$result = $stmt->fetch();
					Navigation::getItem('/browse')->setURL("/seminar_main.php?auswahl=". $result['seminar_id']);
					Navigation::getItem('/browse')->setTitle("Mein Kurs");	
				}
				if($count == 0 && !$perm->have_perm('dozent')){
					Navigation::removeItem('/browse');	
				}
				
			}
			
			if (Navigation::hasItem('/course')){
			
			
				$stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
					WHERE su.user_id = ?");
				$stmt->execute(array($GLOBALS['user']->id));
				
				$count = $stmt->rowCount();
				if($count == 1){
					$result = $stmt->fetch();
					Navigation::getItem('/course')->setURL("/seminar_main.php?auswahl=". $result['seminar_id']);
					Navigation::getItem('/course')->setTitle("Mein Kurs");
				}
				
			}
			
			if (Navigation::hasItem('/start/my_courses')){
			
				if (Navigation::hasItem('/start/my_courses/browse')){
					Navigation::removeItem('/start/my_courses/browse');
				}
				if (Navigation::hasItem('/start/my_courses/new_studygroup')){
					Navigation::removeItem('/start/my_courses/new_studygroup');
				}
				if (Navigation::hasItem('/start/tools')){
					Navigation::removeItem('/start/tools');
				}
				
				$stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
					WHERE su.user_id = ?");
				$stmt->execute(array($GLOBALS['user']->id));
				
				$count = $stmt->rowCount();
				if($count == 1){
					$result = $stmt->fetch();
					Navigation::getItem('/start/my_courses')->setURL("/seminar_main.php?auswahl=". $result['seminar_id']);
					Navigation::getItem('/start/my_courses')->setTitle("Mein Kurs");
				}
				if($count == 0){
					Navigation::removeItem('/start/my_courses');	
				} 
				if($count > 1){
					Navigation::getItem('/start/my_courses')->setTitle("Kurse");
				}
				
			}
			
			if (Navigation::hasItem('/start/community/browse')){
					Navigation::removeItem('/start/community/browse');
			}
		
			if (Navigation::hasItem('/start/community/score')){
					Navigation::removeItem('/start/community/score');
			}
		}
		
		
		//Aus irgendeinem Grund wird das hier immer aufgerufen und oben geht er auch bei 'nobody' in die if-Schleife
		if ($user->id == 'nobody'){
			if (Navigation::hasItem('/course/main/courses')){
				Navigation::removeItem('/course/main/courses');
			}
			
			if (Navigation::hasItem('/course/main/schedule')){
				Navigation::removeItem('/course/main/schedule');
			}
		}

	

		

		
	}
}
