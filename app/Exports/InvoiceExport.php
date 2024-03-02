<?php

namespace App\Exports;

use App\Models\Backend\Merchantpanel\Invoice;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($merchant_id,$invoice_id)
    {
        $this->merchant_id = $merchant_id;
        $this->invoice_id = $invoice_id;
    }
    public function headings(): array
    {
        return [
            'Delivery Date',
            'Customer Name',
            'Customer Phone',
            'Customer Address',
            'Invoice ID',
            'Tracking ID',
            'Cash Collection (TK)',
            'Delivery Charge',
            'Vat',
            'COD',
            'Total Charge',
            'Paid out'
        ];
    }
    public function collection()
    {
        $invoice = Invoice::where(['merchant_id'=>$this->merchant_id,'invoice_id'=>$this->invoice_id])->select('id','invoice_id','parcels_id')->first();
        return $invoice->invoice_parcels_export;
    }
}
