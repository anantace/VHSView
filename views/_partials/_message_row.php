<div class="<?= $message->isRead() || $message['autor_id'] === $GLOBALS['user']->id ? "" : "unread" ?>">
   
    <p><?= $message->getNumAttachments() ? Icon::create('staple', 'info', ["title" => _("Mit Anhang")])->asImg(20) : "" ?></p>
    <p class="title">
        <a href="<?= URLHelper::getLink("dispatch.php/messages/read/".$message->getId()) ?>" data-dialog>
            <?= $message['subject'] ? htmlReady($message['subject']) : htmlReady(mila($message['message'], 40)) ?>
        </a>
    </p>
    <p>
    <? if ($message['autor_id'] == "____%system%____") : ?>
        <?= _("Systemnachricht") ?>
    <? else : if(!$received): ?>
        <? $num_recipients = $message->getNumRecipients() ?>
        <? if ($num_recipients > 1) : ?>
            <?= sprintf(_("%s Personen"), $num_recipients) ?>
        <? else : ?>
        <a href="<?= URLHelper::getLink('dispatch.php/profile', array('username' =>  get_username($message->receivers[0]['user_id']))) ?>">
            <?= htmlReady(get_fullname($message->receivers[0]['user_id'])) ?>
        </a>
        <? endif ?>
    <? else: ?>
        <a href="<?= URLHelper::getLink('dispatch.php/profile', array('username' =>  get_username($message['autor_id']))) ?>">
            <?= htmlReady(get_fullname($message['autor_id'])) ?>
        </a>
    <? endif; ?>
    <? endif; ?>
    </p>
    <p><?= date("d.m.Y G:i", $message['mkdate']) ?></p>
    
</div>
