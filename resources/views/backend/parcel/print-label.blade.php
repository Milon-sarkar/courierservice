<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('backend/')}}/images/favicon.jpg">
    <style>
        @media print {
            @page  {
               size:size: 65mm 70mm landscape;
               margin: 1cm;
               width:65mm!important;
               height:70mm!important;
            }
            .main-table{
                width:65mm!important;
                height:70mm!important;
            }
            .barcode-box>div{
                width:65mm!important;
                margin-right:10px!important;
                transform: scale(0.9);
            }
            /* print.css */
        }
    </style>
</head>
<body >
    <div class="page" style="padding-top:0px;">
        <div class="subpage">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-table" style="font-size:15px;font-family:Arial, Helvetica, sans-serif;">
                <tbody width="270px">
                    <tr>
                        <td colspan="3" style="padding-left:5px; padding-bottom:0px;">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td  style="padding-left:5px; margin-top:10px height: 70px; width:140px;  border-right: 3px solid">
                                        <img alt="Logo" src="{{ settings()->logo_image }}" class="logo" style="width:70px">
                                    </td>
                                    <td style="padding-left: 10px;width:100%;font-size:15px;padding-right:5px">
                                        <span> <b >{{ __('MERCHANT :') }}</b> </span><span style="font-weight:bold;font-size:13px"> {{ $parcel->merchant->business_name }}</span><br>
                                        <span style="font-size:13px;font-weight:bold"> {{$parcel->merchant->address}}</span><br>
                                        <span style="  padding-top: 3px;font-size:13px;font-weight:bold"> {{$parcel->merchant->user->mobile}} </span><br>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 0px; margin-bottom: 0px">
                                <tbody>
                                <tr>
                                    <td width="" style="line-height:1.2;width:50%;padding-right:5px; font-size:15px;border-right: 2px solid;border-top:#000000  1px solid;border-bottom:#000000 1px solid;">
                                        <span><b >{{ __('CUSTOMER :') }}</b></span><span style="font-size:13px;font-weight:bold"> {{ $parcel->customer_name }}</span><br>
                                        <span style="font-size:13px;font-weight:bold">{{ $parcel->customer_phone }}</span><br>
                                        <span style="font-size:13px;font-weight:bold">{{ $parcel->customer_address }}</span>
                                    </td>
                                    <td  width="" style=" padding-left:10px;padding-right:10px;line-height:1.2; font-size:15px;border-top:#000000  1px solid;border-bottom:#000000 1px solid;">
                                        <div style="padding-bottom: 0px;padding-top: 0px; ">
                                            <span><b >HUB</b>  : </span><span style="font-size:13px;font-weight:bold">{{ optional($parcel->hub)->name }}</span><br>
                                            <span><b >CASH</b> :</span><span style="font-size:13px;font-weight:bold"> {{ $parcel->cash_collection }} </span></br>
                                            <span><b >ROUTE</b> :</span><span style="font-size:13px;font-weight:bold"> ISD </span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr style="margin-top:0px;margin-left:15px;">
                        <td style="text-align:center!important">
                            <div class="barcode-box" style="width:100mm!important;margin-right:10px!important">
                                    {!! $parcel->barcodeprint !!}
                            </div><br>
                            <span style="font-weight: bold;font-size:15px">{{ $parcel->tracking_id }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
