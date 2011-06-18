<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$browser = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));
$browser->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$browser->setMobile();
$browser->login('sns1@example.com', 'password');
$browser->setCulture('en');


$browser->get('/pointTransfer/1')->isStatusCode(404);

$browser->info('transfer to a friend')->get('/pointTransfer/2')
  ->isStatusCode(200)
  ->with('request')->begin()
    ->isParameter('module', 'pointTransfer')
    ->isParameter('action', 'form')
  ->end()
  ->setField('point_transfer[points]', 50)
  ->click('Send')
  ->isForwardedTo('pointTransfer', 'form')
  ->with('response')->begin()
    ->isStatusCode(200)
    ->checkElement('#pointTransferForm p', '/Are you sure/')
  ->end()
    ->click('Yes')
    ->isForwardedTo('pointTransfer', 'do')
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

$browser->info('transfer to a member')->get('/pointTransfer/3')
  ->isStatusCode(200)
  ->with('request')->begin()
    ->isParameter('module', 'pointTransfer')
    ->isParameter('action', 'form')
  ->end()
  ->setField('point_transfer[points]', 50)
  ->click('Send')
  ->with('response')->begin()
    ->isStatusCode(200)
    ->checkElement('#pointTransferForm p', '/Are you sure/')
  ->end()
    ->click('Yes')
    ->isForwardedTo('pointTransfer', 'do')
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


$browser->info('transfer to a member who blocks you(always 404)')
  ->get('/pointTransfer/4')
    ->isStatusCode(404)
  ->post('/pointTransfer/4')
    ->isStatusCode(404)
  ->post('/pointTransfer/4/do')
    ->isStatusCode(404)
;