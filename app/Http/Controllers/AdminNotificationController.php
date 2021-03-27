<?php

namespace App\Http\Controllers;

use App\Events\BootNotificationResponse;
use Illuminate\Http\Request;
use App\Models\chargePoint;
use App\Models\CPConnector;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminNotificationController extends Controller
{
    public function BootNotificationResponce(Request $request)
    {
        $chargePointModel = $request->get('chargePointModel');
        $cp_id = chargePoint::where('CP_Name', '=', $chargePointModel)->value('CP_ID');
        $mytime = Carbon::now();
        $interval = 2000;
        
        //If Charge Point Exists.
        if (chargePoint::where('CP_Name', '=', $chargePointModel)->exists()) {
            CPConnector::where('cp_id', '=', $cp_id)->update(['status' => 1]);
            //echo "BootNotificationResponce Accepted, and Status Changed to 1";
            $metadata = [
                'MessageTypeId' => '3',
                'UniqueId' => '746832',
                'payload' => [
                    'status' => 'Accepted',
                    'currenTime' => $mytime->toDateTimeString(),
                    'interval' => $interval,
                ]
            ];
            $data = json_encode($metadata);
            event(new BootNotificationResponse($data));
            return "ok";
         }

         //Charge Point Not Exists.
         else{
            echo "BootNotificationResponce Rejected";
            $metadata = [
                'MessageTypeId' => '3',
                'UniqueId' => '746832',
                'payload' => [
                    'status' => 'Rejected',
                    'currenTime' => $mytime->toDateTimeString(),
                    'interval' => $interval,
                ]
            ];
            $data = json_encode($metadata);
            event(new BootNotificationResponse($data));
         }
    }

    public function AuthenticateResponse(Request $request)
    {
        $idTag = $request->get('idTag');
        $mytime = Carbon::now();

        //if User Exists
        if (User::where('user_id', '=', $idTag)->exists()){
            $metadata = [
                'MessageTypeId' => '3',
                'UniqueId' => '746832',
                'payload' => [
                    'expiryDate' => $mytime->toDateTimeString(),
                    'parentIdTag' => '15478',
                    'status' => 'Accepted',
                ]
            ];
                $data = json_encode($metadata);
                event(new BootNotificationResponse($data));
        }
        //user not exists
        else{
            echo 'Auth error';
        }
    }

    public function TransactionResponse(Request $request)
    {
        //Getting Transaction data
        $idTag = $request->get('idTag');
        $meterStart = $request->get('meterStart');
        $chargepoint = $request->get('chargepoint');
        $cp_id = chargePoint::where('CP_Name', '=', $chargepoint)->value('CP_ID');
        $connectorId = $request->get('connectorId');
        $reservationId = $request->get('reservationId');
        $mytime = Carbon::now();

        //Saving Transaction data
        Transaction::create([
            'Connector_ID' => $connectorId,
            'CP_ID' => $cp_id,
            'User_ID' => $idTag,
            'Reservation_ID' => $reservationId,
            'Trans_DateTime' => $mytime->toDateTimeString(),
            'Trans_Meter_Start' => $meterStart
        ]);

        //Sending Responce
        $metadata = [
            'MessageTypeId' => '3',
            'UniqueId' => '746832',
            'payload' => [
                'expiryDate' => $mytime->toDateTimeString(),
                'parentIdTag' => '15478',
                'status' => 'Accepted',
            ],
            'transactionId' => '2468'
        ];
        $data = json_encode($metadata);
        event(new BootNotificationResponse($data));
    }

    public function MeterValues(Request $request)
    {

    }

    public function HeartBeatResponce(Request $request)
    {

    }
    
    public function StopTransaction(Request $request){

    }
}
