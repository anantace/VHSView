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
array('style' => 'margin: 10px; max-width:225px; width:225px; height:225px; border-radius: 10px; border: 1px solid #28497c;', 'title' => 'Mein Profil'));?>
    </a>
</article>

<a href ="<?=URLHelper::getLink('dispatch.php/messages/overview')?>">
    <article id="messages_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
        <? $kachelcount++; ?>
        <span>
            <h1>Nachrichten</h1>
        </span>
    </article>
</a>
    
<article id="news_kachel" class="general" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
        <h1>Neues</h1>
    </span>
</article>

<?php foreach ($courses as $cm): ?> 
    
<a href ="<?=URLHelper::getLink('dispatch.php/messages/overview/cid=' . $cm->seminar_id)?>">    
<article class="kurs_kachel" style='background:<?=$plugin->getVHSColors()[$kachelcount];?>'>
    <? $kachelcount++; ?>
    <span>
        <h1><?=$cm->course_name?></h1>
    </span>
</article>
</a>

    <?php endforeach ?>
</div>