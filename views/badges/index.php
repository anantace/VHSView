<?php 

PluginEngine::getPlugin('Courseware');
$sem_id;

foreach ($badges as $badge){
            
            $block = new \Mooc\DB\Block($badge['badge_block_id']);

            $seminar_id= $block->seminar_id;
            $this->course = new Course($seminar_id);
            $semTitle = ($sem_id != $seminar_id)? $this->course['Name'] : '' ;
            
            ?>

            <?= $semTitle ?' <h1>' . $semTitle . '</h1>': '' ?></h1>
            
            <?
            $field = current(Mooc\DB\Field::findBySQL('block_id = ? AND name = ?', array($block->id, 'file_id')));
            $file_id= $field->content;
            $field = current(\Mooc\DB\Field::findBySQL('block_id = ? AND name = ?', array($block->id, 'file_name')));
            $file_name= $field->content;
            $field = current(\Mooc\DB\Field::findBySQL('block_id = ? AND name = ?', array($block->id, 'download_title')));
            $badge_title= $field->content;
            ?>
                <div style='max-width:30%; float: left; padding: 15px'>
                    <p class='date'><?=$badge_title?> (<?=date('d.m.Y', $badge['mkdate'])?>)</p>
                <img style='max-width:100%' src='../../sendfile.php?type=0&file_id=<?=$file_id?>&file_name=<?=$file_name?>'>
                </div>       
<?
            $sem_id = $seminar_id;
        }

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

