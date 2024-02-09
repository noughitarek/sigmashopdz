<?php
return [
    "id" => "SSD",
    "title" => "Sigmashop",

    "ecotrack_link" => "https://rblivraison.ecotrack.dz/",
    "ecotrack_api" => "yRHsVpLcJsT1TGDKComsb9BFWveyz8XGoJOD6KNDxgkGtNmuLKGk8M6RZ4h6",

    "sidemenu"=>[
        "Pages",
        ["Dashboard", "webmaster_dashboard_index", "sliders", "consult_dashboard", "dashboard"],
        ["Categories", "webmaster_categories_index", "align-left", "consult_categories", "categories"],
        ["Products", "webmaster_products_index", "package", "consult_products", "products"],
        ["Pages", "webmaster_pages_index", "book", "consult_pages", "pages"],
        "Orders",
        ["Orders", "webmaster_orders_all_index", "shopping-cart", "consult_all_orders", "orders_all"], #All
        ["Pending", "webmaster_orders_pending_index", "shopping-cart", "consult_pending_orders", "orders_pending"], #Pending, Confirmed
        ["Shipped", "webmaster_orders_shipped_index", "shopping-cart", "consult_shipped_orders", "orders_shipped"], #Shipped, Validated, Delivery
        ["Delivered", "webmaster_orders_delivered_index", "shopping-cart", "consult_delivered_orders", "orders_delivered"], #Delivered, Ready, Payed
        ["Back", "webmaster_orders_back_index", "shopping-cart", "consult_back_orders", "orders_back"], #Back, Back ready
        ["Archived", "webmaster_orders_archived_index", "shopping-cart", "consult_archived_orders", "orders_archived"], #Canceled, Archived, Doubled
        "Gestion",
        ["Messages", "webmaster_messages_index", "message-square", "consult_messages", "messages"], 
        ["Stock", "webmaster_stock_index", "clipboard", "consult_stock", "stock"], 
        ["Delivery price", "webmaster_delivery_index", "truck", "consult_delivery", "delivery"], 
        "Générale",
        ["Admins", "webmaster_admins_index", "users", "consult_admins", "admins"], 
        ["Settings", "webmaster_settings_index", "settings", "consult_settings", "settings"], 
    ]

];