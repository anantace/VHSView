<?
# Lifter010: TODO
?>
<!-- Start Header -->
<div id="flex-header">
    <div id="header">
        <!--<div id='barTopLogo'>
            <img src="<?=$GLOBALS['ASSETS_URL']?>images/logos/logoneu.jpg" alt="Logo Uni Göttingen">
        </div>
         -->
        <div id="barTopFont">
        <?= htmlReady($GLOBALS['UNI_NAME_CLEAN']) ?>
        </div>
        <? SkipLinks::addIndex(_("Hauptnavigation"), 'barTopMenu', 1); ?>
        <ul id="barTopMenu" role="navigation">
        <? $accesskey = 0 ?>
        <? foreach (Navigation::getItem('/') as $path => $nav) : ?>
            <? if ($nav->isVisible(true)) : ?>
                <?
                $accesskey_attr = '';
                $image = $nav->getImage();

                if ($accesskey_enabled) {
                    $accesskey = ++$accesskey % 10;
                    $accesskey_attr = 'accesskey="' . $accesskey . '"';
                    $image['title'] .= "  [ALT] + $accesskey";
                }

                ?>
                <li id="nav_<?= $path ?>"<? if ($nav->isActive()) : ?> class="active"<? endif ?>>
                    <a href="<?= URLHelper::getLink($nav->getURL(), $link_params) ?>" title="<?= $image['title'] ?>" <?= $accesskey_attr ?>>
                        <!--
                        <span style="background-image: url('<?= $image['src'] ?>'); background-size: auto 32px;" class="<?= $image['class'] ?>"> </span>
                        -->
                        <img class="headericon" src="<?= $image['src'] ?>" data-icon="<?= $image['src'] ?>" width="28" height="28" data-badge="<?= (int) $nav->getBadgeNumber() ?>" style="margin-left: 6px; margin-right: 6px; margin-top: 2px; margin-bottom: 2px;">
                        <canvas class="headericon"></canvas>
                        <canvas class="headericon highlighted"></canvas>
                        <br>
                       <?= htmlReady($nav->getTitle()) ?>
                   </a>
                </li>
            <? endif ?>
        <? endforeach ?>
        </ul>
    </div>
    <!-- Stud.IP Logo -->
    <a class="studip-logo" id="barTopStudip" href="http://www.studip.de/" title="Stud.IP Homepage" target="_blank">
        Stud.IP Homepage
    </a>
</div>

<!-- Leiste unten -->
<div id="barBottomContainer" <?= $public_hint ? 'class="public_course"' : '' ?>>
    <div id="barBottomLeft">
        <?=($current_page != "" ? _("Aktuelle Seite:") : "")?>
    </div>
    <div id="barBottommiddle">
        <?=($current_page != "" ? htmlReady($current_page) : "")?>
        <?= $public_hint ? '(' . htmlReady($public_hint) . ')' : '' ?>
    </div>
    <!-- Dynamische Links ohne Icons -->
    <div id="barBottomright">
        <ul>
            <? if (is_object($GLOBALS['perm']) && PersonalNotifications::isActivated() && $GLOBALS['perm']->have_perm("autor")) : ?>
            <? $notifications = PersonalNotifications::getMyNotifications() ?>
            <? $lastvisit = (int) UserConfig::get($GLOBALS['user']->id)->getValue('NOTIFICATIONS_SEEN_LAST_DATE') ?>
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
            <? if (Navigation::hasItem('/links')) : ?>
            <? foreach (Navigation::getItem('/links') as $nav) : ?>
                <? if ($nav->isVisible()) : ?>
                    <li <? if ($nav->isActive()) echo 'class="active"'; ?>>
                    <a
                    <? if (is_internal_url($url = $nav->getURL())) : ?>
                        href="<?= URLHelper::getLink($url, $link_params) ?>"
                    <? else : ?>
                        href="<?= htmlReady($url) ?>" target="_blank"
                    <? endif ?>
                    <? if ($nav->getDescription()): ?>
                        title="<?= htmlReady($nav->getDescription()) ?>"
                    <? endif; ?>
                    ><?= htmlReady($nav->getTitle()) ?></a>
                    </li>
                <? endif ?>
            <? endforeach ?>
            <? endif ?>
        </ul>
    </div>
</div>
<!-- Ende Header -->

