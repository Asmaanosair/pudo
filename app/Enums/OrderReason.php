<?php


namespace App\Enums;


abstract class OrderReason
{


    const Client_Canceled_Before_Pickup = 1;
    const Store_Is_Closed = 2;
    const Wrong_Pickup_Location = 3;
    const App_Issues = 4;
    const Client_Canceled_On_The_Way = 5;
    const Driver_Refused_To_Deliever_Or_Late = 6;
    const Car_Issues = 7;
    const Abnormal_Weather = 8;
    const Customer_Refused_To_Take_The_Order_Because_Of_Driver = 9;
    const Customer_Refused_To_Take_The_Order_Because_Of_Client = 10;
   //New Order
    const Customer_Canceled_New_Order = 11;
    const Client_Canceled_New_Order = 12;
    //Assign Order
    const Driver_Refused_To_Deliver_Assign_Order = 13;
    const Driver_Canceled_Assign_Order = 14;
    const Car_Issues_Assign_Order = 15;
    const Abnormal_Weather_Assign_Order = 16;
    const Order_Disappeared_From_The_Driver_App_Assign_Order = 17;
    const Mistake_In_Dispatching_Logic_Assign_Order = 18;
    const Driver_Is_Not_Responding_Assign_Order = 19;
     //On_The_Way_To_Pickup
    const Customer_Canceled_On_The_Way_To_Pickup = 20;
    const Client_Canceled_On_The_Way_To_Pickup = 21;
    const Driver_Refused_To_Deliver_On_The_Way_To_Pickup = 22;
    const Driver_Canceled_On_The_Way_To_Pickup = 23;
    const Car_Issues_On_The_Way_To_Pickup = 24;
    const Abnormal_Weather_On_The_Way_To_Pickup = 25;
    const Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup = 26;
    const Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup = 27;
    const Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup = 28;
    const Driver_Stopped_By_The_Police_On_The_Way_To_Pickup = 29;
    const Traffic_On_The_Way_To_Pickup = 30;
//    //Reach_Pickup_location
//    const Customer_Canceled_Reach_Pickup_location = 21;
//    const Client_Canceled_Reach_Pickup_location = 22;
//    const Driver_Refused_To_Deliver_Reach_Pickup_location = 23;
//    const Driver_Canceled_Reach_Pickup_location = 24;
//    const Order_Disappeared_From_The_Driver_App_Reach_Pickup_location = 25;
//    const Restaurant_Store_Is_Closed_Reach_Pickup_location = 26;
//    const Pick_Up_Location_Is_Wrong_Reach_Pickup_location = 27;
//    const Order_Is_Missing_From_The_Client_App_Reach_Pickup_location = 28;
//    //Picked up
//    const Customer_Canceled_Picked_up = 29;
//    const Driver_Refused_To_Deliver_Picked_up= 30;
//    //On_The_Way_To_dropOff
//    const Client_Canceled_On_The_Way_To_dropOff = 31;
//    const Driver_Refused_To_Deliver_On_The_Way_To_dropOff= 32;
//    const Car_Issues_On_The_Way_To_dropOff= 33;
//    const Abnormal_Weather_On_The_Way_To_dropOff= 34;
//    const Order_Disappeared_From_The_Driver_App_On_The_Way_To_dropOff= 35;
//    const Driver_Stopped_By_The_Police_On_The_Way_To_dropOff= 36;
//    const Traffic_On_The_Way_To_dropOff= 37;
//     //Reach_dropOff_Location
//    const Client_Canceled_Reach_dropOff_Location= 38;
//    const Customer_Refused_To_Take_The_Order_Reach_dropOff_Location= 39;
//    const Wrong_Order_Reach_dropOff_Location= 40;
//    const Wrong_Location_Reach_dropOff_Location= 41;
//    const Customer_Took_The_Order_Without_Paying_The_Driver_Reach_dropOff_Location= 42;

    const STATUS_STRING = [

        self::Client_Canceled_Before_Pickup =>'Client_Canceled_Before_Pickup',
        self::Store_Is_Closed => 'Store_Is_Closed',
        self::Wrong_Pickup_Location => 'Wrong_Pickup_Location',
        self::App_Issues => 'App_Issues',
        self::Client_Canceled_On_The_Way => 'Client_Canceled_On_The_Way',
        self::Driver_Refused_To_Deliever_Or_Late  => 'Driver_Refused_To_Deliever_Or_Late',
        self::Car_Issues => 'Car_Issues',
        self::Abnormal_Weather => 'Abnormal_Weather',
        self::Customer_Refused_To_Take_The_Order_Because_Of_Driver => 'Customer_Refused_To_Take_The_Order_Because_Of_Driver',
        self::Customer_Refused_To_Take_The_Order_Because_Of_Client => 'Customer_Refused_To_Take_The_Order_Because_Of_Client',
        //New Order
        self::Customer_Canceled_New_Order =>'Customer_Canceled_New_Order',
        self::Client_Canceled_New_Order => 'Client_Canceled_New_Order',
        //Assign Order
        self::Driver_Refused_To_Deliver_Assign_Order => 'Driver_Refused_To_Deliver_Assign_Order',
        self::Driver_Canceled_Assign_Order => 'Driver_Canceled_Assign_Order',
        self::Car_Issues_Assign_Order => 'Car_Issues_Assign_Order',
        self::Abnormal_Weather_Assign_Order  => 'Abnormal_Weather_Assign_Order',
        self::Order_Disappeared_From_The_Driver_App_Assign_Order => 'Order_Disappeared_From_The_Driver_App_Assign_Order',
        self::Mistake_In_Dispatching_Logic_Assign_Order => 'Mistake_In_Dispatching_Logic_Assign_Order',
        self::Driver_Is_Not_Responding_Assign_Order => 'Driver_Is_Not_Responding_Assign_Order',
         //On_The_Way_To_Pickup
        self::Customer_Canceled_On_The_Way_To_Pickup => 'Customer_Canceled_On_The_Way_To_Pickup',
        self::Client_Canceled_On_The_Way_To_Pickup => 'Client_Canceled_On_The_Way_To_Pickup',
        self::Driver_Refused_To_Deliver_On_The_Way_To_Pickup => 'Driver_Refused_To_Deliver_On_The_Way_To_Pickup',
        self::Driver_Canceled_On_The_Way_To_Pickup  => 'Driver_Canceled_On_The_Way_To_Pickup',
        self::Car_Issues_On_The_Way_To_Pickup => 'Car_Issues_On_The_Way_To_Pickup',
        self::Abnormal_Weather_On_The_Way_To_Pickup => 'Abnormal_Weather_On_The_Way_To_Pickup',
        self::Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup => 'Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup',
        self::Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup => 'Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup',
        self::Driver_Stopped_By_The_Police_On_The_Way_To_Pickup => 'Driver_Stopped_By_The_Police_On_The_Way_To_Pickup',
        self::Traffic_On_The_Way_To_Pickup => 'Traffic_On_The_Way_To_Pickup',
        self::Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup => 'Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup',
        //Reach_Pickup_location
//        self::Customer_Canceled_Reach_Pickup_location => 'Customer_Canceled_Reach_Pickup_location',
//        self::Client_Canceled_Reach_Pickup_location => 'Client_Canceled_Reach_Pickup_location',
//        self::Driver_Refused_To_Deliver_Reach_Pickup_location => 'Driver_Refused_To_Deliver_Reach_Pickup_location',
//        self::Driver_Canceled_Reach_Pickup_location => 'Driver_Canceled_Reach_Pickup_location',
//        self::Order_Disappeared_From_The_Driver_App_Reach_Pickup_location => 'Order_Disappeared_From_The_Driver_App_Reach_Pickup_location',
//        self::Restaurant_Store_Is_Closed_Reach_Pickup_location => 'Restaurant_Store_Is_Closed_Reach_Pickup_location',
//        self::Pick_Up_Location_Is_Wrong_Reach_Pickup_location => 'Pick_Up_Location_Is_Wrong_Reach_Pickup_location',
//        self::Order_Is_Missing_From_The_Client_App_Reach_Pickup_location => 'Order_Is_Missing_From_The_Client_App_Reach_Pickup_location',
//         //Picked up
//        self::Customer_Canceled_Picked_up => 'Customer_Canceled_Picked_up',
//        self::Driver_Refused_To_Deliver_Picked_up => 'Driver_Refused_To_Deliver_Picked_up',
//           //On_The_Way_To_dropOff
//        self::Client_Canceled_On_The_Way_To_dropOff => 'Client_Canceled_On_The_Way_To_dropOff',
//        self::Driver_Refused_To_Deliver_On_The_Way_To_dropOff => 'Driver_Refused_To_Deliver_On_The_Way_To_dropOff',
//        self::Car_Issues_On_The_Way_To_dropOff => 'Car_Issues_On_The_Way_To_dropOff',
//        self::Abnormal_Weather_On_The_Way_To_dropOff => 'Abnormal_Weather_On_The_Way_To_dropOff',
//        self::Order_Disappeared_From_The_Driver_App_On_The_Way_To_dropOff => 'Order_Disappeared_From_The_Driver_App_On_The_Way_To_dropOff',
//        self::Driver_Stopped_By_The_Police_On_The_Way_To_dropOff => 'Driver_Stopped_By_The_Police_On_The_Way_To_dropOff',
//        self::Traffic_On_The_Way_To_dropOff => 'Traffic_On_The_Way_To_dropOff',
//         //Reach_dropOff_Location
//        self::Client_Canceled_Reach_dropOff_Location => 'Client_Canceled_Reach_dropOff_Location',
//        self::Customer_Refused_To_Take_The_Order_Reach_dropOff_Location => 'Customer_Refused_To_Take_The_Order_Reach_dropOff_Location',
//        self::Wrong_Order_Reach_dropOff_Location => 'Wrong_Order_Reach_dropOff_Location',
//        self::Wrong_Location_Reach_dropOff_Location => 'Wrong_Location_Reach_dropOff_Location',
//        self::Customer_Took_The_Order_Without_Paying_The_Driver_Reach_dropOff_Location => 'Customer_Took_The_Order_Without_Paying_The_Driver_Reach_dropOff_Location',


    ];
}
