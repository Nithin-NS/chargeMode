<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChargePoint;
use App\Models\Connector;
use App\Models\ChargepiontConnector;
use Illuminate\Support\Facades\DB;

class ChargePointController extends Controller
{
    //index
    public function index()
    {
        $data=ChargePoint::all();
        return view('pages/chargepoints/index')->with('data', $data);
    }

    //create new chargepoint
    public function create()
    {
        $connector = Connector::get();
        return view('pages/chargepoints/create', compact('connector'));
    }

    //store new chargepoint
    public function store(Request $request)
    {
        $this->validate($request,[
            'CP_Name' => 'required',
            'CP_State' => 'required',
            'CP_District' => 'required',
            'CP_Loc' => 'required',
            //'CP_Connector_Type'=>'required',
            'CB_Serial_No' => 'required',
            'CP_Serial_No' => 'required',
            'CP_Firmware_Ver' => 'required',
            'CP_Meter_Serial_No' => 'required',
            'CP_Meter_Type' => 'required',
            'Station_Phone' => 'required',
            'Station_Email' => 'required' 
        ]);
        $chargepoint = new ChargePoint();
        $chargepoint->CP_Name=$request->CP_Name;
        $chargepoint->CP_State=$request->CP_State;
        $chargepoint->CP_District=$request->CP_District;
        $chargepoint->CP_Loc=$request->CP_Loc;
        //$data->CP_Connector_Type=$request->CP_Connector_Type;
        $chargepoint->CB_Serial_No=$request->CB_Serial_No;
        $chargepoint->CP_Serial_No=$request->CP_Serial_No;
        $chargepoint->CP_Firmware_Ver=$request->CP_Firmware_Ver;
        $chargepoint->CP_Meter_Serial_No=$request->CP_Meter_Serial_No;
        $chargepoint->CP_Meter_Type=$request->CP_Meter_Type;
        $chargepoint->Station_Phone=$request->Station_Phone;
        $chargepoint->Station_Email=$request->Station_Email;
        //$chargepoint->CP_Status="0";
        $chargepoint->save();

        if ($request->has('charging_pin_id')) {
            for ($x = 0; $x < count($request->charging_pin_id); $x++) {
                $store = ['Type' => $request->charging_pin_id[$x],
                    'cp_id' => $chargepoint->CP_ID,
                    //'relay_switch_number' => $request->relay_switch_number[$x],
                    'status' => 0 
                ];
                Connector::create($store);
            }
        }
        return redirect(route('chargepoints'))->with('success','Added Successfully');
    }

    //details
    public function details($id)
    {
        $data = ChargePoint::where('CP_ID',$id)->first();
        
        $connector = Connector::with('chargepoints')->find($id);
        // $connector = Connector::leftJoin('connectors','connectors.id', '=', 'chargepoint_connector.connector_id')
        //         ->select('chargepoint_connector.status')
        //         ->select('connectors', 'connectors.Type')
        //         ->where('cp_id', $id)
        //         ->get();
        return view('pages/chargepoints/details',compact('data', 'connector'));
    }

    //Edit method
    public function show($id)
    {
        $data = ChargePoint::where('CP_ID',$id)->first();
        $connector = Connector::get();
        $selected_id = ChargepiontConnector::where('chargepoint_id',$id)->first()->connector_id;
        $selected_con = Connector::where('id',$selected_id)->first();

        // dd($selected_con);
        return view('pages/chargepoints/edit',compact('data', 'selected_con','connector'));
    }

    //Update method
    public function update(Request $request,$id)
    {
        $data=ChargePoint::where('CP_ID',$id)->first();

        $validated_data= $this->validate($request,[
            'CP_Name'=>'',
            'CP_State'=>'',
            'CP_District'=>'',
            'CP_Loc'=>'',
            // 'CP_Connector_Type'=>'',
            'CB_Serial_No'=>'',
            'CP_Serial_No'=>'',
            'CP_Firmware_Ver'=>'',
            'CP_Meter_Serial_No'=>'',
            'CP_Meter_Type'=>'',
            'Station_Phone'=>'',
            'Station_Email'=>'',
            'CP_Status'=>''
        ]);
        ChargePoint::where('CP_ID',$id)->update($validated_data);
        $cp_co_id = $request->CP_Connector_Type;
        // $con = Connector::where('id',$cp_co_id)->get('Type');
        // $con = DB::table('connectors')
        //     ->select('Type')
        //     ->where('id','=', $cp_co_id)
        //     ->first();
        // dd($cp_co_id);
        $data->connectors()->sync($cp_co_id);
        // ChargepiontConnector::where('id',$cp_co_id)->updateOrCreate(array(
        //     'chargepoint_id' => $id,
        //     'connector_id' => $cp_co_id,
        //     // 'connector_id' => 'status'
        // ));
        return redirect(route('chargepoints'))->with('success','Updated Successfully');
    }

    //Delete chargepoint
    public function destroy($id)
    {
        $data=ChargePoint::where('CP_ID',$id)->first();
        $data->delete();
        return redirect(route('chargepoints'))->with('success','Deleted Successfully');;
    }
    
    //search method
    public function searchchargepoint()
    {
        $search = \Request::get('search');
        // dd($search);
        $data = ChargePoint::where('CP_Name','like','%'.$search.'%')
            ->orWhere('Station_Phone','like','%'.$search.'%')
            ->orWhere('Station_Email','like','%'.$search.'%')
            ->orderBy('CP_Name')
            ->paginate(20);

        return view('pages/chargepoints/index')->with('data',$data);  
    }
}
