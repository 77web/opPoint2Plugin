<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$browser = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));
$browser->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$browser->setMobile();
$browser->login('sns1@example.com', 'password');
$browser->setCulture('en');

$browser->get('/pointExchange')->isForwardedTo('pointExchange', 'itemList');

$browser->get('/pointExchange/itemList')
  ->isStatusCode(200)
  ->with('request')->begin()
    ->isParameter('module', 'pointExchange')
    ->isParameter('action', 'itemList')
  ->end()
;

$browser->info('request to inactive point item will be always forwarded to 404')
  ->get('/pointExchange/3')
    ->isStatusCode(404);

$browser->info('request to point item that has more than the user\'s current balance will be always forwarded to 404')
  ->get('/pointExchange/2')
    ->isStatusCode(404);

$browser->info('request to a item')
  ->get('/pointExchange/1')
    ->isStatusCode(200)
    ->with('request')->begin()
      ->isParameter('module', 'pointExchange')
      ->isParameter('action', 'form')
    ->end()
    ->setField('point_exchange[pref]', 'Aichi')
    ->setField('point_exchange[address]', 'Chikusa, Nagoya')
    ->setField('point_exchange[tel]', '052-000-0000')
    ->setField('point_exchange[real_name]', 'My Name')
    ->click('Send')
    ->isForwardedTo('pointExchange', 'form')
    ->with('response')->begin()
      ->isStatusCode(200)
      ->checkElement('#pointExchangeForm p', '/Are you sure/')
    ->end()
    ->click('Yes')
    ->isForwardedTo('pointExchange', 'do')
    ->with('response')->begin()
      ->isStatusCode(302)
      ->isRedirected()
    ->end()
    ->followRedirect()
    ->with('request')->begin()
      ->isParameter('module', 'point')
      ->isParameter('action', 'history')
    ->end()
    ->isStatusCode(200)
;