<?php slot('balance'); ?>
  <font color="#ff0000"><?php echo (int)$balance; ?>P</font>
<?php end_slot(); ?>
<?php op_include_box('pointBalance', get_slot('balance'), array('title'=>__('Your current point balance'))); ?>


<?php if($pager->getNbResults() > 0): ?>
  <?php $list = array(); ?>
  <?php foreach($pager->getResults() as $point): ?>
    <?php $list[] = op_format_date($point->getCreatedAt(), 'XDateTimeJa').'<br />'.$point->getPoints().'P<br />'.$point->getMemo().'('.__('from %table%', array('%table%'=>$point->getForeignTable())).')'.($point->getExpiresAt() ? '<br />'.__('Expires: %date%', array('%date%' => op_format_date($point->getExpiresAt()))) : ''); ?>
  <?php endforeach; ?>
  <?php op_include_list('pointHistory', $list, array('title'=>__('Your point history'))); ?>
  <?php op_include_pager_total($pager, 'point/history?page=%s'); ?>
<?php else: ?>
  <?php op_include_box('pointHistory', __('No point history.'), array('title'=>__('Your point history'))); ?>
<?php endif; ?>

