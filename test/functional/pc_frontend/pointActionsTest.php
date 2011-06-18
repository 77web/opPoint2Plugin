<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$browser = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));
$browser->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$browser->login('sns1@example.com', 'password');
$browser->setCulture('en');

$browser->get('/point')->isForwardedTo('point', 'history');


$browser->get('/point/history')
  ->isStatusCode(200)
  ->with('request')->begin()
    ->isParameter('module', 'point')
    ->isParameter('action', 'history')
  ->end()
;

$browser->get('/point/history?page=2')
  ->isStatusCode(200)
  ->with('request')->begin()
    ->isParameter('module', 'point')
    ->isParameter('action', 'history')
  ->end()
;