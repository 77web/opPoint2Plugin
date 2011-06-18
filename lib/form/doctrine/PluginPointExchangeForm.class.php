<?php

/**
 * PluginPointExchange form.
 *
 * @package    opPoint2Plugin
 * @subpackage form
 * @author     Hiromi Hishida<info@77-web.com>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPointExchangeForm extends BasePointExchangeForm
{
  protected $pointItem;
  
  public function setup()
  {
    parent::setup();
    
    unset($this['id']);
    $this->useFields(array('pref', 'address', 'tel', 'real_name'));
    
    
    $this->mergePostValidator(new sfValidatorCallback(array('callback'=>array($this, 'validatePointBalance'))));
    
    $this->getWidgetSchema()->getFormFormatter()->setTranslationCatalogue('form_pointExchange');
  }
  
  public function setPointItem(PointItem $item)
  {
    $this->pointItem = $item;
  }
  
  public function validatePointBalance($validator, $values)
  {
    if($this->getObject()->getMember() && $this->pointItem)
    {
      $balancePoints = Doctrine::getTable('Point')->getBalance($this->getObject()->getMember()->getId());
      $orderPoints = $this->pointItem->getPoints();
      if($orderPoints >= $balancePoints)
      {
        throw new sfValidatorError($validator, 'You do not have enough points to get the item.');
      }
    }
    return $values;
  }
  
  public function save($conn = null)
  {
    $conn = $this->getObject()->getTable()->getConnection();
    $conn->beginTransaction();
    try
    {
      $this->getObject()->setPointItemName($this->pointItem->getName());
      $this->getObject()->setPoints($this->pointItem->getPoints());
      $exchange = parent::save($conn);
      
      $points = $exchange->getPoints();
      $usePoint = new Point();
      $usePoint->setMember($exchange->getMember());
      $usePoint->setPoints(-1 * $points);
      $usePoint->setForeignTable('PointExchange');
      $usePoint->setForeignId($exchange->getId());
      $usePoint->save();
      
      $conn->commit();
    }
    catch(Exception $e)
    {
      $conn->rollback();
      throw $e;
    }
    
    
    
    return $exchange;
  }
}
