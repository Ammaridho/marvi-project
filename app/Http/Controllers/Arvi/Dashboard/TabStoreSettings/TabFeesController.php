<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabStoreSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PragmaRX\Countries\Package\Countries;
use App\Models\Fee;
use App\Models\Company;

class TabFeesController extends Controller
{
    protected $view = 'arvi.backend.fees-&-discount.fees.'; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $fees = Fee::where('company_id',$data->id)->get();
            return view($this->view.'page-fee',
                compact('companyCode','fees'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $aa = new Countries();
            $currencies = $aa->currencies();
            return view($this->view.'page-fee-add',
                compact('companyCode','currencies'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $validatedData = $request->validate([
                'name'       => 'required',
                'type_fee'   => 'required',
                'value_fee'  => 'required',
                'type_value' => 'required',
            ]);
            $fee = new Fee;
            $fee->company_id = $data->id;
            $fee->name       = $request->name;
            $fee->type_fee   = $request->type_fee;
            $fee->value_fee  = $request->value_fee;
            $fee->type_value = $request->type_value;
            if ($request->type_value == 'fixed') {
                $fee->currency   = $request->currency;
            }
            $fee->active     = isset($request->active)?1:0;
            $fee->save();
        }
        return view('arvi.page-not-available');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $fee_id = $request->id;
            $fee = Fee::find($fee_id);
            $aa = new Countries();
            $currencies = $aa->currencies();
            return view($this->view.'page-fee-edit',
                compact('companyCode','fee','fee_id','currencies'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            if (!isset($request->name)) {
                $fee = Fee::find($request->id);
                $fee->active = $request->active;
                $fee->save();
            } else {
                $validatedData = $request->validate([
                    'name'       => 'required',
                    'type_fee'   => 'required',
                    'value_fee'  => 'required',
                    'type_value' => 'required',
                ]);
                $fee = Fee::find($request->fee_id);
                $fee->company_id = $data->id;
                $fee->name       = $request->name;
                $fee->type_fee   = $request->type_fee;
                $fee->value_fee  = $request->value_fee;
                $fee->type_value = $request->type_value;
                if ($request->type_value == 'fixed') {
                    $fee->currency   = $request->currency;
                }
                $fee->active     = isset($request->active)?1:0;
                $fee->save();
            }
        }
        return view('arvi.page-not-available');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Fee::find($request->id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
