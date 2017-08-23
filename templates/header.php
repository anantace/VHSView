<?
# Lifter010: TODO
?>
<!-- Start Header -->
<div id="flex-header">
    <div id="header">
        <!--<div id='barTopLogo'>
            <?= Assets::img('logos/logoneu.jpg', array('alt' => 'Logo Uni Göttingen')) ?>
        </div>
         -->
        <div id="barTopFont">
        </div>
        
        <a href="http://www.kvhs-ammerland.de/index.php?id=6" title="Website kvhs Ammerland" target="_blank">
          <div id="wrapper" style="z-index:1; position:absolute; left:400px;overflow:hidden;width:751px;height:140px;"> 
 		        <div class="slider-wrapper"> 
 		                    <div id="slider" class="nivoSlider"> 
 		                <img src="<?= URLHelper::getLink("plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/bilda.jpg") ?>" data-transition="fade">  
 		                <img src="<?= URLHelper::getLink("plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/bildb.jpg") ?>" data-transition="fade">  
 		                <img src="<?= URLHelper::getLink("plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/slides/bildc.jpg") ?>" data-transition="fade"> 
                                    </div> 
 		        </div>
                        
              </div>
          <div id="wrapper2" style="z-index:2; position:absolute; top:10px; left:1000px;overflow:hidden;width:120px;height:120px;"> 
               <div class="slider-wrapper"> 
 		                    <div id="slider2" class="nivoSlider"> 
                                        <img src="<?= URLHelper::getLink("plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/logos/Logo-kvhs-1.gif") ?>" data-transition="fade"> 
                                        <img src="<?= URLHelper::getLink("plugins_packages/asudau@elan-ev.de/VHSViewPlugin/images/logos/Logo-ggmbh-1.gif") ?>" data-transition="fade"> 
 		        
                                    </div>   
                            </div>
                     </div>
           </a>
			
            
        <? SkipLinks::addIndex(_('Hauptnavigation'), 'barTopMenu', 1); ?>
        <ul id="barTopMenu" role="navigation">
            <? $accesskey = 0 ?>
            <? foreach (Navigation::getItem('/') as $path => $nav) : ?>
                <? if ($nav->isVisible(true)) : ?>
                    <?
                    $accesskey_attr = '';
                    $image = $nav->getImage();
                    $link_attributes = $nav->getLinkAttributes();

                    if ($accesskey_enabled) {
                        $accesskey      = ++$accesskey % 10;
                        $accesskey_attr = 'accesskey="' . $accesskey . '"';
                        $link_attributes['title'] .= "  [ALT] + $accesskey";
                    }

                    ?>
                    <li id="nav_<?= $path ?>"<? if ($nav->isActive()) : ?> class="active"<? endif ?>>
                        <a href="<?= URLHelper::getLink($nav->getURL(), $link_params) ?>" title="<?= $link_attributes['title'] ?>" <?= $accesskey_attr ?> data-badge="<?= (int)$nav->getBadgeNumber() ?>">
                            <?= $image->asImg(['class' => 'headericon original']) ?>
                            <br>
                            <?= htmlReady($nav->getTitle()) ?>
                        </a>
                    </li>
                <? endif ?>
            <? endforeach ?>
        </ul>
        <!-- Stud.IP Logo -->
    
    </div>
    
</div>

<!-- Leiste unten -->
<div id="barBottomContainer" <?= $public_hint ? 'class="public_course"' : '' ?>>
    <div id="barBottomLeft">
    <? if ($current_page): ?>
        <div class="current_page"><?= _('Aktuelle Seite:') ?></div>
    <? endif; ?>
    </div>
    <div id="barBottommiddle">
        <?= ($current_page != "" ? htmlReady($current_page) : "") ?>
        <?= $public_hint ? '(' . htmlReady($public_hint) . ')' : '' ?>
    </div>
    <!-- Dynamische Links ohne Icons -->
    <div id="barBottomright">
        <ul>
        <? if (is_object($GLOBALS['perm']) && PersonalNotifications::isActivated() && $GLOBALS['perm']->have_perm("autor")) : ?>
            <? $notifications = PersonalNotifications::getMyNotifications() ?>
            <? $lastvisit = (int)UserConfig::get($GLOBALS['user']->id)->getValue('NOTIFICATIONS_SEEN_LAST_DATE') ?>
            <li id="notification_container"<?= count($notifications) > 0 ? ' class="hoverable"' : "" ?>>
                <? foreach ($notifications as $notification) {
                    if ($notification['mkdate'] > $lastvisit) {
                        $alert = true;
                    }
                } ?>
                <div id="notification_marker"<?= $alert ? ' class="alert"' : "" ?> title="<?= _("Benachrichtigungen") ?>" data-lastvisit="<?= $lastvisit ?>">
                    <?= count($notifications) ?>
                </div>
                <div class="list below" id="notification_list">
                    <ul>
                        <? foreach ($notifications as $notification) : ?>
                            <?= $notification->getLiElement() ?>
                        <? endforeach ?>
                    </ul>
                </div>
                <? if (PersonalNotifications::isAudioActivated()) : ?>
                    <audio id="audio_notification" preload="none">
                        <source src="<?= Assets::url('sounds/blubb.ogg') ?>" type="audio/ogg">
                        <source src="<?= Assets::url('sounds/blubb.mp3') ?>" type="audio/mpeg">
                    </audio>
                <? endif ?>
            </li>
        <? endif ?>
        <? if (isset($search_semester_nr)) : ?>
            <li>
                           </li>
        <? endif ?>
        <? if (Navigation::hasItem('/links')): ?>
            <? foreach (Navigation::getItem('/links') as $nav): ?>
                <? if ($nav->isVisible()) : ?>
                    <li <? if ($nav->isActive()) echo 'class="active"'; ?>>
                        <a
                            <? if (is_internal_url($url = $nav->getURL())) : ?>
                                href="<?= URLHelper::getLink($url) ?>"
                            <? else: ?>
                                href="<?= htmlReady($url) ?>" target="_blank"
                            <? endif; ?>
                            <? if ($nav->getDescription()): ?>
                                title="<?= htmlReady($nav->getDescription()) ?>"
                            <? endif; ?>
                            ><?= htmlReady($nav->getTitle()) ?></a>
                    </li>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>
        </ul>
    </div>
</div>
<!-- Ende Header -->

