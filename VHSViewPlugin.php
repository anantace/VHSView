<?php

require_once 'lib/classes/DBManager.class.php';

class VHSViewPlugin extends StudipPlugin implements SystemPlugin 
{
	public function __construct() {
	
	    parent::__construct();
		
		global $auth, $perm, $user;
		$username = Request::get('username', $auth->auth['uname']);


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
				
			}
			
			if (Navigation::hasItem('/calendar')){
				Navigation::removeItem('/calendar');
			}
			
			if (Navigation::hasItem('/community')){
				Navigation::removeItem('/community');
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
