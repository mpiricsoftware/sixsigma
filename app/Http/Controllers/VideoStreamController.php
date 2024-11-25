<?php

namespace App\Http\Controllers;

use App\Models\VideoStream;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VideoStreamController extends Controller
{
    public function videoStreamManage()
    {
        $streams = VideoStream::get();
        // dd($streams);
        return view('panel.video-stream.index',['streams' => $streams]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'protocol',
            3 => 'camera_ip',
        ];

        $search = [];

        $totalData = VideoStream::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sites = VideoStream::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sites = VideoStream::where('id', 'LIKE', "%{$search}%")
                ->orWhere('protocol','LIKE', "%{$search}%")
                ->orWhere('camera_ip', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = VideoStream::where('id', 'LIKE', "%{$search}%")
                ->orWhere('protocol','LIKE', "%{$search}%")
                ->orWhere('camera_ip', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = [];
        // dd($sites);
        if (!empty($sites)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($sites as $site) {
                $nestedData['id'] = $site->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['protocol'] = $site->protocol;
                $nestedData['camera_ip'] = $site->camera_ip;

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $streamID = $request->id;
        // dd($request->all());
        if ($streamID) {
            // update the value
            $streams = VideoStream::where('id', $streamID)
            ->update([
                'name' => $request->name,
                'protocol' => $request->protocol,
                'username' => $request->username,
                'password' => $request->password,
                'camera_ip' => $request->camera_ip,
                'port' => $request->port
            ]);
            return response()->json('Updated');
        } else {
            // create new stream
            $streams = VideoStream::create([
                'name' => $request->name,
                'protocol' => $request->protocol,
                'username' => $request->username,
                'password' => $request->password,
                'camera_ip' => $request->camera_ip,
                'port' => $request->port
            ]);
            return response()->json('Created');
        }
    }

    public function show(VideoStream $videoStream)
    {
        //
    }

    public function edit($id)
    {
        $stream = VideoStream::findOrFail($id);
        return response()->json($stream);
    }

    public function update(Request $request, VideoStream $videoStream)
    {
        //
    }

    public function destroy($id)
    {
        $stream = VideoStream::where('id', $id)->delete();
    }
}
