<?php
return [
    "id" => "SSD",
    "title" => "Sigmashop",

    "ecotrack_link" => "https://rblivraison.ecotrack.dz/",
    "ecotrack_api" => "yRHsVpLcJsT1TGDKComsb9BFWveyz8XGoJOD6KNDxgkGtNmuLKGk8M6RZ4h6",

    "permissions" => [
        "dashboard" => ['consult'], 
        "campaigns" => ['consult', 'create','edit', 'delete'], 
        "categories" => ['consult', 'create','edit', 'delete'], 
        "products" => ['consult', 'create','edit', 'delete'], 
        "pages" => ['consult', 'create','edit', 'delete'], 
        "orders" => ['consult_all', 'confirm', 'shipp', 'validate', 'archive', 'add_information', 'consult_pending', 'consult_shipped', 'consult_delivered', 'consult_back', 'consult_archived'],
        "messages" => ['consult', 'delete'],
        "stock" => ['consult', 'create','edit', 'delete'],
        "admins" => ['consult', 'create','edit', 'delete'],
        "settings" => ['consult', 'edit']
    ],
    
    "sidemenu"=>[
        "Pages",
        ["Dashboard", "webmaster_dashboard_index", "sliders", "consult_dashboard", "dashboard"],
        ["Categories", "webmaster_categories_index", "align-left", "consult_categories", "categories"],
        ["Products", "webmaster_products_index", "package", "consult_products", "products"],
        ["Pages", "webmaster_pages_index", "book", "consult_pages", "pages"],
        "break",
        "Orders",
        ["Orders", "webmaster_orders_all_index", "shopping-cart", "consult_all_orders", "orders_all"], #All
        ["Pending", "webmaster_orders_pending_index", "shopping-cart", "consult_pending_orders", "orders_pending"], #Pending, Confirmed
        ["Shipped", "webmaster_orders_shipped_index", "shopping-cart", "consult_shipped_orders", "orders_shipped"], #Shipped, Validated, Delivery
        ["Delivered", "webmaster_orders_delivered_index", "shopping-cart", "consult_delivered_orders", "orders_delivered"], #Delivered, Ready, Payed
        ["Back", "webmaster_orders_back_index", "shopping-cart", "consult_back_orders", "orders_back"], #Back, Back ready
        ["Archived", "webmaster_orders_archived_index", "shopping-cart", "consult_archived_orders", "orders_archived"], #Canceled, Archived, Doubled
        "break",
        "Gestion",
        ["Messages", "webmaster_messages_index", "message-square", "consult_messages", "messages"], 
        ["Campaigns", "webmaster_campaigns_index", "volume-2", "consult_campaigns", "campaigns"],
        ["Stock", "webmaster_stock_index", "clipboard", "consult_stock", "stock"], 
        ["Delivery price", "webmaster_delivery_index", "truck", "consult_delivery", "delivery"], 
        "break",
        "Générale",
        ["Admins", "webmaster_admins_index", "users", "consult_admins", "admins"], 
        ["Settings", "webmaster_settings_index", "settings", "consult_settings", "settings"], 
    ]

];