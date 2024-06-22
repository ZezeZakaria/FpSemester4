<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('admin.invoice.view', ['items' => Invoice::get()]);
    }

    public function judgement(Request $request, string $id, string $judgement)
    {
        $invoice = Invoice::where(['id' => $id])->firstOrFail();

        $status = $judgement == 'OK' ? 'accepted' : 'rejected';
        $invoice->status = $status;
        $invoice->save();

        session()->flash('msg', 'Berhasil mengubah status invoice');
        return redirect()->route('invoice.index');
    }
}
