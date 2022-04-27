<?php

namespace App\Http\Controllers\Driver;

use App\Enums\AOrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use App\Enums\OrderReason;
use App\Fleet;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderStatus;
use App\RealCommission;
use App\User;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PaymentTypes;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function CODWallet($paymentType, $order)
    {
        $client = User::find($order->user_id);
        $fleet = Fleet::find($order->fleet_id);
        $orderD = Order::find($order->id);
        $orderCode = $order->id;
        $orderPrice = $order->order_price;
        $deliveryCost = $order->kilos_total_price;
        $deliveryFees = $order->deliver_fees;
        $deliveryCommission = $order->commission;
        $totalPrice = $order->order_price + $order->deliver_fees;
        $driverReverse = $deliveryCommission * 0.5;
        $clientReverse = $deliveryCost * 0.5;
        //        $orderPrice=50;
        //        $deliveryCost=18;
        //        $deliveryFees=20;
        //        $deliveryCommission=14;
        //        $totalPrice=$orderPrice+ $deliveryFees;
        //        $driverReverse=$deliveryCommission * 0.5;
        //        $clientReverse=$deliveryCost * 0.5 ;

        if ($order->order_status_id == AOrderStatus::PICKED_UP) {

            if ($paymentType == PaymentType::PAY_CASH) {
                $fleet->deposit($orderPrice * 100, ["description" => " PAY_CASH in Pick Up => CASH_ON_DELIVERY  OrderId=>".$orderCode ."Client =>". $client->company_name  ]);
                $orderD->balance_fleet = $order->balance_fleet + $orderPrice;
                $orderD->save();
            } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                $client->forceWithdraw($orderPrice * 100, ['description' => "PAY_BY_DRIVER_WALLET in Pick Up => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($orderPrice * 100, ['description' => "PAY_BY_DRIVER_WALLET in Pick Up => CASH_ON_DELIVERY  OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $orderPrice;
                $orderD->balance_fleet = $order->balance_fleet - $orderPrice;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $client->forceWithdraw($orderPrice * 100, ['description' => "NOT_PAY in Pick Up => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($orderPrice * 100, ['description' => "NOT_PAY in Pick Up => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $orderPrice;
                $orderD->balance_fleet = $order->balance_fleet - $orderPrice;
                $orderD->save();
            }
            $fleet->status='busy';
            $fleet->save();

        }
        elseif ($order->order_status_id == AOrderStatus::DELIVERED) {

            if ($paymentType == PaymentType::PAY_CASH) {

                $costFleet = $totalPrice - $deliveryCommission;
                $costClient = $deliveryFees - $deliveryCost;
                $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                $orderD->save();
            } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                $costFleet = $deliveryFees - $deliveryCommission;
                $costClient = $deliveryFees - $deliveryCost;
                $client->forceWithdraw($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_BY_DRIVER_WALLET in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $cost = $deliveryCommission + $orderPrice;
                $costFleet = $totalPrice - $cost;
                $costClient = $deliveryFees - $deliveryCost;
                $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($costFleet * 100, ['description' => "NOT_PAY in DELIVERED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                $orderD->save();
            }

            $fleet->status='free';
            $fleet->save();
        }
        elseif ($order->order_status_id == AOrderStatus::RETURNED) {
            if ($paymentType == PaymentType::PAY_CASH) {
                $cost = $deliveryCommission + $driverReverse;
                $costFleet = $orderPrice - $cost;
                $costClient = $clientReverse + $deliveryCost;
                $client->deposit($costClient * 100, ['description' => "PAY_CASH in RETURNED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH in RETURNED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $costClient;
                $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                $orderD->save();
            } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                $costFleet = $orderPrice + $deliveryCommission + $driverReverse;
                $costClient = $orderPrice + $deliveryCost + $clientReverse;
                $client->deposit($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET in RETURNED => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "PAY_BY_DRIVER_WALLET in RETURNED => CASH_ON_DELIVERY  OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $costFleet = $orderPrice + $deliveryCommission + $driverReverse;
                $costClient = $orderPrice + $deliveryCost + $clientReverse;
                $client->deposit($costClient * 100, ['description' => "NOT_PAY in RETURNED => CASH_ON_DELIVERY OrderId=>". $orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY in RETURNED => CASH_ON_DELIVERY OrderId=>". $orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            }
            $fleet->status='free';
            $fleet->save();
        }
        elseif ($order->order_status_id == AOrderStatus::FAILED) {

            if ($order->reason ==  OrderReason::Client_Canceled_Before_Pickup) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Client_Canceled_Before_Pickup CASH_ON_DELIVERY  OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Client_Canceled_Before_Pickup OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            }
            elseif ($order->reason ==  OrderReason::Store_Is_Closed) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Store_Is_Closed CASH_ON_DELIVERY  OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Store_Is_Closed CASH_ON_DELIVERY  OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::Wrong_Pickup_Location) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Wrong_Pickup_Location OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Wrong_Pickup_Location OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::App_Issues) {
                $costFleet = $deliveryCommission * 0.25;
                $fleet->forceWithdraw($costFleet * 100, ['description' => "App_Issues OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::App_Issues) {
                $costFleet = $deliveryCommission * 0.25;
                $fleet->deposit($costFleet * 100, ['description' => "App_Issues OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::Client_Canceled_On_The_Way) {

                if ($paymentType == PaymentType::PAY_CASH) {

                    $costFleetCommission = $deliveryCommission * 0.50;
                    $costFleet = $costFleetCommission - $orderPrice;

                    $costClientDelivery = $deliveryCost * 0.50;
                    $costClient = $costClientDelivery + $orderPrice;

                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {

                    $costFleetCommission = $deliveryCommission * 0.50;
                    $costFleet = $costFleetCommission + $orderPrice;
                    $costClient = $deliveryCost * 0.50;
                    $client->deposit($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name  ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleetCommission = $deliveryCommission * 0.50;
                    $costFleet = $costFleetCommission + $orderPrice;

                    $costClient = $deliveryCost * 0.50;

                    $client->deposit($costClient * 100, ['description' => "NOT_PAY_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY_ON_Clients_Canceled => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Driver_Refused_To_Deliever_Or_Late) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costFleet = $orderPrice * 2;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Driver_Refused_To_Deliver_Or_Late => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Driver_Refused_To_Deliver_Or_Late => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Driver_Refused_To_Deliver_Or_Late => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Driver_Refused_To_Deliver_Or_Late => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Car_Issues) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Car_Issues => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Car_Issues => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name  ]);
                    $fleet->deposit($costFleet * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Car_Issues => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Car_Issues => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY_ON_Car_Issues => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Abnormal_Weather) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Abnormal_Weather => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Abnormal_Weather => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Abnormal_Weather => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Abnormal_Weather => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY_ON_Abnormal_Weather => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Customer_Refused_To_Take_The_Order_Because_Of_Driver) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costFleet = $orderPrice * 2;
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_BY_DRIVER_WALLET_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costClient = $orderPrice;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Customer_Refused_To_Take_The_Order_Because_Of_Client) {

                if ($paymentType == PaymentType::PAY_CASH) {


                    $costFleet =  $deliveryCommission * 0.75;

                    $costClientDelivery = $deliveryCost * 0.75;
                    $costClient = $costClientDelivery + $orderPrice;

                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposite($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::PAY_BY_DRIVER_WALLET) {


                    $costFleetCommission =  $deliveryCommission * 0.75;
                    $costFleet = $costFleetCommission  + $orderPrice;

                    $costClientDelivery = $deliveryCost * 0.75;
                    $costClient = $costClientDelivery + $orderPrice;

                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposite($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleetCommission =  $deliveryCommission * 0.75;
                    $costFleet = $costFleetCommission  + $orderPrice;

                    $costClientDelivery = $deliveryCost * 0.75;
                    $costClient = $costClientDelivery + $orderPrice;

                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposite($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => CASH_ON_DELIVERY OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            }

            $fleet->status='free';
            $fleet->save();
        }
    }
    public function PrepaidWallet($paymentType, $order)
    {
        $client = User::find($order->user_id);
        $fleet = Fleet::find($order->fleet_id);
        $orderD = Order::find($order->id);
        $orderCode = $order->id;
        $orderPrice = $order->order_price;
        $deliveryCost = $order->kilos_total_price;
        $deliveryFees = $order->deliver_fees;
        $deliveryCommission = $order->commission;
        $totalPrice = $order->order_price + $order->deliver_fees;
        $driverReverse = $deliveryCommission * 0.5;
        $clientReverse = $deliveryCost * 0.5;
        //        $orderPrice=50;
        //        $deliveryCost=18;
        //        $deliveryFees=20;
        //        $deliveryCommission=14;
        //        $totalPrice=$order->price + $order->deliver_fees;
        //        $driverReverse=$deliveryCommission * 0.5;
        //        $clientReverse=$deliveryCost * 0.5 ;
        if ($order->order_status_id == AOrderStatus::PICKED_UP) {
            if ($paymentType == PaymentType::PAY_ON_PICKUP) {
                $fleet->deposit($orderPrice * 100, ["description" => " PAY_ON_PICKUP in Pick Up => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $client->deposit($orderPrice * 100, ["description" => " PAY_ON_PICKUP in Pick Up => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $orderPrice;
                $orderD->balance_fleet = $order->balance_fleet + $orderPrice;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $client->deposit(0, ['description' => "NOT_PAY in Pick_Up => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit(0, ['description' => "NOT_PAY in Pick_Up => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
            }

            $fleet->status='busy';
            $fleet->save();
        }
        elseif ($order->order_status_id == AOrderStatus::DELIVERED) {
            if ($paymentType == PaymentType::PAY_ON_PICKUP) {
                $client->deposit($deliveryCost * 100, ['description' => "PAY_ON_PICKUP in DELIVERED => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($deliveryCommission * 100, ['description' => "PAY_ON_PICKUP in DELIVERED => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $deliveryCost;
                $orderD->balance_fleet = $order->balance_fleet + $deliveryCommission;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $client->deposit($deliveryCost * 100, ['description' => "NOT_PAY in DELIVERED => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($deliveryCommission * 100, ['description' => "NOT_PAY in DELIVERED => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $deliveryCost;
                $orderD->balance_fleet = $order->balance_fleet + $deliveryCommission;
                $orderD->save();
            }

            $fleet->status='free';
            $fleet->save();
        }
        elseif ($order->order_status_id == AOrderStatus::RETURNED) {
            if ($paymentType == PaymentType::PAY_CASH) {
                $cost = $deliveryCommission + $driverReverse;
                $costFleet = $orderPrice - $cost;
                $cost2 = $clientReverse + $deliveryCost;
                $costClient = $orderPrice - $cost2;
                $client->forceWithdraw($costClient * 100, ['description' => "PAY_ON_PICKUP in RETURNED => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_ON_PICKUP in RETURNED => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                $orderD->save();
            } elseif ($paymentType == PaymentType::NOT_PAY) {
                $costFleet = $deliveryCommission + $driverReverse;
                $costClient = $deliveryCost + $clientReverse;
                $client->deposit($costClient * 100, ['description' => "NOT_PAY in RETURNED => Prepaid OrderId=>". $orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY in RETURNED => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client + $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            }


            $fleet->status='free';
            $fleet->save();
        }
        elseif ($order->order_status_id == AOrderStatus::FAILED) {

            if ($order->reason ==  OrderReason::Client_Canceled_Before_Pickup) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Client_Canceled_Before_Pickup OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Client_Canceled_Before_Pickup OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::Store_Is_Closed) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Store_Is_Closed OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Store_Is_Closed OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::Wrong_Pickup_Location) {
                $costFleet = $deliveryCommission * 0.25;
                $costClient = $deliveryCost * 0.25;
                $client->forceWithdraw($costClient * 100, ['description' => "Wrong_Pickup_Location OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                $fleet->deposit($costFleet * 100, ['description' => "Wrong_Pickup_Location OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_client = $order->balance_client - $costClient;
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::App_Issues) {
                $costFleet = $deliveryCommission * 0.25;
                $fleet->deposit($costFleet * 100, ['description' => "App_Issues OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                $orderD->save();
            } elseif ($order->reason ==  OrderReason::Client_Canceled_On_The_Way) {

                if ($paymentType == PaymentType::PAY_CASH) {

                    $costFleetCommission = $deliveryCommission * 0.50;
                    $costFleet = $costFleetCommission - $orderPrice;

                    $costClientDelivery = $deliveryCost * 0.50;
                    $costClient = $costClientDelivery;
                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Clients_Canceled => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Clients_Canceled => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleetCommission = $deliveryCommission * 0.50;
                    $costFleet = $costFleetCommission;
                    $costClient = $deliveryCost * 0.50;
                    $client->deposit($costClient * 100, ['description' => "NOT_PAY_ON_Clients_Canceled => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->deposit($costFleet * 100, ['description' => "NOT_PAY_ON_Clients_Canceled => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Driver_Refused_To_Deliever_Or_Late) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costFleet = $orderPrice * 2;
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Driver_Refused_To_Deliver_Or_Late => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Driver_Refused_To_Deliver_Or_Late => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Driver_Refused_To_Deliver_Or_Late => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "NOT_PAY_ON_Driver_Refused_To_Deliver_Or_Late => Prepaid OrderId=>".$orderCode ."Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Car_Issues) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Car_Issues => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {

                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Car_Issues => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Abnormal_Weather) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Abnormal_Weather => Prepaid OrderId=>".$orderCode ."Driver =>". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {

                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Abnormal_Weather => Prepaid OrderId=> ".$orderCode ."  Driver => ". $fleet->name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Customer_Refused_To_Take_The_Order_Because_Of_Driver) {

                if ($paymentType == PaymentType::PAY_CASH) {
                    $costFleet = $orderPrice * 2;
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => Prepaid OrderId=> ".$orderCode ." Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => Prepaid OrderId=> ".$orderCode ." Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {
                    $costFleet = $orderPrice;
                    $costClient = $orderPrice * 2;
                    $client->forceWithdraw($costClient * 100, ['description' => "NOT_PAY_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => Prepaid OrderId=> ".$orderCode ."  Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "NOT_PAY_ON_Customer_Refused_To_Take_The_Order_Because_Of_Driver => Prepaid OrderId=>  ".$orderCode."  Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client - $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                }
            } elseif ($order->reason ==  OrderReason::Customer_Refused_To_Take_The_Order_Because_Of_Client) {

                if ($paymentType == PaymentType::PAY_CASH) {

                    $costFleet =  $deliveryCommission * 0.75;
                    $costClient = $deliveryCost * 0.75;
                    $client->deposit($costClient * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => Prepaid OrderId=> ".$orderCode ."  Driver =>". $fleet->name ]);
                    $fleet->forceWithdraw($costFleet * 100, ['description' => "PAY_CASH_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => Prepaid OrderId=> ".$orderCode ." Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet - $costFleet;
                    $orderD->save();
                } elseif ($paymentType == PaymentType::NOT_PAY) {

                    $costFleet = $deliveryCommission * 0.75;

                    $costClient =  $deliveryCost * 0.75;
                    $client->deposit($costClient * 100, ['description' => "NOT_PAY_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => Prepaid OrderId=> ".$orderCode ."  Driver =>". $fleet->name ]);
                    $fleet->deposite($costFleet * 100, ['description' => "NOT_PAY_ON_Customer_Refused_To_Take_The_Order_Because_Of_Client => Prepaid OrderId=> ".$orderCode ."   Client =>". $client->company_name ]);
                    $orderD->balance_client = $order->balance_client + $costClient;
                    $orderD->balance_fleet = $order->balance_fleet + $costFleet;
                    $orderD->save();
                }
            }

            $fleet->status='free';
            $fleet->save();
        }
    }
    public function Commission($kilos_count, $user_id, $order_id)
    {
        $order = Order::find($order_id);
        $user = User::find($user_id);
        $delivery_commission = '0';
        if ($user->real_commission_id != null) {
            $commission = RealCommission::find($user->real_commission_id);

            if ($commission->type == 0) {

                $delivery_commission= $commission->price_default;

            } else {

                if ($commission->distance <= $kilos_count) {
                    $defDistance = $kilos_count - $commission->distance;
                    $commissionKM = $defDistance * $commission->price_after;
                    $orderCommission = $commission->price_default + $commissionKM;
                    $delivery_commission= $orderCommission;
                    if($orderCommission > $commission->max_cost){
                        $delivery_commission = $commission->max_cost;
                    }
                } else {
                    $delivery_commission = $commission->price_default;
                    //dd( $commission->price_default , $commission,$delivery_commission);

                }
            }
        }

        $order->commission = $delivery_commission;
        $order->save();
    }
}
