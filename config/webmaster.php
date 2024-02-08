<?php
return [
    "Pages",
    ["Dashboard", "webmaster_dashboard_index", "sliders", "consult_dashboard", "dashboard"],
    ["Categories", "webmaster_categories_index", "align-left", "consult_categories", "categories"],
    ["Products", "webmaster_products_index", "package", "consult_products", "products"],
    ["Pages", "webmaster_pages_index", "book", "consult_pages", "pages"],
    "Orders",
    ["Pending", "webmaster_pages_index", "shopping-cart", "consult_pendingorders", "pendingorders"], #Pending, Confirmed
    ["Shipped", "webmaster_pages_index", "shopping-cart", "consult_shippedorders", "shippedorders"], #Shipped, Validated, Delivery
    ["Delivered", "webmaster_pages_index", "shopping-cart", "consult_deliveredorders", "deliveredorders"], #Delivered, Ready, Payed
    ["Back", "webmaster_pages_index", "shopping-cart", "consult_backorders", "backorders"], #Back, Back ready
    ["Archived", "webmaster_pages_index", "shopping-cart", "consult_archivedorders", "archivedorders"], #Canceled, Archived, Doubled
    "Gestion",
    ["Messages", "webmaster_messages_index", "message-square", "consult_messages", "messages"], 
    ["Stock", "webmaster_stock_index", "clipboard", "consult_stock", "stock"], 
    ["Delivery price", "webmaster_delivery_index", "truck", "consult_delivery", "delivery"], 
    "Générale",
    ["Admins", "webmaster_admins_index", "users", "consult_admins", "admins"], 
    ["Settings", "webmaster_settings_index", "settings", "consult_settings", "settings"], 

];