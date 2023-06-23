<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabManageSquad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Squad;
use App\Models\Location;
use App\Models\Settlement;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

class SquadSettlementController extends Controller
{
    protected $view = 'arvi.backend.manage-squad.squad-settlement.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $b = ''; //temp
        if ($companyCode == 'superAdmin') {
            $a = Squad::join('locations','squads.location_id','=','locations.id')
                ->select('squads.*','locations.name as location',
                'locations.id as location_id');
            if (isset($request->select_filter)) {
                if ($request->select_filter == "all") {
                    $b = $a;
                }
                else if (substr($request->select_filter,0,1) == "a") {
                    $b = $a->where('squads.active',substr($request->select_filter,1,1));
                } 
                else if (substr($request->select_filter,0,1) == "s"){
                    $b = $a->where('squads.settlement_status',substr($request->select_filter,1,1));
                }
                else {
                    $b = $a->where('location_id',substr($request->select_filter,1,1));
                }
                $squads = $b->orderBy('squads.id','DESC')->get();
                return view($this->view . 'page-admin-squad-settlement-data',
                        compact('squads','companyCode'));
            } else {
                $squads = $a->orderBy('squads.id','DESC')->get();
                return view($this->view . 'page-admin-squad-settlement',
                        compact('squads','companyCode'));
            }
        }
        return view('arvi.page-not-available');
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
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            // add balance
            $squad = Squad::find($request->id);
            $squad->balance += $request->balance;
            $squad->remaining += $request->balance;
            $squad->save();
        }
        return view('arvi.page-not-available');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $squad = Squad::select('name','id')->find($request->id);
            $a = MerchantOrder::
            join('settlements','merchant_orders.id','=','settlements.merchant_order_id')
            ->join('squads','settlements.squad_id','=','squads.id')
            ->join('locations','squads.location_id','=','locations.id')
            ->join('merchants','merchant_orders.merchant_id','=','merchants.id')
            ->join('brands','brands.id','=','merchants.brand_id')
            ->join('merchant_order_details','merchant_order_details.merchant_id','=','merchants.id')
            ->join('merchant_products','merchant_order_details.product_id','=','merchant_products.id')
            ->select(
                'merchant_orders.id',
                'merchant_orders.create_time',
                'merchant_orders.create_time as transaction_date',
                'settlements.progress_status as progress_status',
                'locations.name as location',
                'merchants.name as store',
                'brands.currency as currency',
                'merchant_orders.name as customer',
                'settlements.settlement_status as settlement_status',
                'settlements.create_time as settlement_date',
                'squads.name as squad_name',
                'squads.id as squad_id',
                'settlements.id',
                'settlements.remaining as remaining',
                'locations.id as location_id'
            )
            ->where('squads.id',$request->id);
            if (isset($request->startDate)) {
                $b = ''; //temp
                $c = ''; //temp
                // date
                $startDate = date('Y-m-d',strtotime($request->startDate,true));
                $endDate = date('Y-m-d',strtotime($request->endDate,true));
                $b = $a->whereDate('merchant_orders.create_time', '>=', $startDate)
                ->whereDate('merchant_orders.create_time', '<=', $endDate);
                // location
                if ($request->filter_location != 'all') {
                    $c = $b->where('location_id',$request->filter_location); 
                } else {
                    $c = $b;
                }
                // settle
                if (substr($request->filter_settle,0,1) == "t") {
                    $d = $c->where('settlements.settlement_status',substr($request->filter_settle,1,1));
                } else if (substr($request->filter_settle,0,1) == "s"){
                    $d = $c->where('progress_status',substr($request->filter_settle,1,1)); 
                } else {
                    $d = $c;
                }
                // finish
                $settlements = $a->limit(1000)->get()->unique('id');     
                return view($this->view . 'page-admin-squad-settlement-view-data',
                    compact('squad','settlements','companyCode'));
            } else {
                $settlements = $a->limit(1000)->get()->unique('id'); 
                return view($this->view . 'page-admin-squad-settlement-view',
                    compact('squad','settlements','companyCode'));
            }
        }
        return view('arvi.page-not-available');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
