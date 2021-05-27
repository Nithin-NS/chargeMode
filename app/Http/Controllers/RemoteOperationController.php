<?php

namespace App\Http\Controllers;

use App\Models\ChargePoint;
use App\Models\ChargepiontConnector;
use App\Models\Connector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class RemoteOperationController extends Controller
{
    public function findConnectors(Request $request)
    {
        $cp_id = $request->cp_id;
        $connectors = ChargepiontConnector::leftJoin('connectors','chargepoint_connector.connector_id', '=', 'connectors.id')
                            ->select('connectors.id','connectors.Type')
                            ->where('chargepoint_id', $cp_id)
                            ->get();
        return $connectors;
        // return $cp_id;
    }

    public function remotestart(Request $request,$id)
    {
        $id = $id;
        $con_id = $request->get('con_id');
        $cp_id = $request->get('cp_id');
        $id_tag = User::where('id', $id)->first()->user_id;
        $cp_name = ChargePoint::where('CP_ID', $cp_id)->first()->CP_Name;
        
        //generate unique id
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
            'RemoteStartRequest',
            [
                'chargepoint' => $cp_name,
                'connectorId' => $con_id,
                'idTag' => $id_tag,
                'meterStart' => '1230',
                'reservationId' => $reservationId,
                'timestamp' => '12.12',
            ]
        ];
        return $data = json_encode($metadata);
    }

    public function remotestop($id)
    {
        echo 'Stop '.$id;
    }
}
