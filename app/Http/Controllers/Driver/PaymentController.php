<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(){

//        \Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
        \Genesis\Config::setEndpoint(\Genesis\API\Constants\Endpoints::EMERCHANTPAY);
        \Genesis\Config::setEnvironment(\Genesis\API\Constants\Environments::STAGING);
        \Genesis\Config::setUsername('');
        \Genesis\Config::setPassword('p');
        \Genesis\Config::setToken('');

        $genesis = new \Genesis\Genesis('Financial\Cards\Authorize');

        $genesis
            ->request()
            ->setTransactionId('43675')
            ->setUsage('40208 concert tickets')
            ->setRemoteIp($_SERVER['SERVER_ADDR'])
            ->setAmount('50')
            ->setCurrency('USD')
            // Customer Details
            ->setCustomerEmail('emil@example.com')
            ->setCustomerPhone('1987987987987')
            // Credit Card Details
            ->setCardHolder('Test Family')
            ->setCardNumber('5123450000000008')
            ->setExpirationMonth('05')
            ->setExpirationYear('2021')
            ->setCvv('100')
            // Billing/Invoice Details
            ->setBillingFirstName('Test')
            ->setBillingLastName('Family')
            ->setBillingAddress1('Muster Str. 12')
            ->setBillingZipCode('10178')
            ->setBillingCity('Los Angeles')
            ->setBillingState('CA')
            ->setBillingCountry('US');

        try {
            // Send the request
            $genesis->execute();

            dd($genesis->response()->getResponseObject());
            // Successfully completed the transaction - display the gateway unique id
            echo $genesis->response()->getResponseObject()->unique_id;
        }
// Log/handle API errors
// Example: Declined transaction, Invalid data, Invalid configuration
        catch (\Genesis\Exceptions\ErrorAPI $api) {
            echo $genesis->response()->getResponseObject()->technical_message;
        }
// Log/handle invalid parameters
// Example: Empty (required) parameter
        catch (\Genesis\Exceptions\ErrorParameter $parameter) {
            dd($parameter->getMessage());
        }
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
        catch (\Genesis\Exceptions\ErrorNetwork $network) {
            dd($network->getMessage());
        }
    }
}
