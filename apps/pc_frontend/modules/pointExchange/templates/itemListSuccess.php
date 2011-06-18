<?php slot('itemList'); ?>
<table>
  <?php foreach($itemList as $item): ?>
    <tr>
      <td class="image"></td>
      <td>
        <p><strong><?php echo link_to($item->getName(), '@pointExchange_form?id='.$item->getId()); ?></strong></p>
        <p><?php echo nl2br($item->getDescription()); ?></p>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php end_slot(); ?>

<?php op_include_box('pointExchangeItems', get_slot('itemList'), array('title'=>'Items to exchange your points')); ?>