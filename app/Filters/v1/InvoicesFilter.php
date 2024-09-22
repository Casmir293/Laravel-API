<?php

namespace App\Filters\v1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoicesFilter extends ApiFilter
{

    // $table->integer('customer_id');
    //         $table->integer('amount');
    //         $table->string('status');
    //         $table->dateTime('billed_date');
    //         $table->dateTime('paid_date')->nullable();
    protected $safeParams = [
        'customerId' => ['eq'],
        'amount' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'status' => ['eq', 'ne'],
        'billedDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'paidDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',
    ];
}
