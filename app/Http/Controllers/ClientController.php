<?php
namespace App\Http\Controllers;

use App\Models\ChargePoint;
use App\Models\ChargepiontConnector;
use App\Models\Connector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ClientController extends Controller
{
    public function getChargepoints()
    {
        $chargePoints = ChargePoint::get();
        return response()->json($chargePoints);
    }

    public function getConnectors(Request $request)
    { 
        $connectors = ChargepiontConnector::leftJoin('connectors','chargepoint_connector.connector_id', '=', 'connectors.id')
                            ->select('connectors.id','connectors.Type')
                            ->where('chargepoint_id', $request->cp_id)
                            ->get();
        
        return response()->json($connectors);
    }

    public function bootNotification(Request $request)
    {
        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result
        $UniqueId = str_shuffle($pin);

        $cp_id = $request->get('cp_id');
        $chargepoint = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        $connector = $request->get('connector');
        $metadata = [
            2,
            $UniqueId,
            'BootNotification',
            [
                'chargePointVendor' => 'chargeMOD',
                'chargePointModel' => $chargepoint,
                'chargeBoxSerialNumber' => $request->get('chargeBoxSerialNumber'),
                'chargePointSerialNumber' => $request->get('chargePointSerialNumber'),
                'firmwareVersion' => 'V1',
                'meterType' => 'INTERNAL',
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
        
        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result
        $UniqueId = str_shuffle($pin);

        $metadata = [
            2,
            $UniqueId,
            'Authorize',
                [
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

        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result - UniqueId
        $UniqueId = str_shuffle($pin);
        // shuffle the result - reservationId
        $reservationId = str_shuffle($pin);

        $metadata = [
            2,
            $UniqueId,
            'StartTransactionRequest',
                [
                    'chargepoint' => $cp_id,
                    'connectorId' => $con_id,
                    'idTag' => $id_tag,
                    'meterStart' => '1230',
                    'reservationId' => $reservationId,
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

        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result
        $UniqueId = str_shuffle($pin);


        $metadata = [
            2,
            $UniqueId,
            'MeterValuesRequest',
            [
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

        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result
        $UniqueId = str_shuffle($pin);

        $metadata = [
            2,
            $UniqueId,
            'HeartBeatRequest',
            [
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

        $numbers = '0123456789';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $numbers[rand(0, strlen($numbers) - 1)];

        // shuffle the result
        $UniqueId = str_shuffle($pin);

        $metadata = [
            2,
            $UniqueId,
            'StopTransactionRequest',
            [
                    'chargepoint' => $cp_id,
                    'connectorId' => $con_id,
                    'idTag' => $id_tag,
                    'meterStop' => '1600',
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