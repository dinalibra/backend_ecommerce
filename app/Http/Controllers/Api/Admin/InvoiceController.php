<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->when(request()->q,
        function($invoices) {
        $invoices = $invoices->where('invoice', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);
        return new InvoiceResource(true, 'List Data Invoices', $invoices);
    }
        
    public function show($id)
    {
        $invoice = Invoice::with('orders.product', 'customer', 'city',
        'province')->whereId($id)->first();
        if($invoice) {
            return new InvoiceResource(true, 'Detail Data Invoice!', $invoice);
        }
        return new InvoiceResource(false, 'Detail Data Invoice Tidak Ditemukan!', null);
    }
}
