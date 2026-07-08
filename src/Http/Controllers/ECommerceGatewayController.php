<?php

namespace Amplify\System\Backend\Http\Controllers;

use Illuminate\Routing\Controller;

class ECommerceGatewayController extends Controller
{
    public function getPriceAvailability($p_code, $w_code = null)
    {
        $product = \ErpApi::getProductPriceAvailability([
            'single_product' => true,
            'items' => [
                [
                    'item' => $p_code,
                ],
            ],
            'warehouse' => $w_code,
        ]);

        return response()->json($product->first());
    }
}
