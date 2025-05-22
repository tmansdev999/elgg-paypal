<?php

use Elgg\Exceptions\Http\EntityNotFoundException;

$title = elgg_echo('paypal_marketplace:all:title');

// Get filter options
$filter = get_input('filter', 'all');

// Build the page
$content = elgg_view_menu('filter:paypal_marketplace', [
    'class' => 'elgg-menu-hz',
]);

// Get items based on filter
$options = [
    'type' => 'object',
    'subtype' => 'paypal_marketplace_item',
    'limit' => 20,
    'offset' => get_input('offset', 0),
];

if ($filter !== 'all') {
    $options['metadata_name_value_pairs'] = [
        ['name' => 'transaction_type', 'value' => $filter],
    ];
}

$items = elgg_get_entities($options);

if ($items) {
    $content .= elgg_view('paypal_marketplace/listing', [
        'items' => $items,
    ]);
} else {
    $content .= elgg_echo('paypal_marketplace:no_items');
}

// Add create button if user is logged in
if (elgg_is_logged_in()) {
    elgg_register_menu_item('title', [
        'name' => 'add',
        'text' => elgg_echo('paypal_marketplace:add'),
        'href' => elgg_generate_url('add:object:paypal_marketplace_item'),
        'link_class' => 'elgg-button elgg-button-action',
    ]);
}

// Build the page
$body = elgg_view_layout('default', [
    'title' => $title,
    'content' => $content,
    'sidebar' => elgg_view('paypal_marketplace/sidebar'),
]);

echo elgg_view_page($title, $body); 