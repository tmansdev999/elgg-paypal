<?php

use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Exceptions\Http\GatekeeperException;

// Only allow admins to create test items
elgg_gatekeeper();
elgg_admin_gatekeeper();

// Test items data
$test_items = [
    // Buy/Sell items
    [
        'title' => 'iPhone 13 Pro - Like New',
        'description' => 'iPhone 13 Pro 256GB in excellent condition. Includes original box and accessories. Used for 6 months.',
        'transaction_type' => 'sell',
        'price' => 799.99,
        'currency' => 'USD',
    ],
    [
        'title' => 'Looking for Gaming Laptop',
        'description' => 'Want to buy a gaming laptop with RTX 3060 or better. Budget up to $1200.',
        'transaction_type' => 'buy',
        'price' => 1200.00,
        'currency' => 'USD',
    ],
    
    // Rent items
    [
        'title' => 'Beach House - Weekly Rental',
        'description' => 'Beautiful 3-bedroom beach house available for weekly rental. Ocean view, fully furnished.',
        'transaction_type' => 'rent',
        'price' => 1200.00,
        'currency' => 'USD',
        'rent_period' => 'week',
    ],
    [
        'title' => 'Professional Camera Equipment',
        'description' => 'High-end camera and lens set available for daily rental. Perfect for events and photography.',
        'transaction_type' => 'rent',
        'price' => 150.00,
        'currency' => 'USD',
        'rent_period' => 'day',
    ],
    
    // Trade items
    [
        'title' => 'PS5 for Xbox Series X',
        'description' => 'Looking to trade my PS5 (with 2 controllers) for an Xbox Series X. Must be in good condition.',
        'transaction_type' => 'trade',
        'price' => 499.99,
        'currency' => 'USD',
        'trade_description' => 'PS5 with 2 controllers, all cables, and 3 games included.',
    ],
    [
        'title' => 'MacBook Pro for Gaming PC',
        'description' => 'Want to trade my 2021 MacBook Pro M1 for a high-end gaming PC setup.',
        'transaction_type' => 'trade',
        'price' => 1299.99,
        'currency' => 'USD',
        'trade_description' => 'MacBook Pro M1 16GB RAM, 512GB SSD, in perfect condition.',
    ],
    
    // Auction items
    [
        'title' => 'Vintage Rolex Watch',
        'description' => 'Authentic Rolex Submariner from 1985. Excellent condition with original papers.',
        'transaction_type' => 'auction',
        'price' => 5000.00,
        'currency' => 'USD',
        'auction_end_date' => strtotime('+7 days'),
        'auction_min_bid' => 100.00,
    ],
    [
        'title' => 'Limited Edition Sneakers',
        'description' => 'Nike Air Jordan 1 Retro High OG - Limited Edition. Size 10, never worn.',
        'transaction_type' => 'auction',
        'price' => 300.00,
        'currency' => 'USD',
        'auction_end_date' => strtotime('+3 days'),
        'auction_min_bid' => 50.00,
    ],
    
    // Gift items
    [
        'title' => 'Free Books Collection',
        'description' => 'Collection of classic literature books. Free to a good home. Must pick up.',
        'transaction_type' => 'gift',
        'price' => 0.00,
        'currency' => 'USD',
        'anonymous' => 'no',
    ],
    [
        'title' => 'Baby Clothes - Free',
        'description' => 'Gently used baby clothes (0-6 months). All items cleaned and in good condition.',
        'transaction_type' => 'gift',
        'price' => 0.00,
        'currency' => 'USD',
        'anonymous' => 'yes',
    ],
    
    // Donate items
    [
        'title' => 'Donate to Local Animal Shelter',
        'description' => 'Help support our local animal shelter. All donations go directly to animal care.',
        'transaction_type' => 'donate',
        'price' => 50.00,
        'currency' => 'USD',
        'anonymous' => 'no',
    ],
    [
        'title' => 'School Supplies Drive',
        'description' => 'Donate school supplies for underprivileged children. Any amount helps!',
        'transaction_type' => 'donate',
        'price' => 25.00,
        'currency' => 'USD',
        'anonymous' => 'yes',
    ],
];

$created = 0;
$errors = [];

foreach ($test_items as $item_data) {
    try {
        $item = new \ElggObject();
        $item->subtype = 'paypal_marketplace_item';
        $item->owner_guid = elgg_get_logged_in_user_guid();
        $item->container_guid = elgg_get_logged_in_user_guid();
        $item->access_id = ACCESS_PUBLIC;
        
        // Set basic properties
        $item->title = $item_data['title'];
        $item->description = $item_data['description'];
        $item->transaction_type = $item_data['transaction_type'];
        $item->price = $item_data['price'];
        $item->currency = $item_data['currency'];
        
        // Set transaction type specific properties
        switch ($item_data['transaction_type']) {
            case 'rent':
                $item->rent_period = $item_data['rent_period'];
                break;
                
            case 'trade':
                $item->trade_description = $item_data['trade_description'];
                break;
                
            case 'auction':
                $item->auction_end_date = $item_data['auction_end_date'];
                $item->auction_min_bid = $item_data['auction_min_bid'];
                break;
                
            case 'gift':
            case 'donate':
                $item->anonymous = $item_data['anonymous'];
                break;
        }
        
        if ($item->save()) {
            $created++;
        } else {
            $errors[] = "Failed to create: {$item_data['title']}";
        }
    } catch (\Exception $e) {
        $errors[] = "Error creating {$item_data['title']}: {$e->getMessage()}";
    }
}

// Show results
if ($created > 0) {
    system_message(elgg_echo('paypal_marketplace:test_items:created', [$created]));
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        register_error($error);
    }
}

// Forward to marketplace listing
forward(elgg_generate_url('collection:object:paypal_marketplace_item:all')); 