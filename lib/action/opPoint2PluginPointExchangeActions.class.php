<?php

abstract class opPoint2PluginPointExchangeActions extends sfActions
{
  public function preExecute()
  {
    if($this->getRoute() instanceOf sfDoctrineRoute)
    {
      $this->pointItem = $this->getRoute()->getObject();
      $balance = Doctrine::getTable('Point')->getBalance($this->getUser()->getMemberId());
      $this->forward404Unless($this->pointItem->getIsActive() && $this->pointItem->getPoints() <= $balance);
    }
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('pointExchange', 'itemList');
  }
  
  public function executeItemList(sfWebRequest $request)
  {
    $this->itemList = Doctrine::getTable('PointItem')->getAll();
  }
  
  public function executeForm(sfWebRequest $request)
  {
    $this->form = new PointExchangeForm();
    $this->form->setPointItem($this->pointItem);
    $this->form->getObject()->setMember($this->getUser()->getMember());
    
    if($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if($this->form->isValid())
      {
        $this->getUser()->setAttribute('pointExchange', $this->form->getValues());
        $this->csrfForm = new BaseForm();
        
        return 'Confirm';
      }
    }
  }

  
  public function executeDo(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    
    $this->form = new PointExchangeForm(array(), array(), false);
    $this->form->setPointItem($this->pointItem);
    $this->form->getObject()->setMember($this->getUser()->getMember());
    
    $this->form->bind($this->getUser()->getAttribute('pointExchange', array()));
    if($this->form->isValid())
    {
      $this->form->save();
      $this->getUser()->setFlash('notice', 'Completed a application of point exchange');
      
    }
    
    $this->getUser()->setAttribute('pointExchange', null);
    $this->redirect('point/history');
  }
}