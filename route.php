<?php

$route=[
    // default route is "Index"
    'Index'=>'index/index',
    'Dashboard'=>'index/dash',
    'Logout'=>'loginmanage/logout',
    'Register'=>'loginmanage/register',
    'Login'=>   ['Index' => 'loginmanage/login',
                 '2FA'   => 'loginmanage/2FA'],
    'Domain' => ['Search-Domains'   => 'domain/registration-default',
                 'Renew-Domains'    => 'domain/renew',
                 'Transfer-Domains' => 'domain/transfer-default',
                 'Transfer-Manager' => 'domain/transfer-manager',
                 'Domains-To-Cart'  => 'domain/to-cart',
                 'Price'            => 'domain/price',
                 'Manager'          =>['Index'=>'domain/manage/list',
                                       'Renewal'=>'domain/manage/renew',
                                       'View'=>'domain/manage/view']],
    'Service' => [  'List-Plans'    => 'service/order/list',
                    'ConfProduct'   => 'service/order/conf',
                    'Manager'       => 'service/manager/list',
                    'Details'       => ['Index'=>'service/manager/view',
                                        'Renewal'=>'service/manager/renew']],

    'Invoice'=>['List'   =>'invoice/list',
                'View'   =>'invoice/view',
                'Payment'=>'invoice/payment',
                'Funds'  =>'invoice/funds'],
    'Contact'=>['List'   =>'contact/list',
                'Manage' =>'contact/manage',
                'Add'    =>'contact/add'],
    'Profile'=>['Index'     =>'profile/manage',
                '2FA'       =>'profile/2fa',
                'Password'  =>'profile/password'],
    'Cart'=>['View'     =>'cart/view',
//           'Add'      =>'cart/add',
//           'Remove'   =>'cart/remove',
             'Checkout' =>'cart/checkout'],
    'ecpay'=>['return'=>'ecpay/return',
              'info'=>'ecpay/info'],
              
    'Funds'=>['Index'=>'funds/view',
              'Add'=>'funds/add',
              'History'=>'funds/history'],

    'Free'=>['Order'=>'dev',
             'Auth'=>'dev',
             'Manager'=>'dev'],
              
    'Cron'=>'cron'

];