<?php

abstract class opPoint2PluginPointActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('point', 'history');
  }
  
  public function executeHistory(sfWebRequest $request)
  {
    $this->size = sfConfig::get('app_point_history_limit');
    $this->page = $request->getParameter('page', 1);
    if($this->page < 1) $this->page = 1;
    
    $this->pager = Doctrine::getTable('Point')->getMemberHistoryPager($this->getUser()->getMemberId(), $this->size, $this->page);
    
    $this->balance = Doctrine::getTable('Point')->getBalance($this->getUser()->getMemberId());
  }
  
}