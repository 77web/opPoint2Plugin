<?php slot('firstRow'); ?>
<tr>
  <th><?php echo __('Target member', array(), 'form_pointTransfer'); ?></th>
  <td><?php echo $targetMember->getName(); ?></td>
</tr>
<?php end_slot(); ?>


<?php

$op = array();
$op['title'] = __('Transfer your points to another member');
$op['url'] = url_for('@pointTransfer_form?id='.$targetMember->getId());
$op['firstRow'] = get_slot('firstRow');

op_include_form('pointTransferForm', $form, $op);