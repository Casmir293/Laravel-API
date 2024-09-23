<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\v1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Http\Resources\v1\CustomerCollection;

/**
 * @group Customer management
 *
 * APIs for managing customers
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $filter  = new CustomersFilter();
        $filterItems = $filter->transform($request);
        $includeInvoices = $request->query('includeInvoices');
        $customers = Customer::where($filterItems);

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified customer.
     */
    public function show(Request $request, Customer $customer)
    {
        $includeInvoices = $request->query('includeInvoices');

        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
    }
}
