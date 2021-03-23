<?php

namespace App\Http\Controllers;
use App\Models\ChargePoint;
use App\Models\CPConnector;
use App\Models\ConnectorType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Events\BootNotification;

class ClientController extends Controller
{
    public function getChargepoints()
    {
        $chargePoints = ChargePoint::get();
        return response()->json($chargePoints);
    }
    public function getConnectors(Request $request)
    { 
        $connectors = CPConnector::leftJoin('connectortype','cp_connector.connector_type', '=', 'connectortype.id')
                            ->select('connectortype.id','connectortype.Type')
                            ->where('cp_id', $request->cp_id)
                            ->get();
        
        return response()->json($connectors);
    }
    public function bootNotification(Request $request)
    {
        $cp_id = $request->get('cp_id');

        $chargePointModel = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        // dd($chargePointModel);
        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'BootNotificationRequest',
            'payload' => [
                'chargePointVendor' => 'Point1',
                'chargePointModel' => $chargePointModel,
                'chargePointSerialNumber' => $request->get('chargePointSerialNumber'),
                'chargeBoxSerialNumber' => $request->get('chargeBoxSerialNumber'),
                'firmwareVersion' => 'V1',
                'iccid' => '1111',
                'imsi' => '2222',
                'meterType' => 'metertype1',
                'meterSerialNumber' => 'MTR1234'
            ]
        ];
        // dd($chargePointModel);
        $data = json_encode($metadata);
        // dd($data);
        broadcast(new BootNotification($data,$cp_id));
    }
    public function authenticate(Request $request)
    {
        $cp_id = $request->get('cp_id');
        $tag = $request->get('id_tag');
        if (User::where('user_id', '=', $tag)->exists()){
            $metadata = [
                'MessageTypeId' => '2',
                'UniqueId' => '746832',
                'title' => 'Authorize',
                    'payload' => [
                        'idTag' => $tag
                    ]
            ];
        $data = json_encode($metadata);
            broadcast(new BootNotification($data,$cp_id));
        }
        else {
            echo "no user";
        }
        
    }
}