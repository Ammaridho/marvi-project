<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MerchantHour;
use App\Models\Merchant;
use App\Models\Company;

use Carbon\Carbon;

class MerchantHoursController extends Controller
{
    protected $view = 'arvi.backend.manage-merchant.merchant-hours.'; 

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
            if ($request->first_hours) {
                $company_id = $data->id;
                $id = Merchant::where('company_id',$company_id)->first()->id;
            } else {
                $id = $request->id;
            }
            $alreadySet = MerchantHour::where('merchant_id',$id)
            ->pluck('day')->all();
            $specialDates = MerchantHour::where('merchant_id', $id)
            ->where('hours_type','special')->get();
            
            $days = array_map('strtolower', Carbon::getDays());
            // set monday first
            $temp = $days[0];
            array_shift($days);
            $days[6] = $temp;

            $merchantName = Merchant::find($id)->name;
            return view( $this->view . 'page-manage-store-hours' ,
                compact('companyCode','alreadySet','id',
                'days','specialDates','merchantName'));
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
            if ( isset($request->type) == 'special') {
                $id = $request->id;
                $hours = MerchantHour::where('merchant_id', $id)
                ->where('hours_type','special')->get();
                $countHours = count($hours);
                return view(
                    $this->view . 'special-dates',
                    compact('companyCode','hours','id','countHours')
                );
            }else{
                $id = $request->id;
                $day = $request->day;
                $hours = MerchantHour::where('merchant_id', $id)
                ->where('day', $day)->first();
                return view(
                    $this->view . 'trading-hours',
                    compact('companyCode', 'hours', 'id', 'day')
                );
            }
        }
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
            $merchant_id = $request->merchant_id;

            // check if it special date or normal days
            if (isset($request->hours_type) == 'special') {
                $validatedData = $request->validate([
                    'hours_type'    => 'required',
                    'merchant_id'   => 'required',
                    'date'          => ['required',
                        function ($attribute, $value, $fail) use ($request)
                        {
                            $specialDates = MerchantHour::find($request->dates_id);
                            if ($specialDates) {
                                $olderDate = MerchantHour::where('merchant_id',$request->merchant_id)
                                ->pluck('date')->toArray();
                                foreach (array_keys($olderDate, $specialDates->date) as $key) {
                                    unset($olderDate[$key]);
                                }
                            }else{
                                $olderDate = MerchantHour::where('merchant_id',$request->merchant_id)
                                ->pluck('date')->toArray();
                            }
                            $string = str_replace(' / ', '-', $value);
                            $time = strtotime($string);
                            $newformat = date('Y-m-d',$time);
                            if(in_array($newformat,$olderDate)){
                                $fail('Selected date already used as another special date.');
                            }
                        }],


                    'name'          => 'required',
                    'condition'     => 'required',
                ]);
                $specialDates = MerchantHour::find($request->dates_id);
                // check if data already set in that day
                if (isset($specialDates)) {
                    $specialDates->merchant_id = $request->merchant_id;
                    $specialDates->hours_type  = $request->hours_type;
                    $specialDates->date        = $request->date;
                    $specialDates->name        = $request->name;
                    $specialDates->condition   = $request->condition;
                    $specialDates->save();
                } else {
                    $store = new MerchantHour();
                    $store->merchant_id = $request->merchant_id;
                    $store->hours_type  = $request->hours_type;
                    $store->date        = $request->date;
                    $store->name        = $request->name;
                    $store->condition   = $request->condition;
                    $store->save();
                }
            } else {
                $validatedData = $request->validate([
                    'merchant_id'   => 'required',
                    'hours_from'    => 'required',
                    'hours_to'      => 'required',
                    'day'           => 'required',
                ]);
                $hour = MerchantHour::where('merchant_id',$request->merchant_id)
                    ->where('day',$request->day)->first();

                // check if data already set in that day
                if (isset($hour)) {
                    $hour->hours_type  = 'normal';
                    $hour->hours_from  = $request->hours_from;
                    $hour->hours_to    = $request->hours_to;
                    $hour->condition   = 'open';
                    $hour->save();
                }else{
                    $store = new MerchantHour();
                    $store->merchant_id = $request->merchant_id;
                    $store->hours_type  = 'normal';
                    $store->hours_from  = $request->hours_from;
                    $store->hours_to    = $request->hours_to;
                    $store->condition   = 'open';
                    $store->day         = $request->day;
                    $store->save();
                }
            }
        }
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // special date or normal days
        if (isset($request->type) == 'special') {
            $hour = MerchantHour::find($request->dates_id);
            if (isset($hour)) { $hour->delete(); }
        } else {
            $hour = MerchantHour::where('merchant_id',$request->id)
            ->where('day',$request->day)->first();
            if (isset($hour)) { $hour->delete(); }
        }
    }
}
