<?php

$transaction_types = [
    'buy' => elgg_echo('paypal_marketplace:transaction_type:buy'),
    'sell' => elgg_echo('paypal_marketplace:transaction_type:sell'),
    'rent' => elgg_echo('paypal_marketplace:transaction_type:rent'),
    'trade' => elgg_echo('paypal_marketplace:transaction_type:trade'),
    'auction' => elgg_echo('paypal_marketplace:transaction_type:auction'),
    'gift' => elgg_echo('paypal_marketplace:transaction_type:gift'),
    'donate' => elgg_echo('paypal_marketplace:transaction_type:donate'),
];

$content = '<div class="paypal-marketplace-info">';
$content .= '<h3>' . elgg_echo('paypal_marketplace:info:transaction_types') . '</h3>';
$content .= '<ul class="elgg-list">';
foreach ($transaction_types as $type => $label) {
    $content .= elgg_format_element('li', [], $label);
}
$content .= '</ul>';

$content .= '<h3>' . elgg_echo('paypal_marketplace:info:how_it_works') . '</h3>';
$content .= '<ol>';
$content .= elgg_format_element('li', [], elgg_echo('paypal_marketplace:info:step1'));
$content .= elgg_format_element('li', [], elgg_echo('paypal_marketplace:info:step2'));
$content .= elgg_format_element('li', [], elgg_echo('paypal_marketplace:info:step3'));
$content .= elgg_format_element('li', [], elgg_echo('paypal_marketplace:info:step4'));
$content .= '</ol>';

$content .= '<h3>' . elgg_echo('paypal_marketplace:info:safety') . '</h3>';
$content .= '<p>' . elgg_echo('paypal_marketplace:info:safety_text') . '</p>';

$content .= '</div>';

echo $content; 