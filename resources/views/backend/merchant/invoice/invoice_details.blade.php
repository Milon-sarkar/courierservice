@extends('backend.partials.master')
@section('title')
    {{ __('menus.invoice') }} {{ __('levels.details') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('menus.invoice') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ @$invoice->invoice_id }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row  ">
                        <div class="col-12 ">
                            <div class="d-flex justify-content-end mt-2 mt-md-0">
  
                                <a href="{{ route('merchant.invoice.csv',[$invoice->merchant_id,$invoice->invoice_id]) }}" class="btn btn-success btn-sm " data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-download"></i> CSV</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table   " style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{  __('levels.id') }}</th>
                                    <th>{{ __('menus.date') }}</th>
                                    <th>{{ __('invoice.invoice') }}</th>
                                    <th>{{ __('levels.track_id') }}</th>
                                    <th>{{ __('parcel.customer_info')}}</th>
                                    <th>{{ __('parcel.cash_collection')}}</th>
                                    <th>{{ __('parcel.delivery_charge')}}</th>
                                    <th>{{ __('parcel.cod_charges')}}</th>
                                    <th>{{ __('parcel.vat')}}</th>
                                    <th>{{ __('parcel.Total_Charge')}}</th>
                                    <th>{{ __('invoice.paid_out')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($invoice->parcels_paginations as $parcel)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{\Carbon\Carbon::parse($parcel->updated_at)->format('d-m-Y')}}</td>
                                        <td>{{@$parcel->invoice_no}}</td>
                                        <td>{{@$parcel->tracking_id}}</td>
                                        <td>
                                            <span>{{@$parcel->customer_name}}</span><br/>
                                            <span>{{ @$parcel->customer_phone }}</span>
                                        </td>
                                        <td>{{ settings()->currency }}{{@$parcel->cash_collection}}</td>
                                        <td>{{ settings()->currency }}{{@$parcel->delivery_charge}}</td>
                                        <td>{{ settings()->currency }}{{@$parcel->cod_amount}}</td>
                                        <td>{{ settings()->currency }}{{@$parcel->vat_amount}}</td>
                                        <td>{{ settings()->currency }}{{@$parcel->total_delivery_amount + @$parcel->vat_amount}}</td>
                                        <td>{{ settings()->currency }}{{@$parcel->current_payable}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <span>{{ $invoice->parcels_paginations->links() }}</span>
                        <p class="p-2 small">
                            {!! __('Showing') !!}
                            <span class="font-medium">{{ $invoice->parcels_paginations->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-medium">{{ $invoice->parcels_paginations->lastItem() }}</span>
                            {!! __('of') !!}
                            <span class="font-medium">{{ $invoice->parcels_paginations->total() }}</span>
                            {!! __('results') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
