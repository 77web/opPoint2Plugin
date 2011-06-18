<?php

/**
 * PluginPointExchangeTable
 * @package    opPoint2Plugin
 * @subpackage model
 * @author     Hiromi Hishida <info@77-web.com>
 */
class PluginPointExchangeTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginPointExchangeTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginPointExchange');
    }
}