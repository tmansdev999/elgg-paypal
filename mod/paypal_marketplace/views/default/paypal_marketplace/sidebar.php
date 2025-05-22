<?php

// Get current user's items if logged in
if (elgg_is_logged_in()) {
    $user_items = elgg_get_entities([
        'type' => 'object',
        'subtype' => 'paypal_marketplace_item',
        'owner_guid' => elgg_get_logged_in_user_guid(),
        'limit' => 5,
    ]);

    if ($user_items) {
        echo elgg_view_module('aside', elgg_echo('paypal_marketplace:sidebar:my_items'), elgg_view('paypal_marketplace/listing', [
            'items' => $user_items,
            'show_owner' => false,
        ]));
    }
}

// Get recent items
$recent_items = elgg_get_entities([
    'type' => 'object',
    'subtype' => 'paypal_marketplace_item',
    'limit' => 5,
    'order_by' => [
        new \Elgg\Database\Clauses\OrderByClause('time_created', 'DESC'),
    ],
]);

if ($recent_items) {
    echo elgg_view_module('aside', elgg_echo('paypal_marketplace:sidebar:recent'), elgg_view('paypal_marketplace/listing', [
        'items' => $recent_items,
    ]));
}

// Add PayPal Marketplace information
echo elgg_view_module('aside', elgg_echo('paypal_marketplace:sidebar:info'), elgg_view('paypal_marketplace/info')); 