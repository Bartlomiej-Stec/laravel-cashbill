<?php

namespace Barstec\Cashbill;

use Illuminate\Support\Facades\Facade;

final class CashbillFacade extends Facade
{
    /**
     * Return Laravel Framework facade accessor name.
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cashbill';
    }
}