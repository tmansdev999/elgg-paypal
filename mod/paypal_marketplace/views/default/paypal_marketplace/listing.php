<?php

$items = elgg_extract('items', $vars, []);

if (empty($items)) {
    echo elgg_echo('paypal_marketplace:no_items');
    return;
}

$list_items = [];
foreach ($items as $item) {
    $owner = $item->getOwnerEntity();
    $price = $item->price;
    $currency = $item->currency ?: 'USD';
    $transaction_type = $item->transaction_type;
    
    $item_content = elgg_view('object/elements/summary', [
        'entity' => $item,
        'title' => $item->title,
        'subtitle' => elgg_echo('paypal_marketplace:price', [$price, $currency]),
        'metadata' => elgg_echo('paypal_marketplace:transaction_type:' . $transaction_type),
        'content' => elgg_get_excerpt($item->description),
    ]);
    
    // Add action buttons based on transaction type
    $actions = [];
    if (elgg_is_logged_in()) {
        if ($owner->guid !== elgg_get_logged_in_user_guid()) {
            switch ($transaction_type) {
                case 'buy':
                case 'sell':
                case 'rent':
                    $actions[] = elgg_view('output/url', [
                        'text' => elgg_echo('paypal_marketplace:action:purchase'),
                        'href' => "paypal_marketplace/purchase/{$item->guid}",
                        'class' => 'elgg-button elgg-button-action',
                    ]);
                    break;
                    
                case 'auction':
                    $actions[] = elgg_view('output/url', [
                        'text' => elgg_echo('paypal_marketplace:action:bid'),
                        'href' => "paypal_marketplace/bid/{$item->guid}",
                        'class' => 'elgg-button elgg-button-action',
                    ]);
                    break;
                    
                case 'gift':
                case 'donate':
                    $actions[] = elgg_view('output/url', [
                        'text' => elgg_echo('paypal_marketplace:action:donate'),
                        'href' => "paypal_marketplace/donate/{$item->guid}",
                        'class' => 'elgg-button elgg-button-action',
                    ]);
                    break;
                    
                case 'trade':
                    $actions[] = elgg_view('output/url', [
                        'text' => elgg_echo('paypal_marketplace:action:trade'),
                        'href' => "paypal_marketplace/trade/{$item->guid}",
                        'class' => 'elgg-button elgg-button-action',
                    ]);
                    break;
            }
        } else {
            // Owner actions
            $actions[] = elgg_view('output/url', [
                'text' => elgg_echo('edit'),
                'href' => "paypal_marketplace/edit/{$item->guid}",
                'class' => 'elgg-button elgg-button-edit',
            ]);
            
            $actions[] = elgg_view('output/url', [
                'text' => elgg_echo('delete'),
                'href' => "action/paypal_marketplace/delete?guid={$item->guid}",
                'class' => 'elgg-button elgg-button-delete',
                'confirm' => elgg_echo('deleteconfirm'),
            ]);
        }
    }
    
    $item_content .= elgg_format_element('div', ['class' => 'elgg-item-actions'], implode('', $actions));
    
    $list_items[] = elgg_format_element('div', [
        'class' => 'elgg-item paypal-marketplace-item',
        'data-guid' => $item->guid,
    ], $item_content);
}

echo elgg_format_element('div', [
    'class' => 'elgg-list paypal-marketplace-list',
], implode('', $list_items));

// Add pagination
echo elgg_view('navigation/pagination', [
    'base_url' => current_page_url(),
    'count' => elgg_count_entities([
        'type' => 'object',
        'subtype' => 'paypal_marketplace_item',
    ]),
    'limit' => 20,
    'offset' => get_input('offset', 0),
]); 