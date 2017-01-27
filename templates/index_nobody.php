<?
# Lifter010: TODO
?>
<!-- Startseite (nicht eingeloggt) -->
<? if ($logout) : ?>
    <?= MessageBox::success(_("Sie sind nun aus dem System abgemeldet."), array($GLOBALS['UNI_LOGOUT_ADD'])) ?>
<? endif; ?>

<div class="index_main">
    <div id="wrapper" style="z-index:1; position:absolute; height:300px;"> 
 		        <div class="slider-wrapper"> 
 		                    <div id="slider" class="nivoSlider"> 
 		                <img src="plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/slide1.png" data-transition="fade">  
 		                <img src="plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/slide2.png" data-transition="fade">  
 		                <img src="plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/slide3.png" data-transition="fade">  
 		                <img src="plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/slide4.png" data-transition="fade"> 
 		            </div> 
 		        </div>   
 		        </div>   

<nav style="position:absolute; z-index:2; margin-top:235px">
   
 		         
 		        
 		     
 		       

	<? foreach (Navigation::getItem('/login') as $key => $nav) : ?>
            <? if ($nav->isVisible()) : ?>
                <? list($name, $title) = explode(' - ', $nav->getTitle()) ?>
                <div class="login_link">
                    <? if (is_internal_url($url = $nav->getURL())) : ?>
                        <a href="<?= URLHelper::getLink($url) ?>">
                    <? else : ?>
                        <a href="<?= htmlReady($url) ?>" target="_blank">
                    <? endif ?>
                    <? SkipLinks::addLink($name, $url) ?>
                        <?= htmlReady($name) ?>
                            <p>
                                <?= htmlReady($title ? $title : $nav->getDescription()) ?>
                            </p>
                        </a>
                </div>
            <? endif ?>
        <? endforeach ?>

	


    </nav>
   
    <footer>
        <? if ($GLOBALS['UNI_LOGIN_ADD']) : ?>
            <div class="uni_login_add">
                <?= $GLOBALS['UNI_LOGIN_ADD'] ?>
            </div>
        <? endif; ?>

        <table class="login_info">
            <tr>
                <td>
                    <?= _("Aktive Veranstaltungen") ?>
                </td>
                <td>
                    <?= $num_active_courses ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?= _("Registrierte NutzerInnen") ?>
                </td>
                <td>
                    <?= $num_registered_users ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?= _("Davon online") ?>
                </td>
                <td>
                    <?= $num_online_users ?>
                </td>
            </tr>

            <tr>
                <td>
                    <? foreach ($GLOBALS['INSTALLED_LANGUAGES'] as $temp_language_key => $temp_language): ?>
                        <a href="index.php?set_language=<?= $temp_language_key ?>">
                            <img src="<?= $GLOBALS['ASSETS_URL'] ?>images/languages/<?= $temp_language['picture'] ?>" border="0" <?= tooltip($temp_language['name']) ?>>
                        </a>
                    <? endforeach; ?>
                </td>
                <td>
                    <a href="dispatch.php/siteinfo/show">
                        <?= _("mehr") ?>...
                    </a>
                </td>
            </tr>
        </table>

        <a href="http://www.kvhs-ammerland.de">
            <img src="<?= $GLOBALS['ASSETS_URL'] ?>images/logos/logoklein.jpg" border="0" width="83" height="83"  <?= tooltip(_("Zur Portalseite")) ?> >
        </a>
    </footer>


<? UrlHelper::bindLinkParam('index_data', $index_data); 
 		 
 		    //Auf und Zuklappen News 
 		    //require_once 'lib/showNews.inc.php'; 
 		    //process_news_commands($index_data); 
 		 
 		    //show_news('studip', FALSE, 0, true, "100%", null, $index_data); 
?> 

</div>


<?
define('MAGPIE_CACHE_DIR', 'cache');
define('MAGPIE_CACHE_AGE', '600');
require_once('lib/rss_fetch.inc');
$url = 'http://el4.elan-ev.de/rss.php?id=70cefd1e80398bb20ff599636546cdff';

if ( $url ) {
$num_items = 20;
$rss = fetch_rss( $url );
$items = array_slice($rss->items, 0,$num_items);
$items_reverse = array_reverse($items, true);
} 
?>

<table id='feed' class='index_box' style='width: 100%;margin-top:15px'>
<tr>
<td class="table_header_bold"><b> News und Infos </b></td><tr>

<?
foreach ($items_reverse as $item) {
	$href = $item['link'];
	$title = $item['title'];
	$description = $item['description'];
	$arr = array("<div>","</div>","<p>","</p>");
	$description_clean = str_replace($arr," ",$description);
	echo "<tr> <td class='blank' style='padding:20px'><h1>$title</h1><br/> $description_clean </td></tr>";
	echo "</table>";
	echo "<table class='index_box' style='width: 100%;'>";
	
}
echo "</table>";
?> 

