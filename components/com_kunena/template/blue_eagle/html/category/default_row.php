<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Category
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

// Disable caching
$this->cache = false;

// Show one topic row
?>
<?php if ($this->spacing) : ?>
<tr>
	<td class="kcontenttablespacer" colspan="<?php echo empty($this->topicActions) ? 5 : 6 ?>">&nbsp;</td>
</tr>
<?php endif; ?>

<tr class="<?php echo $this->getTopicClass('k', 'row') ?>">

	<!--
	<td class="kcol-first kcol-ktopicreplies hidden-phone">
		<strong><?php echo $this->formatLargeNumber ( max(0,$this->topic->getTotal()-1) ); ?></strong> <?php echo JText::_('COM_KUNENA_GEN_REPLIES') ?>
	</td>
	-->

	<!-- Avatar at the beggining -->
	<?php if (!empty($this->topic->avatar)) : ?>
			<td class="kcol-first kcol-ktopicreplies hidden-phone">
			<span class="ktopic-latest-post-avatar hidden-phone"> <?php echo $this->topic->getLastPostAuthor()->getLink( $this->topic->avatar ) ?></span>
			</td>
	<?php endif; ?>

	<td class="kcol-mid kcol-ktopicicon hidden-phone">
		<?php echo $this->getTopicLink ( $this->topic, 'unread', $this->topic->getIcon() ) ?>
	</td>

	<td class="kcol-mid kcol-ktopictitle">
    <div class="ktopic-details">
		<?php if ($this->topic->attachments) echo $this->getIcon ( 'ktopicattach', JText::_('COM_KUNENA_ATTACH') ); ?>
		<?php if ($this->topic->poll_id) echo $this->getIcon ( 'ktopicpoll', JText::_('COM_KUNENA_ADMIN_POLLS') ); ?>

		<div class="ktopic-title-cover">
			<?php
			echo $this->getTopicLink ( $this->topic, null, null, KunenaHtmlParser::stripBBCode ( $this->topic->first_post_message, 500), 'ktopic-title km' );
			if ($this->topic->getUserTopic()->favorite) {
				echo $this->getIcon ( 'kfavoritestar', JText::_('COM_KUNENA_FAVORITE') );
			}
			if ($this->me->exists() && $this->topic->getUserTopic()->posts) {
				echo $this->getIcon ( 'ktopicmy', JText::_('COM_KUNENA_MYPOSTS') );
			}
			if ($this->topic->unread) {
				echo $this->getTopicLink ( $this->topic, 'unread', '<sup dir="ltr" class="knewchar">(' . $this->topic->unread . ' ' . JText::_('COM_KUNENA_A_GEN_NEWCHAR') . ')</sup>' );
			}
			?>
		</div>
        <div class="ktopic-details-kcategory">
			<?php if (!isset($this->category) || $this->category->id != $this->topic->getCategory()->id) : ?>
			<span class="ktopic-category"> <?php echo JText::sprintf('COM_KUNENA_CATEGORY_X', $this->getCategoryLink ( $this->topic->getCategory() ) ) ?></span>
			<?php endif; ?>
        </div>
         <div class="ktopic-details-kcategory">
         	<!--
			<span class="ktopic-posted-time" title="<?php echo KunenaDate::getInstance($this->topic->first_post_time)->toKunena('config_post_dateformat_hover'); ?>">
				<?php echo JText::_("Project posted ") . ' ' . KunenaDate::getInstance($this->topic->first_post_time)->toKunena('config_post_dateformat');?>
			</span>
			<span class="ktopic-by ks"><?php echo JText::_('COM_KUNENA_BY') . ' ' . $this->topic->getFirstPostAuthor()->getLink() ?></span>
			-->
			<span class="ktopic-posted-time" title="<?php echo KunenaDate::getInstance($this->topic->first_post_time)->toKunena('config_post_dateformat_hover'); ?>">
				<?php
				echo JText::_(KunenaHtmlParser::stripBBCode($this->topic->first_post_message,500));?>
			</span>
		  </div>

        <div class="ktopic-details-kcategory" style="clear:both;">
		<?php if ($this->pages > 1) : ?>
		<ul class="kpagination">
			<li class="page"><?php echo JText::_('COM_KUNENA_PAGE') ?></li>
			<li><?php echo $this->GetTopicLink ( $this->topic, 0, 1 ) ?></li>
			<?php if ($this->pages > 4) : $startPage = $this->pages - 3; ?>
			<li class="more">...</li>
			<?php else: $startPage = 1; endif;
			for($hopPage = $startPage; $hopPage < $this->pages; $hopPage ++) : ?>
			<li><?php echo $this->getTopicLink ( $this->topic, $hopPage, $hopPage+1 ) ?></li>
			<?php endfor; ?>
		</ul>
		<?php endif; ?>
		</div>

		<?php if (!empty($this->keywords)) : ?>
		<div class="ktopic-keywords">
			<?php echo JText::sprintf('COM_KUNENA_TOPIC_TAGS', $this->escape($this->keywords)) ?>
		</div>
		<?php endif; ?>
	  </div>
	</td>

	<!--
	<td class="kcol-mid kcol-ktopicviews visible-desktop">
		<span class="ktopic-views-number"><?php echo $this->formatLargeNumber ( $this->topic->hits );?></span>
		<span class="ktopic-views"> <?php echo JText::_('COM_KUNENA_GEN_HITS');?> </span>
	</td>
	-->

	<td class="kcol-mid kcol-ktopiclastpost">
		<div class="klatest-post-info">
			

			<span class="ktopic-latest-post">
			<?php
			//echo $this->getTopicLink ( $this->topic, 'last', JText::_('COM_KUNENA_GEN_LAST_POST') );
			$db = JFactory::getDBO();
			$message_id = $this->topic->id;
			$db->setQuery ( "SELECT id FROM #__kunena_messages WHERE thread=$message_id" );
			$id_from_db = $db->loadResult();
			$db->setQuery ( "SELECT positions FROM #__kunena_messages WHERE id=$id_from_db" );
			$db_result_message = $db->loadResult ();
			echo JText::_(KunenaHtmlParser::stripBBCode($db_result_message,500))
			//echo ' ' . JText::_("Looking for Positions list will go here when i get it working");
			?>
			</span>
         </div>
         <!--
         <div class="klatest-post-info">
			<span class="ktopic-date"  title="<?php echo KunenaDate::getInstance($this->topic->last_post_time)->toKunena('config_post_dateformat_hover'); ?>">
				<?php echo KunenaDate::getInstance($this->topic->last_post_time)->toKunena('config_post_dateformat'); ?>
			</span>
		</div>
		-->
	</td>
	
<td class="kcol-mid ktopicmoderation"><?php $authorid = $this->topic->getLastPostAuthor()->id; echo '<a href= "../index.php?option=com_uddeim&task=new&recip='.$authorid.'&Itemid=123">';?><img src="../components/com_kunena/template/blue_eagle/media/iconsets/profile/default/envelope_icon_small.png" Title="Send this user a message"></a></td>
<?php if (!empty($this->topicActions)) : ?>
	<td class="kcol-mid ktopicmoderation"><input class ="kcheck" type="checkbox" name="topics[<?php echo $this->topic->id?>]" value="1" /></td>
<?php endif; ?>
</tr>
<!-- Module position -->
<?php if ($this->module) : ?>
<tr>
	<td class="ktopicmodule" colspan="<?php echo empty($this->topicActions) ? 5 : 6 ?>"><?php echo $this->module; ?></td>
</tr>
<?php endif; ?>
