<?php

class BadgesController extends StudipController {

      public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;

    }
    
     private function set_title($title = '')
    {
        $title_parts   = func_get_args();
        $title_parts[] = $GLOBALS['SessSemName']['header_line'];
        $page_title    = implode(' - ', $title_parts);

        PageLayout::setTitle($page_title);
    }
    
    public function before_filter(&$action, &$args){
         if (Navigation::hasItem('/profile/badges')) {
            Navigation::activateItem('/profile/badges');
        }
        
        $this->set_layout($GLOBALS['template_factory']->open('layouts/base'));
    }

    // default action; just shows the complete courseware at the
    // selected block's page
    public function index_action()
    {
        $values = array('user_id' => Request::get('user_id'));
        $query = "SELECT * FROM `mooc_badges` WHERE `user_id` LIKE :user_id" ;
	$statement = \DBManager::get()->prepare($query);
	$statement->execute($values);
        $this->badges = $statement->fetchAll(\PDO::FETCH_ASSOC);
         
    }


}
