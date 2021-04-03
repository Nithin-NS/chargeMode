<?php
namespace App\Http\Controllers;
use App\Models;
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
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $connector = $request->get('connector');
        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'BootNotification',
            'payload' => [
                'chargePointVendor' => $cp_id,
                'chargePointModel' => $chargepoint,
                'connector' => $connector,
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
        // event(new BootNotification($data));
        return $data;
    }
    
    public function authenticate(Request $request)
    {
        $cp_id = $request->get('cp_id');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $tag = $request->get('id_tag');
        $con_id = $request->get('connector');
        // $connector = ConnectorType::where('id', $con_id)->first()->Type;
        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'Authorize',
                'payload' => [
                    'idTag' => $tag,
                    'chargepoint' => $chargepoint,
                    'connector' => $con_id
                ]
        ];
        $data = json_encode($metadata);
        // broadcast(new BootNotification($data,$cp_id));
        return $data;
    }

    public function startCharging(Request $request)
    {
        $cp_id = $request->get('cp_id');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $con_id = $request->get('connector');
        $id_tag = $request->get('id_tag');

        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'StartTransactionRequest',
                'payload' => [
                    'chargepoint' => $cp_id,
                    'connectorId' => $con_id,
                    'idTag' => $id_tag,
                    'meterStart' => '1230',
                    'reservationId' => '1985',
                    'timestamp' => '12.12',
                ]
        ];

        $data = json_encode($metadata);
        return $data;
    }

    public function meterValues(Request $request)
    {
        $cp_id = $request->get('cp_id');
        $con_id = $request->get('connector');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $id_tag = $request->get('id_tag');

        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'MeterValuesRequest',
            'payload' => [
                'chargepoint' => $cp_id,
                'connectorId' => $con_id,
                'transactionId' => "94",
                'meterValue' => [
                'timeStamp' => "02-10-2020",
                'stampledValue' => [
                    'context' => "other",
                    'format' => "signedData",
                    'measurand' => "Power offered",
                    'phase' => "LI",
                    'location' => "EV",
                    'unit' => "Kwh"
                    ]
                ]
            ]
        ];

        $data = json_encode($metadata);
        return $data;
    }

    public function heartBeat(Request $request){
        $cp_id = $request->get('cp_id');
        $con_id = $request->get('connector');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $id_tag = $request->get('id_tag');

        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'HeartBeatRequest',
            'payload' => [
                'chargepoint' => $chargepoint,
                'connectorId' => $con_id,
                'transactionId' => "94",
                'meterValue' => [
                'timeStamp' => "02-10-2020",
                'stampledValue' => [
                    'context' => "other",
                    'format' => "signedData",
                    'measurand' => "Power offered",
                    'phase' => "LI",
                    'location' => "EV",
                    'unit' => "Kwh"
                    ]
                ]
            ]
        ];

        $data = json_encode($metadata);
        return $data;
    }

    public function stopCharging(request $request)
    {
        $cp_id = $request->get('cp_id');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $con_id = $request->get('connector');
        $id_tag = $request->get('id_tag');

        $metadata = [
            'MessageTypeId' => '2',
            'UniqueId' => '746832',
            'title' => 'StopTransactionRequest',
                'payload' => [
                    'chargepoint' => $chargepoint,
                    'connectorId' => $con_id,
                    'idTag' => $id_tag,
                    'meterStop' => '1230',
                    'transactionId' => '1985',
                    'reason' => 'Emergency Stop',
                    'transactionData' => [
                        'timeStamp' => "02-10-2020",
                        'stampledValue' => [
                            'context' => "other",
                            'format' => "signedData",
'                            measurand' => "Power offered",
                            'phase' => "LI",
                            'location' => "EV",
                            'unit' > "Kwh"
                    ]
                ]
            ]   
        ];

        $data = json_encode($metadata);
        // broadcast(new BootNotification($data,$chargepoint));
        return $data;
    }
}