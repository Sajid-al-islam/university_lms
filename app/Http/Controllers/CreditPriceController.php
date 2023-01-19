<?php

namespace App\Http\Controllers;

use App\Models\CreditPrice;
use Illuminate\Http\Request;

class CreditPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creditPrice = CreditPrice::first();

        return view('creditPrice.index', ['creditPrice' => $creditPrice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $creditPrice = CreditPrice::create([
            'credit_count' => 1,
            'cost_per_credit' => $request->price,
        ]);

        if (!isset($creditPrice)) return back()->with('error', 'Something went wrong');

        return back()->with('success', 'Successfully set a price');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditPrice  $creditPrice
     * @return \Illuminate\Http\Response
     */
    public function show(CreditPrice $creditPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditPrice  $creditPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditPrice $creditPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditPrice  $creditPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditPrice $creditPrice)
    {
        $creditPrice = $creditPrice::where('id', $creditPrice->id)
            ->update([
                'cost_per_credit' => $request->price,
            ]);

        if (!isset($creditPrice)) return back()->with('error', 'Something went wrong');

        return back()->with('success', 'Successfully set a price');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditPrice  $creditPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditPrice $creditPrice)
    {
        //
    }
}
