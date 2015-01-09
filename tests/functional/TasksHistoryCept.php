<?php
$I = new TestGuy($scenario);
$I->wantTo('Show task history');
$task = $I->haveTask(['id' => '1']);

$I->haveHttpHeader('Content-Type','application/json');
$I->sendGET("/task-history/{$task->id}?format=json");
$I->seeResponseCodeIs(200);
$I->seeResponseContainsJson();
