<?php

require_once 'lib/PatchTemplateFactory.php';

class VHSViewPlugin extends StudipPlugin implements SystemPlugin 
{

	CONST URL = "osnabrueck.elan-ev.de/";
	
	public function __construct() {
		
		parent::__construct();
		
		// instantiate patching template factory
        $GLOBALS['template_factory'] = new VHS\PatchTemplateFactory(
            $GLOBALS['template_factory'],
            realpath($this->getPluginPath() . '/templates')
        );
		
		global $perm, $user;
		$username = Request::get('username', $auth->auth['uname']);
        $referer = $_SERVER['REQUEST_URI'];

        //brauch ich das wirklich?
		$path = explode(VHSViewPlugin::URL, $referer);
		if ( $referer!=str_replace("index.php","",$referer) || $path[1] == "" ){
			PageLayout::addStylesheet($this->getPluginUrl() . '/css/startseite.css');
		}
                
        //Kontakte verschieben zum Messaging, erfordert auch Änderung in controllers/contact.php
		if (Navigation::hasItem('/messaging')){
                    $navigation = new Navigation(_('Kontakte'), 'dispatch.php/contact');
                    Navigation::getItem('/messaging')->addSubNavigation('contacts', $navigation);
        }
        if (Navigation::hasItem('/community/contacts')){
			Navigation::removeItem('/community/contacts');
        }
                
                
		//Wer kein Admin ist erhält eine stark reduzierte Navigation
		if (!$perm->have_perm('admin') && is_object($user)) {
			$this->setupNavigationForNoAdmin();
		}
        
	
	}
    
    private function setupNavigationForKursteilnehmer(){
    
         if (Navigation::hasItem('/course')){
                Navigation::getItem('/course')->setImage(NULL);
            }
        
        if (Navigation::hasItem('/start')){
            //Navigation::getItem('/start')->setURL( PluginEngine::getLink($this, array(), 'start/'));
        
            if (Navigation::hasItem('/start/my_courses')){
                Navigation::removeItem('/start/my_courses');
            }
            if (Navigation::hasItem('/start/messaging')){
                Navigation::removeItem('/start/messaging');
            }
            if (Navigation::hasItem('/start/profile')){
                Navigation::removeItem('/start/profile');
            }
            if (Navigation::hasItem('/start/help')){
                Navigation::removeItem('/start/help');
            }
            if (Navigation::hasItem('/start/tools')){
                Navigation::removeItem('/start/tools');
            }
        }       
    }
    
    private function setupNavigationForNoAdmin(){
        
        global $perm;
        //Wer kein Dozent ist braucht auch das hier nicht
        if (!$perm->have_perm('dozent')) {
            //Subnvigations von Tools
            if (Navigation::hasItem('/tools')){
                if (Navigation::hasItem('/tools/elearning')){
                    Navigation::removeItem('/tools/elearning');
                }
                if (Navigation::hasItem('/tools/evaluation')){
                    Navigation::removeItem('/tools/evaluation');
                }                  
            } 
            if (Navigation::hasItem('/community')){
                Navigation::removeItem('/community');
            }
            if (Navigation::hasItem('/calendar')) {
                Navigation::removeItem('/calendar');
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
        if (Navigation::hasItem('/search')){
            Navigation::removeItem('/search');	
        }            
        //Tools ausblenden 
        if (Navigation::hasItem('/tools')){
            Navigation::getItem('/tools')->setImage(NULL);
        }

        if (Navigation::hasItem('/tools/rss')){
            Navigation::removeItem('/tools/rss');
        }
        if (Navigation::hasItem('/tools/literature')){
            Navigation::removeItem('/tools/literature');
        }

        //Supnavigations von Profile
        if (Navigation::hasItem('/profile/edit/study_data')){
            Navigation::removeItem('/profile/edit/study_data');
        }
        if (Navigation::hasItem('/start/search')){
            Navigation::removeItem('/start/search');
        }
        //StudIP default Startseite aufräumen            
        if (Navigation::hasItem('/start')){
            if (Navigation::hasItem('/start/community')){
                Navigation::removeItem('/start/community');
            }
            if (Navigation::hasItem('/start/planner')) {
                Navigation::removeItem('/start/planner');
            }
        }
        //Veranstaltungen/Kurse            
        if (Navigation::hasItem('/browse')){	
            //User mit nur einem Kurs
            $stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
                WHERE su.user_id = ?");
            $stmt->execute(array($GLOBALS['user']->id));
            $count = $stmt->rowCount();
            if($count == 1){
                $result = $stmt->fetch();
                Navigation::getItem('/browse')->setURL("seminar_main.php?auswahl=". $result['seminar_id']);
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
                Navigation::getItem('/course')->setURL("seminar_main.php?auswahl=". $result['seminar_id']);
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
    
    public function getVHSColors(){
        return array(//red 
        '#1587a1', //türkis
        '#278420', //green
        '#1920a8', //darkblue
        '#e75f21', //orange
        '#601981', //purple)
        '#2f0d61'); //very dark blue
    }
    
}
