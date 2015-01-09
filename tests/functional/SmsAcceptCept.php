<?php

$I = new TestGuy($scenario);
$I->wantTo('Recieve an accepted notification from Twillio and update status of task');
$I->haveHttpHeader("Content-type", "application/x-www-form-urlencoded");
$I->sendPost("/sms", ['From' => '+55555555555', 'Body' => 'Yes', 'MessageSid' => '8888888888888888888888888888888888', 'AccountSid' => '77777777777777777777777777777777777', 'To' => '123456789']);
$I->seeResponseCodeIs(200);
