<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('/bannerssystem/banner');
$I->seeResponseCodeIs(403);
$I->see('Forbidden (#403)');

$I->setCookie('PHPSESSID', '784bf97b86be62ab898f22c15e12d745');

$I->amGoingTo('Check banners list page');
$I->amOnPage('/bannerssystem/banner');
$I->seeResponseCodeIs(200);
$I->see('Банерная система');

$I->amGoingTo('Check zones list page');
$I->amOnPage('/bannerssystem/zone/index');
$I->seeResponseCodeIs(200);
$I->see('Банерные места');

$I->amGoingTo('Check create page of zones');
$I->amOnPage('/bannerssystem/zone/create');
$I->seeResponseCodeIs(200);

$I->amGoingTo('Create zone');
$I->fillField(['id' => 'zone-title'], 'TestBanner');
$I->fillField(['id' => 'zone-width'], '100');
$I->fillField(['id' => 'zone-height'], '150');

$I->click('#w0 button[type=submit]');
$I->see('ID');
$I->see('TestBanner');
$I->see('100');
$I->see('150');
$I->see('Поочередно');
$I->see('Активный');

$I->seeInCurrentUrl('view');
$I->seeResponseCodeIs(200);

$I->amGoingTo('Check update zone page ');
$I->click('p .btn-primary');
$I->seeInCurrentUrl('update');
$I->seeResponseCodeIs(200);

$I->amGoingTo('Save zone');
$I->click('#w0 button[type=submit]');

$I->seeResponseCodeIs(200);
$id = $I->grabFromCurrentUrl('/view\?id=(\d+)/');
$csrf = $I->grabTextFrom('~<meta name="csrf-token" content="(.*?)"~');


$I->amGoingTo('Remove zone');
$I->sendAjaxPostRequest('/bannerssystem/zone/delete?id=' . $id, ['_csrf' => $csrf]);
$I->click('p .btn-primary');
$I->seeResponseCodeIs(404);

//======================================

$I->amGoingTo('Check create page of banners');
$I->amOnPage('/bannerssystem/banner/create');
$I->seeResponseCodeIs(200);


$I->amGoingTo('Create banner');
$I->fillField(['id' => 'banner-title'], 'TestBanner');
$I->fillField(['id' => 'banner-link'], 'http://test.lnk');
$I->fillField(['id' => 'banner-html'], 'bannerHtml');

$I->click('#w0 button[type=submit]');
$I->see('ID');
$I->see('TestBanner');
$I->see('bannerHtml');
$I->see('Активный');

$I->seeInCurrentUrl('view');
$I->seeResponseCodeIs(200);

$I->amGoingTo('Check update banner page ');
$I->click('p .btn-primary');
$I->seeInCurrentUrl('update');
$I->seeResponseCodeIs(200);

$I->amGoingTo('Save banner');
$I->click('#w0 button[type=submit]');

$I->seeResponseCodeIs(200);
$id = $I->grabFromCurrentUrl('/view\?id=(\d+)/');
$csrf = $I->grabTextFrom('~<meta name="csrf-token" content="(.*?)"~');

$I->amGoingTo('Remove banner');
$I->sendAjaxPostRequest('/bannerssystem/banner/delete?id=' . $id, ['_csrf' => $csrf]);
$I->click('p .btn-primary');
$I->seeResponseCodeIs(404);
