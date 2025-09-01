<?php

namespace Amplify\System\Backend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * CenPosPaymentGateway Facade
 *
 * @see \Amplify\System\Payment\Services\CenPosPaymentGateway
 *
 * @method static mixed getVerifyingPost(string $email = "s", ?float $amount = 0.00, ?string $token = null, ?string $invoiceNumber = null, ?string $type = null)
 * @method static mixed getCards(string $email = "s")
 * @method static mixed payPayment(string $email = "s", float $amount, string $token, string $invoiceNumber, string $type = "Sale")
 */
class CenPos extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CenPos';
    }
}
