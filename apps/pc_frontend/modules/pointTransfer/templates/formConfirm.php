<?php slot('firstRow'); ?>
<p><?php echo __('Are you sure to transfer these points?'); ?></p>
<table>
<tr>
  <th><?php echo __('Target member', array(), 'form_pointTransfer'); ?></th>
  <td><?php echo $targetMember->getName(); ?></td>
</tr>
<tr>
  <th><?php echo __('Transfer points', array(), 'form_pointTransfer'); ?></th>
  <td><?php echo $form->getValue('points'); ?></td>
</tr>
</table>
<?php end_slot(); ?>


<?php

$op = array();
$op['title'] = __('Transfer your points to another member');
$op['yes_url'] = url_for('@pointTransfer_do?id='.$targetMember->getId());
$op['no_url'] = url_for('@pointTransfer_form?id='.$targetMember->getId());
$op['no_method'] = 'get';

$op['body'] = get_slot('firstRow');


op_include_yesno('pointTransferForm', $csrfForm, $csrfForm, $op);