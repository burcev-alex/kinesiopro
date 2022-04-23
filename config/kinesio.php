<?php

/*
 * All configuration options for site
 * http://kinesio.ru
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Access
    |--------------------------------------------------------------------------
    |
    | Configurations related to the grandstep's access/authorization options
    */
    'access' => [
        'captcha' => [
            'configs' => [
                'site_key' => env('INVISIBLE_RECAPTCHA_SITEKEY'),
                'secret_key' => env('INVISIBLE_RECAPTCHA_SECRETKEY'),
                'options' => [
                    'hidden' => false,
                    'location' => 'bottomright',
                    'timeout' => 5,
                ],
            ],
            'login' => env('LOGIN_CAPTCHA_STATUS', false),
            'registration' => env('REGISTRATION_CAPTCHA_STATUS', false),
        ],

        'middleware' => [
            'confirm' => 'password.confirm:auth.password.confirm',
            'verified' => 'verified:auth.verification.notice',
        ],

        'user' => [
            /*
             * Whether or not admins need 2FA enabled to visit the backend
             */
            'admin_requires_2fa' => env('ADMIN_REQUIRES_2FA', true),

            /*
             * Whether or not a user can change their email address after
             * their account has already been created
             */
            'change_email' => env('CHANGE_EMAIL', true),

            /*
             * When creating users from the backend, only allow the assigning of roles and not individual permissions
             */
            'only_roles' => false,

            /*
             * How many days before users have to change their passwords
             * false is off
             */
            'password_expires_days' => env('PASSWORD_EXPIRES_DAYS', 180),

            /*
             * The number of most recent previous passwords to check against when changing/resetting a password
             * false is off which doesn't log password changes or check against them
             *
             * Note: Enabling single_login will have an effect on this as it force changes the users password on login,
             * which will force a record into the password_histories table. I currently do not have a fix in mind.
             */
            'password_history' => env('PASSWORD_HISTORY', 3),

            /*
             * Whether or not a user can be permanently deleted from the system via the backend
             * The regular delete button will still exist, and will soft delete the user
             * but the permanently deleted button on the 'deleted users' screen will be hidden.
             */
            'permanently_delete' => false,

            /*
             * Whether or not the register route and view are active
             */
            'registration' => env('ENABLE_REGISTRATION', true),

            /*
             * When active, a user can only have one session active at a time
             * That is all other sessions for that user will be deleted when they log in
             * (They can only be logged into one place at a time, all others will be logged out)
             * AuthenticateSession middleware must be enabled
             */
            'single_login' => env('SINGLE_LOGIN', false),
        ],

        'role' => [

            /*
             * The name of the administrator role
             * Should be Administrator by design and unable to change from the backend
             * It is not recommended to change
             */
            'admin' => 'Administrator',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar
    |--------------------------------------------------------------------------
    |
    | Configurations related to the grandstep's avatar system
    */
    'avatar' => [

        /*
         * Default size of the avatar if none is supplied
         */
        'size' => 80,
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Whether or not to show the breadcrumb trail on the frontend
    | Note: Turning this off does not unregister the breadcrumbs in the routes file, it just hides the navbar
    */
    'frontend_breadcrumbs' => true,

    /*
    |--------------------------------------------------------------------------
    | Application Testing Mode
    |--------------------------------------------------------------------------
    |
    | When your application is currently running tests
    |
    */

    'internal_api_key' => env('INTERNAL_API_KEY', 'sS3DTvBKpFQ'),

    'testing' => env('APP_TESTING', false),

    'sberbank' => [
        'url' => (bool)env('SBERBANK_TEST_MODE', true) ? 'https://3dsec.sberbank.ru' : 'https://securepayments.sberbank.ru',
        'login' => env('SBERBANK_LOGIN', 'admin'),
        'password' => env('SBERBANK_PASSWORD', '123456'),
        'token' => env('SBERBANK_TOKEN', 'test123456')
    ],
];
