<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Invoice;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Filters\v1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InvoiceResource;
use App\Http\Resources\v1\InvoiceCollection;
use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;
use App\Http\Requests\v1\BulkStoreInvoiceRequest;

/**
 * @group Invoice management
 *
 * APIs for managing invoices
 */
class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $filter  = new InvoicesFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        }
    }

    /**
     * Store a bulk created invoice in storage.
     */
    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }
}
