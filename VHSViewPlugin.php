<?php

require_once 'lib/PatchTemplateFactory.php';

class VHSViewPlugin extends StudipPlugin implements SystemPlugin 
{
	public function __construct() {
		
		parent::__construct();
		
		// instantiate patching template factory
        $GLOBALS['template_factory'] = new VHS\PatchTemplateFactory(
            $GLOBALS['template_factory'],
            realpath($this->getPluginPath() . '/templates')
        );
        
        PageLayout::addScript($this->getPluginURL().'/js/script.js');
		
		
		global $perm, $user;
		$username = Request::get('username', $auth->auth['uname']);

		PageLayout::addStylesheet($this->getPluginUrl() . '/css/startseite.css');
                PageLayout::addStylesheet($this->getPluginUrl() . '/css/courseware.css');
		
		//falls Mooc.IP aktiviert ist, Icon aus der Kopfzeile ausblenden
		if (Navigation::hasItem('/mooc')){
					Navigation::removeItem('/mooc');
			}
		
		
		if (!$perm->have_perm('admin') && is_object($user)) {
			if (Navigation::hasItem('/search')){
				
					Navigation::removeItem('/search');
				
				
			}
			
			if (Navigation::hasItem('/tools')){
				if ( !$perm->have_perm('dozent')) {
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
				
				//var_dump(Navigation::getItem('/'));
				$stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
					WHERE su.user_id = ?");
				$stmt->execute(array($GLOBALS['user']->id));
				$count = $stmt->rowCount();
				if($count == 1){
					$result = $stmt->fetch();
					Navigation::getItem('/browse')->setURL("/seminar_main.php?auswahl=". $result['seminar_id']);
					Navigation::getItem('/browse')->setTitle("Mein Kurs");	
				}
				if($count == 0 && !$perm->have_perm('tutor') && $user->id != 'nobody'){
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
		/**if ($my_about->auth_user['perms'] == 'nobody'){
			if (Navigation::hasItem('/course/main/courses')){
				Navigation::removeItem('/course/main/courses');
			}
			
			if (Navigation::hasItem('/course/main/schedule')){
				Navigation::removeItem('/course/main/schedule');
			}
		}
                 * 
                 */

            if (is_object($user) && $user->username == 'gastnutzer_norden' ) {	
                //echo '<pre>';
                //var_dump(Navigation::getItem('/course')->getSubNavigation());
                //echo '</pre>';
                PageLayout::addStylesheet($this->getPluginUrl() . '/css/gastuser.css');
                
                if (Navigation::hasItem('/start')){
				Navigation::removeItem('/start');
			}
                if (Navigation::hasItem('/messaging')){
				Navigation::removeItem('/messaging');
			}
                if (Navigation::hasItem('/community')){
				Navigation::removeItem('/community');
			}
                if (Navigation::hasItem('/profile')){
				Navigation::removeItem('/profile');
			}
                if (Navigation::hasItem('/tools/rss')){
                        Navigation::removeItem('/tools/rss');
                }
                 if (Navigation::hasItem('/calendar')){
                        Navigation::removeItem('/calendar');
                }
                if (Navigation::hasItem('/course')){
                    Navigation::getItem('/course')->setURL("norden3.4/public/plugins.php/courseware/courseware?cid=35749fa1e8242185fd9809919134d07f");
                    Navigation::getItem('/course')->setTitle("KONZ");
                    Navigation::getItem('/course')->removeSubNavigation('main');
                    Navigation::getItem('/course')->removeSubNavigation('scm');
                }
            }
		
	}
}
