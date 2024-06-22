<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoiceNumberSequence;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = Invoice::where(['user_id' => $request->user()->id])
            ->with(['details.product', 'user'])->get();
        return response()->json(['data' => $data]);
    }


    public function show(Request $request, string $id)
    {
        return response()->json(['data' => Invoice::where(['id' => $id])->with(['details.product'])->first()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required',
            'details.*.quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'error' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            //code...
            $seq = InvoiceNumberSequence::firstOrCreate(['month' => date('Y')], ['month' => date('Y'), 'sequence' => 0]);

            $seq->sequence += 1;
            $seq->save();

            $seq_str = str_pad($seq->sequence, 4, "0", STR_PAD_LEFT);
            $invoice_number = sprintf("INV-%d%d%s", date("Y"), date("m"), $seq_str);

            $invoice = new Invoice;
            $invoice->invoice_number = $invoice_number;
            $invoice->user_id = $request->user()->id;
            $invoice->status = "pending";
            $invoice->save();

            foreach ($request->details as $d) {
                $product = Product::where(['id' => $d['product_id']])->first();
                $product->stock -= $d['quantity'];

                if ($product)
                    $product->save();

                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $d['product_id'],
                    'quantity' => $d['quantity'],
                    'price' => $product->price
                ]);
            }
            DB::commit();

            return response()->json(['message' => 'Berhasil membuat pesanan'], 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan internal'], 500);
        }
    }

    public function uploadPayment(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), ['image' => 'required|mimes:png,jpg']);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'error' => $validator->errors()], 400);
        }

        $invoice = Invoice::where(['id' => $id])->first();
        $invoice->payment_file = Storage::disk('public')
            ->put('payment', $request->image);
        $invoice->status = "on-check";
        $invoice->save();

        return response()->json(['message' => 'Berhasil mengunggah bukti pembayaran'], 201);
    }
}
