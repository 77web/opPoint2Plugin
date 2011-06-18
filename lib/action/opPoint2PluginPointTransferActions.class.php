<?php

abstract class opPoint2PluginPointTransferActions extends sfActions
{
  public function preExecute()
  {
    if($this->getRoute() instanceOf sfDoctrineRoute)
    {
      $this->targetMember = $this->getRoute()->getObject();
      $isSelf = $this->targetMember->getId() == $this->getUser()->getMemberId();
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($this->targetMember->getId(), $this->getUser()->getMemberId());
      $blocked = $relation && $relation->getIsAccessBlock();var_dump($blocked);
      $this->forward404If($isSelf || $blocked);
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('point', 'history');
  }
  
  public function executeForm(sfWebRequest $request)
  {
    $this->form = new PointTransferForm();
    $this->form->setTargetMember($this->targetMember);
    $this->form->setCurrentMember($this->getUser()->getMember());
    
    if($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if($this->form->isValid())
      {
        $this->getUser()->setAttribute('pointTransfer', $this->form->getValues());
        $this->csrfForm = new BaseForm();
        
        return 'Confirm';
      }
    }
  }

  
  public function executeDo(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    $this->form = new PointTransferForm(array(), array(), false);
    $this->form->setTargetMember($this->targetMember);
    $this->form->setCurrentMember($this->getUser()->getMember());
    
    $this->form->bind($this->getUser()->getAttribute('pointTransfer', array()));
    if($this->form->isValid())
    {
      $this->form->save();
      $this->getUser()->setFlash('notice', 'Completed transfer');
    }
    
    $this->getUser()->setAttribute('pointTransfer', null);
    $this->redirect('point/history');
  }
}