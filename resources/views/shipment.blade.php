<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ar">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="http://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

    body{
        font-size: .7rem;

    }
    @page {
        size: A6;
        margin: 0;
    }
    @media print {
        html, body {
            width: 105mm;
            height: 148mm;
        }
        .shipment-box {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    .shipment-box{
        border: 3px solid;
        line-height: 15px;
    }
    img{
        max-width: 100%;
    }
    table{
       width: 100%;
    }
    .first-table{
       text-align: center;
        line-height: 5px;
    }
    .shipment-section{
        border: 2px dashed;
        margin: 3px;
    }
    .second-table >td , .second-table{
        border: 1px solid;
        border-collapse: collapse;
    }
    td {
        padding: 2px 5px 2px 5px;
        line-height: 5px;
    }


</style>
</head>
<body>
<div class="container">
<section class="row  shipment-box">
<div class="col  shipment-section">

    <table class="first-table">
        <tr>
            <td>
                @php

                $path = asset("/img/logo.jpg");
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path,null,null);
                $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
            <img  style="height:130px; min-width: 350px" src="{{$logo}}">

            </td>
        </tr>
        <tr>
            <td>
                <p>OrderId # {{$order->id}}</p>
                <p> Shipment Number :{{$order->code}}</p>
                <p>Shipment Date: {{ date('d/M/Y',strtotime($order->created_at))}} - Weight {{$order->shipment_weight}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <div  style="margin-left: 25%">{!! DNS1D::getBarcodeHTML('SA'.$order->id, 'C39') !!}</div>
            </td>
        </tr>

    </table>
    <table class="second-table" >
        <tr class="Border">
            <td style="width: 20%">
                <h3>Ship From</h3>
            </td>
            <td  class="BorderLeft">
                <p>{{$order->user->company_name}} _ {{$order->branchWithCity->name}}</p>
                <p>{{$order->branchWithCity->address}}</p>
                <p>{{$order->branchWithCity->city->name}} _ {{$order->branchWithCity->city->country->name}}</p>
                <p>{{$order->user->email}} </p>

            </td>
        </tr>
        <tr class="Border">
            <td style="width: 20%">
                <h3>Ship To</h3>
            </td>
            <td class="BorderLeft">
                <p> {{$order->customer_name}} </p>
                <p> {{$order->address}} </p>
                <p> {{$order->city->name}} </p>
                <p> {{$order->city->country->name}} </p>
                <p> {{$order->customer_mobile}} </p>

            </td>
        </tr>
    </table>
    <table class="first-table">
        <tr class="Border">
            <td> <span class="font-weight-bold"> RN </span>{{$order->patch->route_number}}</td></tr>
        <tr>   <td>
                <div class="mb-3 ">{!! DNS1D::getBarcodeHTML($order->patch->route_number, 'C39') !!}</div>

            </td></tr>
    </table>


            </div>
            </section>
            </div>
            </body>
            </html>
