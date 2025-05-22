<?php

namespace Elgg\PayPalMarketplace\Menus;

use Elgg\Menu\MenuItems;

class AdminHeader {
    
    /**
     * Register menu items for the admin header menu
     *
     * @param \Elgg\Event $event 'register', 'menu:admin_header'
     *
     * @return MenuItems
     */
    public static function register(\Elgg\Event $event): MenuItems {
        $return = $event->getValue();
        
        if (!elgg_is_admin_logged_in()) {
            return $return;
        }
        
        $return[] = \ElggMenuItem::factory([
            'name' => 'paypal_marketplace:test_items',
            'text' => elgg_echo('paypal_marketplace:test_items:create'),
            'href' => elgg_generate_action_url('paypal_marketplace/create_test_items'),
            'confirm' => elgg_echo('paypal_marketplace:test_items:confirm'),
            'link_class' => 'elgg-button elgg-button-action',
        ]);
        
        return $return;
    }
} 