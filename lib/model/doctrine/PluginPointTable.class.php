<?php

/**
 * PluginPointTable
 * @package    opPoint2Plugin
 * @subpackage model
 * @author     Hiromi Hishida <info@77-web.com>
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginPointTable extends Doctrine_Table
{
  public function getMemberHistoryPager($memberId, $size, $page = 1)
  {
    $query = $this->createQuery('p')->addWhere('p.member_id = ?', $memberId)->orderBy('p.created_at DESC');
    return $this->generatePager($query, $size, $page);
  }
  
  protected function generatePager(Doctrine_Query $query, $size, $page)
  {
    $pager = new sfDoctrinePager('Point', $size);
    $pager->setQuery($query);
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }
  
  public function getBalance($memberId)
  {
    $o = $this->createQuery('p')->select('SUM(p.rest_points) as psum')->where('p.member_id = ?', $memberId)->fetchOne();
    return $o->getPsum();
  }
}