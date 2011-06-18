<?php

class PointTransferForm extends BaseForm
{
  protected $currentMember;
  protected $targetMember;
  
  public function setup()
  {
    $this->setWidget('points', new sfWidgetFormInput());
    $this->setValidator('points', new sfValidatorInteger());
    
    $this->mergePostValidator(new sfValidatorCallback(array('callback'=>array($this, 'validatePointBalance'))));
    
    $this->getWidgetSchema()->setNameFormat('point_transfer[%s]');
    $this->getWidgetSchema()->getFormFormatter()->setTranslationCatalogue('form_pointTransfer');
  }
  
  public function validatePointBalance($validator, $values)
  {
    if($this->currentMember && isset($values['points']))
    {
      $balancePoints = Doctrine::getTable('Point')->getBalance($this->currentMember->getId());
      $orderPoints = $values['point'];
      if($orderPoints > $balancePoinst)
      {
        throw new sfValidatorError($validator, 'You do not have enough points.');
      }
    }
    return $values;
  }
  
  public function setTargetMember(Member $member)
  {
    $this->targetMember = $member;
  }

  public function setCurrentMember(Member $member)
  {
    $this->currentMember = $member;
  }
  
  public function getName()
  {
    return 'point_transfer';
  }
  
  public function save()
  {
    $point = $this->getValue('point');
    
    $con = Doctrine::getTable('Point')->getConnection();
    $con->beginTransaction();
    try
    {
      $givePoint = new Point();
      $givePoint->setMember($this->currentMember);
      $givePoint->setPoints(-1 * $point);
      $givePoint->save();
      
      $receivePoint = new Point();
      $receivePoint->setMember($this->targetMember);
      $receivePoint->setPoints($point);
      $receivePoint->setForeignTable('Point');
      $receivePoint->setForeignId($givePoint->getId());
      $receivePoint->save();
      
      $con->commit();
    }
    catch(Exception $e)
    {
      $con->rollback();
      throw $e;
    }
  }
}