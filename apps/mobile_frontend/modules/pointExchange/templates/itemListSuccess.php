
<?php $list = array(); ?>
<?php foreach($itemList as $item): ?>
  <?php $list[] = link_to($item->getName(), '@pointExchange_form?id='.$item->getId()).'<br />'.nl2br($item->getDescription());
<?php endforeach; ?>

<?php op_include_list('pointExchangeItems', $list, array('title'=>'Items to exchange your points')); ?>