<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                    'updated_at'        =>  Carbon::parse($this->update_at)->format('d-m-Y'),
                    'customer_name'     => $this->customer_name,
                    'customer_phone'    => $this->customer_phone,
                    'cutomer_address'   => $this->customer_address,
                    'invoice_id'       => $this->invoice_no,
                    'tracking_id'       => $this->tracking_id,
                    'cash_collection'   => $this->cash_collection,
                    'delivery_charge'   => $this->delivery_charge,
                    'vat'               => $this->vat_amount,
                    'cod_charge'        => $this->cod_amount,
                    'total_charge'      => $this->total_delivery_amount + $this->vat_amount,
                    'current_payable' => $this->current_payable,

                ];
    }
}
