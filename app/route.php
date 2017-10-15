<?php

$app->get('/', 'App\Controller\Info');

$app->group('/api', function () {
    $this->post('/user', 'App\Controller\Api\User\Create');
    $this->post('/user/{id:\d+}', 'App\Controller\Api\User\Update');

    $this->post('/customer/region','App\Controller\Api\Customer\Region\Create');
    $this->post('/customer/region/{id:\d+}','App\Controller\Api\Customer\Region\Update');
    $this->post('/customer/region/{id:\d+}/country','App\Controller\Api\Customer\Region\Country\Create');
    $this->post('/customer/country/{id:\d+}','App\Controller\Api\Customer\Region\Country\Update');
    $this->post('/customer/type','App\Controller\Api\Customer\Type\Create');
    $this->post('/customer/type/{id:\d+}','App\Controller\Api\Customer\Type\Update');
    $this->delete('/customer/extra/{id:\d+}','App\Controller\Api\Customer\Extra\Delete');
    $this->post('/customer','App\Controller\Api\Customer\Create');
    $this->post('/customer/{id:\d+}','App\Controller\Api\Customer\Update');
});

$app->get('/customer','App\Controller\Web\Customer\Index');
$app->get('/customer/new','App\Controller\Web\Customer\Create');
$app->get('/customer/{id:\d+}','App\Controller\Web\Customer\Show');
$app->get('/customer/{id:\d+}/edit','App\Controller\Web\Customer\Edit');
$app->get('/customer/type','App\Controller\Web\Customer\Type\Index');

$app->get('/user','App\Controller\Web\User\Index');
$app->get('/user/new','App\Controller\Web\User\Create');
$app->get('/user/{id:\d+}','App\Controller\Web\User\Show');