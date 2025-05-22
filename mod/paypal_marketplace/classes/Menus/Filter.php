<?php

namespace Elgg\PayPalMarketplace\Menus;

use Elgg\Menu\MenuItems;

class Filter {
    
    /**
     * Register menu items for the marketplace filter menu
     *
     * @param \Elgg\Event $event 'register', 'menu:filter:paypal_marketplace'
     *
     * @return MenuItems
     */
    public static function register(\Elgg\Event $event): MenuItems {
        $return = $event->getValue();
        
        $filter = get_input('filter', 'all');
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'all',
            'text' => elgg_echo('paypal_marketplace:filter:all'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all'),
            'selected' => $filter === 'all',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'buy',
            'text' => elgg_echo('paypal_marketplace:filter:buy'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'buy',
            ]),
            'selected' => $filter === 'buy',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'sell',
            'text' => elgg_echo('paypal_marketplace:filter:sell'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'sell',
            ]),
            'selected' => $filter === 'sell',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'rent',
            'text' => elgg_echo('paypal_marketplace:filter:rent'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'rent',
            ]),
            'selected' => $filter === 'rent',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'trade',
            'text' => elgg_echo('paypal_marketplace:filter:trade'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'trade',
            ]),
            'selected' => $filter === 'trade',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'auction',
            'text' => elgg_echo('paypal_marketplace:filter:auction'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'auction',
            ]),
            'selected' => $filter === 'auction',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'gift',
            'text' => elgg_echo('paypal_marketplace:filter:gift'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'gift',
            ]),
            'selected' => $filter === 'gift',
        ]);
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'donate',
            'text' => elgg_echo('paypal_marketplace:filter:donate'),
            'href' => elgg_generate_url('collection:object:paypal_marketplace_item:all', [
                'filter' => 'donate',
            ]),
            'selected' => $filter === 'donate',
        ]);
        
        return $return;
    }
} 