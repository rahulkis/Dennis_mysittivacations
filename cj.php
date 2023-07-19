<?php

function ConnectToCJ() 
{
    global $sort_order, $sort_by;

    //
    // Build REST URI for product search. Refer to 
    // documentation for more request parameters.
    //
    $URI = 'https://product-search.api.cj.com/v2/product-search?website-id=8265264&low-price=1&records-per-page=25&&keywords=bestofvegas';

    $context = stream_context_create(
    array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Authorization: ' . // USE YOUR OWN.
            '0012345b5ffdb74cd401e1aade0f69cadca29c834781c0936'.
            'b0b0836383b4e3e8dd7b406612347c3813bda24f8354dd649'.
            '6679031d8bc46f0dea1943a747ae0025/0093500ab1417918'.
            'f621234038b1234e8c4b0b22ea9f9cbc1db37a592247676ae'.
            'c528388bad7a06c9532c46fba2d0815e81e1234a9b25d9173'.
            '2f46f93123444dc1'
        )
    ));

    $response = new SimpleXMLElement(file_get_contents($URI, false, $context));
    print_r($response);
}
