<?php

/**
 * PluginPointItemTable
 * @package    opPoint2Plugin
 * @subpackage model
 * @author     Hiromi Hishida <info@77-web.com>
 */
class PluginPointItemTable extends Doctrine_Table
{
  public function getAll()
  {
    return $this->createQuery('i')->addWhere('i.is_active = ?', true)->orderBy('i.points')->execute();
  }
}