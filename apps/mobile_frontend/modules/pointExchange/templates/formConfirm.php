<?php slot('firstRow'); ?>
<p><?php echo __('Are you sure to get this item for your %order_points% points?', array('%order_points%'=>$pointItem->getPoints())); ?></p>

  <?php echo __('Exchange item'); ?>:<br />
  <?php echo $pointItem->getName(); ?>(<?php echo $pointItem->getPoints(); ?>P)<br /><br />
  
  <?php echo __('Address to ship', array(), 'form_pointExchange'); ?>:<br />
   <p><?php echo $form->getValue('pref'); ?> <?php echo $form->getValue('address'); ?></p>
    <p><?php echo $form->getValue('real_name'); ?></p>
    <p><?php echo $form->getValue('tel'); ?></p>
<?php end_slot(); ?>


<?php

$op = array();
$op['title'] = __('Exchange your points to the item');
$op['yes_url'] = url_for('@pointExchange_do?id='.$pointItem->getId());
$op['no_url'] = url_for('pointExchange/itemList');
$op['no_method'] = 'get';

$op['body'] = get_slot('firstRow');
$op['class'] = 'form';

op_include_yesno('pointExchangeForm', $csrfForm, $csrfForm, $op);