<?php slot('firstRow'); ?>
<?php echo __('Exchange item'); ?>:<br />
<?php echo $pointItem->getName(); ?>(<?php echo $pointItem->getPoints(); ?>P)<br /><br />
</tr>
<?php end_slot(); ?>


<?php

$op = array();
$op['title'] = __('Exchange your points to the item');
$op['url'] = url_for('@pointExchange_form?id='.$pointItem->getId());
$op['firstRow'] = get_slot('firstRow');

op_include_form('pointExchangeForm', $form, $op);