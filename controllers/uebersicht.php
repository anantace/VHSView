<?php

require_once 'app/controllers/news.php';


class UebersichtController extends StudipController {

    public $group_licenses = false;		



    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->current_plugin;

    }

    public function before_filter(&$action, &$args) {
        parent::before_filter($action, $args);
        
        //autonavigation
        Navigation::activateItem("course/uebersicht");
        PageLayout::setTitle(Course::findCurrent()->name . ' - Übersicht');

    }

    public function index_action() {
        global $user, $perm;
        $this->user_id = $user->id;
        
         global $user, $perm;
        $this->user_id = $user->id;
        
        if (true || $perm->have_studip_perm('dozent', $this->course->id)){
            $actions = new ActionsWidget();
            $actions->setTitle(_('Aktionen'));

            $actions->addLink(
            'Einstellungen',
            $this->url_for('start/settings'),'icons/16/blue/add.png'); 

            Sidebar::get()->addWidget($actions);
        }
        
        
        $this->courses = $user->course_memberships;
        //foreach ($courses as $cm){
            //if ($cm->seminar_id == '7637bfed08c7a2a3649eed149375cbc0');
    }

 public function overview_action() {
	
	
    }

 public function members_action() {
	$this->dozenten = $this->sem->getMembers('dozent');
	$this->tutoren = $this->sem->getMembers('tutor');
	$this->autoren = $this->sem->getMembers('autor');
	$this->users = $this->sem->getMembers('user');
    }

 public function documents_action() {
	$this->documents = $this->getSeminarDocuments();

 }  
  
    public function showResult($vote) {
        if (Request::submitted('change') && $vote->changeable) {
            return false;
        }
        return $vote->userVoted() || in_array($vote->id, Request::getArray('preview'));
    }

    private function getSeminarDocuments(){
	// Dokumente 
 	$query = "SELECT dokument_id, filename, description, name FROM dokumente WHERE seminar_id='{$this->sem->getId()}'"; 
        
	$documents;    
 	$l = 0; 
 	$statement = DBManager::get()->prepare($query); 
 	$statement->execute(); 

 	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { 

 		if ($row['name']){ 
 			$documents[$l]['DOCUMENT_TITLE'] = htmlReady($row['name']); 
 	       } 
		if ($row['filename']){ 
 			$documents[$l]['DOCUMENT_FILENAME'] = htmlReady($row['filename']); 
 	       } 

 	 	if ($row['dokument_id']){ 
 			$documents[$l]['DOCUMENT_ID'] = htmlReady($row['dokument_id']); 
 			//$content['LECTUREDETAILS']['DOCUMENTS']['DOCUMENT'][$l]['DOCUMENT_DOWNLOAD_URL'] = ExternModule::ExtHtmlReady($this->$db->f('file_id')); 
 		} 
		if ($row['description']){ 
 			$documents[$l]['DOCUMENT_DESCRIPTION'] = htmlReady($row['description']); 
 	       }
 	$l++; 
 	} 
	return $documents;
    }
    
/**
     * Widget controller to produce the formally known show_votes()
     *
     * @param String $range_id range id of the news to get displayed
     * @return array() Array of votes
     */
    public function display_action($range_id, $timespan = 604800, $start = null) {

        // Fetch time if needed
        $start = $start ? : strtotime('today');
        $context = get_object_type($range_id, array('user', 'sem'));
        if ($context === 'user') {
            $events = new DbCalendarEventList(new SingleCalendar($range_id, Calendar::PERMISSION_READABLE), $start, $start + $timespan, TRUE, Calendar::getBindSeminare($GLOBALS['user']->id), ($GLOBALS['user']->id == $range_id ? array() : array('CLASS' => 'PUBLIC')));

            // Prepare termine
            $this->termine = array();

            while ($termin = $events->nextEvent()) {
                // Adjust title
                if (date("Ymd", $termin->getStart()) == date("Ymd", time()))
                    $termin->title .= _("Heute") . date(", H:i", $termin->getStart());
                else {
                    $termin->title = substr(strftime("%a", $termin->getStart()), 0, 2);
                    $termin->title .= date(". d.m.Y, H:i", $termin->getStart());
                }

                if ($termin->getStart() < $termin->getEnd()) {
                    if (date("Ymd", $termin->getStart()) < date("Ymd", $termin->getEnd())) {
                        $termin->title .= " - " . substr(strftime("%a", $termin->getEnd()), 0, 2);
                        $termin->title .= date(". d.m.Y, H:i", $termin->getEnd());
                    } else {
                        $termin->title .= " - " . date("H:i", $termin->getEnd());
                    }
                }

                if ($termin->getTitle()) {
                    $tmp_titel = htmlReady(mila($termin->getTitle())); //Beschneiden des Titels
                    $termin->title .= ", " . $tmp_titel;
                }

                // Store for view
                $this->termine[] = array(
                    'id' => $termin->id,
                    'chdate' => $termin->chdate,
                    'title' => $termin->title,
                    'description' => $termin->description,
                    'room' => $termin->getLocation(),
                    'seminar_id' => $termin instanceOf SeminarEvent ? $termin->getSeminarId() : '',
                    'info' => $termin instanceOf SeminarEvent ? array() :
                    array(
                        _('Kategorie') => $termin->toStringCategories(),
                        _('Priorität') => $termin->toStringPriority(),
                        _('Sichtbarkeit') => $termin->toStringAccessibility(),
                        $termin->toStringRecurrence())
                );
            }
        }
        if ($context === 'sem') {
            // Fetch normal dates
            $course = Course::find($range_id);
            $dates = $course->getDatesWithExdates()->findBy('end_time',  array($start, $start + $timespan), '><');
            foreach ($dates as $courseDate) {

                // Build info
                $info = array();
                if ($courseDate->dozenten[0]) {
                    $info[_('Durchführende Dozenten')] = join(', ', $courseDate->dozenten->getFullname());
                }
                if ($courseDate->statusgruppen[0]) {
                    $info[_('Beteiligte Gruppen')] = join(', ', $courseDate->statusgruppen->getValue('name'));
                }

                // Store for view
                $this->termine[] = array(
                    'id' => $courseDate->id,
                    'chdate' => $courseDate->chdate,
                    'title' => $courseDate->getFullname() . ($courseDate->topics[0] ? ', '.join(', ', $courseDate->topics->getValue('title') ): ""),
                    'description' => $courseDate instanceOf CourseExDate ? $courseDate->content : '',
                    'topics' => $courseDate->topics->toArray('title description'),
                    'room' => $courseDate->getRoomName(),
                    'info' => $info
                );
            }
        }

        // Check permission to edit
        $this->admin = $range_id == $GLOBALS['user']->id || $GLOBALS['perm']->have_studip_perm('tutor', $range_id);

        // Forge title
        if ($this->termine) {
            $this->title = sprintf(_("Termine für die Zeit vom %s bis zum %s"), strftime("%d. %B %Y", $start), strftime("%d. %B %Y", $start + $timespan));
        } else {
            $this->title = _('Termine');
        }

        // Set range_id
        $this->range_id = $range_id;

        // Check out if we are on a profile
        if ($this->admin) {
            $this->isProfile = $context === 'user';
        }

    }
    
     // customized #url_for for plugins
    public function url_for($to)
    {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->current_plugin, $params, join('/', $args));
    }
    

}
