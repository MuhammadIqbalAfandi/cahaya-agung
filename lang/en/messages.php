<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various
    | messages that we need to display to the user.
    |
     */

    'user' => [
        'active_user' => 'Successfully active the user',
        'no_active_user' => 'Successfully block user'
    ],

    'success' => [
        'email' => [
            'verify_email' => 'Email Verification link successfully sent'
        ],
        'store' => [
            'parking_fee' => 'Parking fee successfully added',
            'type_vehicle' => 'Type vehicle successfully added',
            'top_up' => 'Top Up successfully',
            'member' => 'Member successfully added',
            'type_member' => 'Jenis member successfully added',
            'discount' => 'Discount successfully added',
            'expense' => 'Expense successfully added',
            'transaction' => 'Transaction successfully added',
            'user' => 'User Account successfully added',
            'reset_password' => 'Password successfully reset',
            'customer' => 'Customer successfully addedd'
        ],
        'update' => [
            'type_vehicle' => 'Type vehicle successfully changed',
            'top_up' => 'Top Up successfully changed',
            'member' => 'Member successfully changed',
            'type_member' => 'Jenis member successfully changed',
            'change_password' => 'Password successfully changed',
            'transaction_status' => 'Transaction Status successfully changed',
            'user' => 'User Account successfully changed',
            'customer' => 'Customer successfully changed'
        ],
        'destroy' => [
            'type_member' => 'Jenis member successfully deleted',
            'type_vehicle' => 'Type vehicle successfully deleted',
            'top_up' => 'Top Up successfully deleted',
            'member' => 'Member Account successfully deleted',
            'user' => 'User Account successfully deleted'
        ]
    ],

    'error' => [
        'store' => [
            'top_up' => 'Top up failed to be added',
            'type_member' => 'Type member failed to be added',
            'member' => 'member failed to be added',
            'change_password' => 'Password invalid',
            'expense' => 'Expense failed to be added',
            'transaction' => 'Transaction failed to be added'
        ],
        'update' => [
            'type_member' => 'Type member failed to be changed',
            'member' => 'Member failed to be changed'
        ]
    ]
];
