<?php
namespace App\Repositories\Invoice;

use App\Enums\InvoiceStatus;
use App\Enums\ParcelStatus;
use App\Enums\UserType;
use App\Models\Backend\Merchant;
use App\Models\Backend\Merchantpanel\Invoice;
use App\Models\Backend\Parcel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Invoice\InvoiceInterface;
use Illuminate\Support\Str;
class InvoiceRepository implements InvoiceInterface {
    //merchant panel invoice
    public function get(){
        return Invoice::where('merchant_id',Auth::user()->merchant->id)->orderByDesc('id')->paginate(10);
    }

    public function getPaidInvoices(){
        return Invoice::where('status',InvoiceStatus::PAID)->orderByDesc('id')->paginate(10,['*'],'paid_invoice_page');
    }

    public function getProcessInvoices(){
        return Invoice::where('status',InvoiceStatus::PROCESSING)->orderByDesc('id')->paginate(10,['*'],'processing_invoice_page');
    }
    public function getUnpaidInvoices(){
        return Invoice::where('status',InvoiceStatus::UNPAID)->orderByDesc('id')->paginate(10,['*'],'unpaid_invoice_page');
    }


    public function InvoiceDetails($invoiceId){
        return Invoice::where(['merchant_id'=>Auth::user()->merchant->id,'invoice_id'=>$invoiceId])->first();
    }
    public function store($merchant_id){
        try {
            //generated parcels id
            $ParcelInvoice        = Invoice::where('merchant_id',$merchant_id)->pluck('parcels_id')->toArray();
            $generated_parcels_id = [];
            foreach ($ParcelInvoice as $key => $inv) {
                foreach ($inv as $key => $value) {
                    $generated_parcels_id[]=$value;

                }
            }
            $gnrtd_parcels_id = collect($generated_parcels_id)->unique()->toArray();
            //end generated parcels id
            $parcels              = Parcel::where('merchant_id',$merchant_id)->whereIn('status',[ ParcelStatus::DELIVERED,ParcelStatus::PARTIAL_DELIVERED])->whereNotIn('id',$gnrtd_parcels_id)->orderByDesc('id')->get();
            $merchantFind         = Merchant::find($merchant_id);
            $merchant_date        = strtotime(\Carbon\Carbon::today()->subDays($merchantFind->payment_period)->format('d-m-Y'));
            $invoiceFind          = Invoice::where('merchant_id',$merchantFind->id)->get()->last();
            if($invoiceFind):
                $strtotime        = strtotime(\Carbon\Carbon::parse($invoiceFind->created_at)->format('d-m-Y'));
            else:
                $strtotime        = $merchant_date;
            endif;
            $invoiceAlreadyGenerated = Invoice::where('merchant_id', $merchant_id)->whereBetween('created_at', [\Carbon\Carbon::today()->startOfDay(), \Carbon\Carbon::today()->endOfDay()])->get()->last();

            if($strtotime <= $merchant_date && !$invoiceAlreadyGenerated):
                if(count($parcels) > 0){
                    $invoice                  = new Invoice();
                    $invoice->merchant_id     = $merchant_id;
                    $invoice->invoice_id      = $this->invoiceId($merchant_id);
                    $invoice->invoice_date    = Carbon::today()->format('d-m-Y');
                    $invoice->total_charge    = $parcels->sum('total_delivery_amount') + $parcels->sum('vat_amount');
                    $invoice->cash_collection = $parcels->sum('cash_collection');
                    $invoice->current_payable = $parcels->sum('current_payable');
                    $invoice->parcels_id      = $parcels->pluck('id')->toArray();
                    $invoice->save();
 
                }
            endif;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function invoiceId($merchant_id){
        $merchant          = Merchant::find($merchant_id);
        $merchantId        = $merchant->id;
        $prefix            = Str::upper(settings()->invoice_prefix).'-';
        $invoicecount      = Invoice::all()->count();
        $invoice_id        = $prefix . $merchantId . ($invoicecount+1) ;
        return $invoice_id;
    }

    //admin panel merchant invoice
    public function merchantInvoiceGet($merchantId){
        return Invoice::where('merchant_id',$merchantId)->orderByDesc('id')->paginate(10);
    }
    public function merchantInvoiceDetails($merchantId, $invoiceId){
        return Invoice::where(['merchant_id'=>$merchantId,'invoice_id'=>$invoiceId])->first();
    }

    public function statusUpdate($request,$merchant_id){
        try {
            $invoice  = Invoice::where([
                            'id'=>$request->id,
                            'merchant_id'=>$merchant_id,
                            'invoice_id'=>$request->invoice_id
                        ])->first();

            if($invoice):
                $invoice->status  = $request->status;
                $invoice->save();
            else:
                return false;
            endif;
            return true;
        } catch (\Throwable $th) {
           return false;
        }
    }
    //end admin panel merchant invoice


    //both panel invoice print
    public function InvoicePdf($merchant_id,$invoice_id){
        try {
            $invoice  = Invoice::where(['merchant_id'=>$merchant_id,'invoice_id'=>$invoice_id])->first();
            return $invoice;
        } catch (\Throwable $th) {
            return false;
        }
    }


    //get invoice
    public function invoiceGet($merchant_id,$invoice_id){
        try {
            $invoice  = Invoice::where(['merchant_id'=>$merchant_id,'invoice_id'=>$invoice_id])->first();
            return $invoice;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //get invoice
    public function getFind($id){
        try {
            $invoice  = Invoice::find($id);
            return $invoice;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function invoiceLists(){ 
        $invoices = Invoice::where('merchant_id',Auth::user()->merchant->id)->where('status',InvoiceStatus::PAID,InvoiceStatus::PROCESSING)->paginate(10);
        return $invoices;
    }

}
