<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Notification route
    |--------------------------------------------------------------------------
    |
    | Here you may specify the route to the notification where CashBill sends 
    | payment statuses. The specified route has an /api prefix. 
    | For example, for /cashbill/notification, the full path will be /api/cashbill/notification.
    |
    */
    'notification_route' => '/cashbill/notification',
    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    | Here you may specify the CashBill endpoint mode. 
    | Possible values: dev, prod. 
    | Use 'dev' for testing and 'prod' for a live application.
    |
    */
    'mode' => env('CASHBILL_MODE', 'dev'),
    /*
    |--------------------------------------------------------------------------
    | Shop ID
    |--------------------------------------------------------------------------
    |
    | Here you may specify the SHOP ID from your CashBill account settings.
    |
    */
    'shop_id' => env('CASHBILL_SHOP_ID', ''),
    /*
    |--------------------------------------------------------------------------
    | Secret key
    |--------------------------------------------------------------------------
    |
    | This key is used in the sign. It's important to keep it safe. 
    | You can get it from your CashBill account settings.
    |
    */
    'secret_key' => env('CASHBILL_SECRET_KEY', ''),
    /*
    |--------------------------------------------------------------------------
    | Testing URL
    |--------------------------------------------------------------------------
    |
    | This is the URL address that initiates the test transaction.
    |
    */
    'testing_url' => 'https://pay.cashbill.pl/testws/rest/',
    /*
    |--------------------------------------------------------------------------
    | Production URL
    |--------------------------------------------------------------------------
    |
    | This is the URL address that initiates the real transaction.
    |
    */
    'production_url' => 'https://pay.cashbill.pl/ws/rest/',
    /*
    |--------------------------------------------------------------------------
    | Default Return Route
    |--------------------------------------------------------------------------
    |
    | This is the route name where the user will be redirected after a successful transaction.
    | If left empty, the user will be redirected to the path: '/' or to the URL specified while creating the transaction.
    |
    */
    'default_return_route' => '',
    /*
    |--------------------------------------------------------------------------
    | Default Negative Return Route
    |--------------------------------------------------------------------------
    |
    | This is the route name where the user will be redirected after a unsuccessful transaction.
    | If left empty, the user will be redirected to the default return route
    |
    */
    'default_negative_return_route' => '',
    /*
    |--------------------------------------------------------------------------
    | Default currency
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default currency used.
    |
    */
    'default_currency' => 'PLN',
    /*
    |--------------------------------------------------------------------------
    | Route enabled
    |--------------------------------------------------------------------------
    |
    | Here you may enable or disable notification route. 
    | If the route is disabled, payment verification is not possible.
    |
    */
    'route_enabled' => true,
    /*
    |--------------------------------------------------------------------------
    | Table name
    |--------------------------------------------------------------------------
    |
    | Here you may specify table name with transactions
    |
    */
    'table_name' => 'cashbill_transactions',
    /*
    |--------------------------------------------------------------------------
    | Personal Data
    |--------------------------------------------------------------------------
    |
    | Here you may specify Personal data columns that should be collected
    |
    */
    'personal_data_columns' => [
        'firstName',
        'surname',
        'email',
        'country',
        'city',
        'postcode',
        'street',
        'house',
        'flat',
        'ip'
    ],
    /*
    |--------------------------------------------------------------------------
    | Default status
    |--------------------------------------------------------------------------
    |
    | Default status that will be set for transaction at the beginning
    |
    */
    'default_status' => 'created',
    /*
    |--------------------------------------------------------------------------
    | Default language
    |--------------------------------------------------------------------------
    |
    | Here you can specify default language for transaction
    | Possible values: PL, EN
    |
    */
    'default_language' => 'PL'
];
