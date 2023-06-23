<?php
namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabManageSquad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Squad;
use App\Models\Location;
use App\Models\Settlement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class SquadAccountController extends Controller
{
    protected $view = 'arvi.backend.manage-squad.squad-account.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $squads = Squad::join('locations','squads.location_id','=','locations.id')
            ->select('squads.*','locations.name as location')
            ->orderBy('squads.id','DESC')
            ->get();
            return view($this->view . 'page-admin-squad-management',
                    compact('squads','companyCode'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $much = isset($request->much) ? $request->much : 25;
            if ($request->filter != 'all' ) {
                $squads = Squad::join('locations','squads.location_id','=','locations.id')
                ->select('squads.*','locations.name as location')
                ->where('squads.active', $request->filter)
                ->orderBy('squads.id','DESC')
                ->take($much)
                ->get();
            } else {
                $squads = Squad::join('locations','squads.location_id','=','locations.id')
                ->select('squads.*','locations.name as location')
                ->orderBy('squads.id','DESC')
                ->take($much)
                ->get();
            }
            return view($this->view . 'data-table-squad',
                    compact('companyCode','squads'));
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
        if ($companyCode == 'superAdmin') {
            $locations = Location::all();
            return view($this->view . 'page-admin-squad-management-new',
                    compact('locations','companyCode'));
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
        if ($companyCode == 'superAdmin') {
            $validatedData = $request->validate([
                'name'         => 'required',
                'phone_number' => 'required',
                'password'     => 'required|confirmed',
                'loc_id'       => 'required',
            ]);
            $squad = new Squad();
            $squad->name          = $request->name;
            $squad->phone_number  = $request->phone_number;
            $squad->password      = bcrypt($request->password);
            $squad->location_id   = $request->loc_id;
            $squad->save();
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
    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $squad_id = $request->id;
            $squad = Squad::find($squad_id);
            $locations = Location::all();
            return view($this->view . 'page-admin-squad-management-update',
                compact('squad','locations','companyCode'));
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
        if ($companyCode == 'superAdmin') {
            if (isset($request->statusActive)) {
                $squad               = Squad::find($request->id);
                $squad->active       = $request->statusActive;
                $squad->save();
            } else {
                if (isset($request->password)) {
                    $validatedData = $request->validate([
                        'name'         => 'required',
                        'phone_number' => 'required',
                        'password'     => 'required|confirmed',
                        'loc_id'       => 'required',
                    ]);
                } else {
                    $validatedData = $request->validate([
                        'name'         => 'required',
                        'phone_number' => 'required',
                        'loc_id'       => 'required',
                    ]);
                }
                $squad = Squad::find($request->id);
                $squad->name          = $request->name;
                $squad->phone_number  = $request->phone_number;
                $squad->password      = bcrypt($request->password);
                $squad->location_id   = $request->loc_id;
                $squad->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Squad::find($request->id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
