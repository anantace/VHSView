<?php

require_once 'lib/PatchTemplateFactory.php';

class MITPlugin extends StudipPlugin implements SystemPlugin 
{
	public function __construct() {
		
            parent::__construct();
		
		// instantiate patching template factory
            $GLOBALS['template_factory'] = new VHS\PatchTemplateFactory(
                $GLOBALS['template_factory'],
                realpath($this->getPluginPath() . '/templates')
            );

            $referer = $_SERVER['REQUEST_URI'];
            
            PageLayout::addScript($this->getPluginURL().'/js/script.js');
            PageLayout::addStylesheet($this->getPluginUrl() . '/css/startseite.css');

            global $perm, $user;
            //$username = Request::get('username', $auth->auth['uname']);

            if(is_object($user) && !$perm->have_perm('dozent')){

                if($referer!=str_replace("dispatch.php/start","",$referer)){
                    if ($this->getSemID($user->id)){
                        header('Location: '. $GLOBALS['ABSOLUTE_URI_STUDIP']. 'plugins.php/courseware/courseware?cid=' . $this->getSemID($user->id), true, 303);
                        exit();	
                    } else {
                        header('Location: '. $GLOBALS['ABSOLUTE_URI_STUDIP']. 'dispatch.php/my_courses', true, 303);
                        exit();	
                    }
                }
                
                PageLayout::addStylesheet($this->getPluginUrl() . '/css/autor.css');

                 if (Navigation::hasItem('/start')){
                                    //Navigation::removeItem('/start');
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
                    if (Navigation::hasItem('/calendar')) {
				Navigation::removeItem('/calendar');
                    }
                    if (Navigation::hasItem('/search')) {
				Navigation::removeItem('/search');
                    }
                    if (Navigation::hasItem('/tools')){
                                    Navigation::removeItem('/tools');
                    }

            }


            if (!$perm->have_perm('admin') && is_object($user)) {

            }
        }
        
        
        private function getSemID($user_id){
	
	   $stmt = DBManager::get()->prepare("SELECT su.seminar_id FROM seminar_user su
					WHERE su.user_id = ?");
	   $stmt->execute(array($user_id));
	   $count = $stmt->rowCount();
	   if($count == 1){
	   	 $sem = $stmt->fetch();
                 return $sem['seminar_id'];
	   }
	   else return false;
    }
		
}
