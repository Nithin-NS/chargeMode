<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsgFile;
use Illuminate\Support\Facades\Storage;

class StationMessageController extends Controller
{
    public function index()
    {
        $data = MsgFile::leftJoin('chargepoints', 'msg_files.cp_id', '=', 'chargepoints.CP_ID')
              ->leftJoin('chargepoint_connector', 'msg_files.cp_id', '=', 'chargepoint_connector.chargepoint_id')
              ->select('chargepoints.CP_Name', 'chargepoint_connector.status', 'chargepoints.CP_ID','msg_files.cp_id', 'msg_files.id', 'msg_files.type', 'msg_files.file_path', 'msg_files.created_at' )
              ->orderBy('msg_files.id', 'desc')
              ->get();
        return view('pages/messages/index')->with('data', $data);
    }

    public function getDeviceMessages()
    {
        $path = "/public/device_messages/messages.json";

        $json = json_decode(file_get_contents($path), true);

        return $json;
    }
}
