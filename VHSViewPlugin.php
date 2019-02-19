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
		
		
		global $perm, $user;
		$username = Request::get('username', $auth->auth['uname']);
        
        //TODO get datafield value of hide Tab Navigation for this Seminar
        
        PageLayout::addStylesheet($this->getPluginUrl() . '/css/no_tab_nav.css');
		PageLayout::addStylesheet($this->getPluginUrl() . '/css/startseite.css');
		PageLayout::addStylesheet($this->getPluginUrl() . '/css/nivo-slider.css');
		PageLayout::addScript($this->getPluginUrl() . '/javascript/slideshow.js');
                //PageLayout::addScript($this->getPluginUrl() . '/javascript/slideshow_new.js');
		PageLayout::addScript($this->getPluginUrl() . '/javascript/jquery.nivo.slider.js');

		//falls Mooc.IP aktiviert ist, Icon aus der Kopfzeile ausblenden
		if (Navigation::hasItem('/mooc')){
					Navigation::removeItem('/mooc');
			}
		
		
		if (!$perm->have_perm('admin') && $user->id != 'nobody') {
 
			if (Navigation::hasItem('/search')){
                Navigation::removeItem('/search');	
			}
             if (Navigation::hasItem('/community')){
                Navigation::removeItem('/community');
            }
			
			if (Navigation::hasItem('/tools')){
				if (!$perm->have_perm('dozent')) {
					if (Navigation::hasItem('/tools/elearning')){
						Navigation::removeItem('/tools/elearning');
					}
					if (Navigation::hasItem('/tools/evaluation')){
						Navigation::removeItem('/tools/evaluation');
					}
                    if (Navigation::hasItem('/calendar/schedule')){
                        Navigation::removeItem('/calendar/schedule');
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
				if($count == 0 && $my_about->auth_user['perms'] == 'autor'){
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
		
		
		//für nobody/nicht eingeloggt
		if (!is_object($user)){
			if (Navigation::hasItem('/course/main/courses')){
				Navigation::removeItem('/course/main/courses');
			}
			
			if (Navigation::hasItem('/course/main/schedule')){
				Navigation::removeItem('/course/main/schedule');
			}
		}

                //profilenavigation for courseware-badges
                $this->user         = \User::findCurrent(); // current logged in user
                $this->current_user = \User::findByUsername(Request::username('username', $this->user->username)); // current selected user
                
                //falls Profil des eingeloggten Nutzers, schauen ob er schon Badges hat
                if ($this->current_user['user_id'] == $this->user->id && !$this->current_user['locked']) {
                    $values = array('user_id' => $this->user->id);
                    $query = "SELECT * FROM `mooc_badges` WHERE `user_id` LIKE :user_id" ;
                    $statement = \DBManager::get()->prepare($query);
                    $statement->execute($values);
                    $this->badges = $statement->fetchAll(\PDO::FETCH_ASSOC);
                
                //falls profil eines fremden nutzers schauen ob er schon Badges hat
                } else {
                    $values = array('user_id' => $this->current_user['user_id']);
                    $query = "SELECT * FROM `mooc_badges` WHERE `user_id` LIKE :user_id" ;
                    $statement = \DBManager::get()->prepare($query);
                    $statement->execute($values);
                    $this->badges = $statement->fetchAll(\PDO::FETCH_ASSOC);
                }
                
                
                if (Navigation::hasItem("/profile") && 
                    $this->badges) {
                        $nav = new AutoNavigation(_("Badges"), PluginEngine::getURL($this, 
                        array('user_id' => $this->current_user['user_id']), "badges"));
                        Navigation::addItem("/profile/badges", $nav);
                }
		

		
	}
}
