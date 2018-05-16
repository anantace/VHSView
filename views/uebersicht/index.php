






<div class="tn_kacheln">
    
<? $kachelcount = 0; ?>
<article class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
           <h1> <?= Icon::create('community', 'info_alt', array('height' => '100'))?> Ihre DozentInnen</h1>
        </span>
</article>

<a href ="<?=URLHelper::getLink('dispatch.php/messages/overview')?>">
    <article id="messages_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
        <? $kachelcount++; ?>
        <span>
           <h1> <?= Icon::create('news', 'info_alt', array('height' => '100'))?> Termine und Aktuelles</h1>
        </span>
    </article>
</a>
    
<article id="news_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
        <h1><?= Icon::create('files', 'info_alt', array('height' => '100'))?> Dateien</h1>
    </span>
</article>


</div>