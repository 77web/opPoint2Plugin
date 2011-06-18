<?php slot('balance'); ?>
  <table>
    <th><?php echo __('Point balance'); ?></th>
    <td><?php echo (int)$balance; ?>P</td>
  </table>
<?php end_slot(); ?>
<?php op_include_box('pointBalance', get_slot('balance'), array('title'=>__('Your current point balance'), 'class'=>'form')); ?>

<?php slot('history'); ?>
<?php if($pager->getNbResults() > 0): ?>
  <table>
    <?php foreach($pager->getResults() as $point): ?>
      <tr>
        <td><?php echo op_format_date($point->getCreatedAt(), 'XDateTimeJa'); ?></td>
        <td><?php echo $point->getPoints(); ?></td>
        <td><?php echo $point->getMemo(); ?>(<?php echo __('from %table%', array('%table%'=>$point->getForeignTable())); ?>)</td>
        <td><?php echo $point->getExpiresAt() ? op_format_date($point->getExpiresAt(), 'XDateTimeJa') : ''; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p><?php echo __('No point history.'); ?></p>
<?php endif; ?>
<?php end_slot(); ?>
<?php op_include_box('pointHistory', get_slot('history'), array('title'=>__('Your point history'))); ?>