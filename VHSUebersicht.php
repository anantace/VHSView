<?php

require_once 'lib/PatchTemplateFactory.php';

class VHSUebersicht extends StudipPlugin implements StandardPlugin 
{

	CONST URL = "osnabrueck.elan-ev.de/";
	
	public function __construct() {
		
		parent::__construct();
		

	}
    
    public function getInfoTemplate ($course_id){
            
    }
   
    public function getIconNavigation ($course_id, $last_visit, $user_id){
            
    }
    
    public function getTabNavigation ($course_id){

        return array(
            'uebersicht' => new Navigation(
                'Übersicht',
                URLHelper::getURL('plugins.php/vhsviewplugin/uebersicht',array(), true),
                'uebersicht',
                true
            )
        );
    }
    
    public function getNotificationObjects ($course_id, $since, $user_id){
            
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
