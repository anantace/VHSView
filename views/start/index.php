<style>
.helpbar-container{
    display: none !important;
}
#layout_container{
    background-color: #ddd !important;
    background-image: linear-gradient(to bottom, #ddd, #ddd) !important;
}
#layout_content{
    background-color: #ddd !important;
    background-image: linear-gradient(to bottom, #ddd, #ddd) !important;
}

</style>






<div class="tn_kacheln">
    
<? $kachelcount = 0; ?>
<article id="profile_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <a href ="<?=URLHelper::getLink('dispatch.php/profile')?>">
	<?= Avatar::getAvatar($user_id)->getImageTag(Avatar::NORMAL,
array('style' => 'margin: 10px; max-width:225px; width:225px; height:225px; border: 1px solid #28497c;', 'title' => 'Mein Profil'));?>
    </a>
</article>


    <article id="messages_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
        <? $kachelcount++; ?>
        <div>
        <a href ="<?=URLHelper::getLink('dispatch.php/messages/overview')?>">
        <span>
           <h1> <?= Icon::create('mail', 'info_alt', array('height' => '100'))?> Nachrichten</h1>
        </span>
        </a>
        </div>
        <div class='messages' style = 'padding-top:35px'>
        <? foreach ($messages as $message) : ?>
        <?= $this->render_partial("_partials/_message_row.php", compact("message", "received". "settings")) ?>
        <? endforeach ?>
        </div>
    </article>

    
<article id="news_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
        <h1><?= Icon::create('news', 'info_alt', array('height' => '100'))?> Aktuelles</h1>
    </span>
</article>

<?php foreach ($courses as $cm): ?> 
    
<a href ="<?=URLHelper::getLink('seminar_main.php?auswahl=' . $cm->seminar_id)?>">    
<article class="kurs_kachel" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
        <h1><?= Icon::create('seminar', 'info_alt', array('height' => '100'))?> <?=$cm->course_name?></h1>
    </span>
</article>
</a>

    <?php endforeach ?>
</div>