<?php

$app->get('/', 'App\Controller\Info');

$app->group('/api', function() {
    $this->post('/user', 'App\Controller\Api\User\Create');
    $this->post('/user/{id:\d+}', 'App\Controller\Api\User\Update');

    $this->post('/customer/region', 'App\Controller\Api\Customer\Region\Create');
    $this->post('/customer/region/{id:\d+}', 'App\Controller\Api\Customer\Region\Update');
    $this->post('/customer/region/{id:\d+}/country', 'App\Controller\Api\Customer\Region\Country\Create');
    $this->post('/customer/country/{id:\d+}', 'App\Controller\Api\Customer\Region\Country\Update');
    $this->post('/customer/type', 'App\Controller\Api\Customer\Type\Create');
    $this->post('/customer/type/{id:\d+}', 'App\Controller\Api\Customer\Type\Update');
    $this->delete('/customer/extra/{id:\d+}', 'App\Controller\Api\Customer\Extra\Delete');
    $this->post('/customer', 'App\Controller\Api\Customer\Create');
    $this->post('/customer/{id:\d+}', 'App\Controller\Api\Customer\Update');

    $this->post('/product','App\Controller\Api\Product\Create');
    $this->post('/product/{id:\d+}','App\Controller\Api\Product\Update');
    $this->post('/product/component', 'App\Controller\Api\Product\Component\Create');
    $this->post('/product/component/{id:\d+}', 'App\Controller\Api\Product\Component\Update');
    $this->delete('/product/component/{id:\d+}', 'App\Controller\Api\Product\Component\Delete');
});

$app->get('/customer', 'App\Controller\Web\Customer\Index')->setName('customer.index');
$app->get('/customer/new', 'App\Controller\Web\Customer\Create')->setName('customer.new');
$app->get('/customer/{id:\d+}', 'App\Controller\Web\Customer\Show');
$app->get('/customer/{id:\d+}/edit', 'App\Controller\Web\Customer\Edit');
$app->get('/customer/type', 'App\Controller\Web\Customer\Type\Index')->setName('customer.component');

$app->get('/user', 'App\Controller\Web\User\Index')->setName('user.index');
$app->get('/user/new', 'App\Controller\Web\User\Create')->setName('user.new');
$app->get('/user/{id:\d+}', 'App\Controller\Web\User\Show');


$app->get('/product', 'App\Controller\Web\Product\Index')->setName('product.index');
$app->get('/product/category', 'App\Controller\Web\Product\ComponentShow')->setName('product.category');
$app->get('/product/{id:\d+}','App\Controller\Web\Product\Show')->setName('product.edit');
$app->get('/product/new','App\Controller\Web\Product\Create')->setName('product.new');
