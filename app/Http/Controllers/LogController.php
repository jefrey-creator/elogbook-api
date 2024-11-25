<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{

    public function store(Request $request){
        $dateTime = Carbon::now('Asia/Manila');
        $dateToday = date_create($dateTime);

        $date = date_format($dateToday, "M d, Y");
        $timeIn = date_format($dateToday, "h:i:s A");


        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'person_to_visit' => 'integer|required',
            'req_category' => 'integer|required|max:1|min:0',
            'purpose' => 'string|required'
        ]);

        $store_log = Log::create([
            'full_name' => $data['full_name'],
            'date_visited' =>  $date,
            'time_in' => $timeIn,
            'person_to_visit' => $data['person_to_visit'],
            'req_category' =>  $data['req_category'],
            'purpose' => $data['purpose']
        ]);

        if($store_log){
            return response()->json([
                "message" => "Logs created successfully.",
            ], 201);
        }else{
            return response()->json([
                "message" => "Logs not save.",
            ], 422);
        }
        
       
    }

    public function accepted_logs(Request $request){

        $validatedData = $request->validate([
            'per_page' => 'nullable|integer',  // Optional, defaults to 10 if not provided
            'is_accepted' => 'nullable|integer|min:0|max:1', // Optional, defaults to 0 if not provided
        ]);

        $perPage = $validatedData['per_page'] ?? 10;  
        $isAccepted = $validatedData['is_accepted'] ?? 0; 

        $logs = DB::table('tbl_faculty')
            ->leftJoin('tbl_logs', 'tbl_logs.person_to_visit', '=', 'tbl_faculty.user_id')
            ->select(
                DB::raw('CONCAT(tbl_faculty.f_name, " ", COALESCE(tbl_faculty.m_name, ""), " ", tbl_faculty.l_name) as faculty_name'),
                'tbl_logs.full_name', 
                'tbl_logs.date_visited', 
                'tbl_logs.time_in', 
                'tbl_logs.time_out', 
                'tbl_logs.person_to_visit', 
                'tbl_logs.purpose', 
                'tbl_logs.action_taken', 
                'tbl_logs.is_accepted', 
                'tbl_logs.is_completed', 
                'tbl_logs.req_category')
                ->where('tbl_logs.person_to_visit', '=', Auth::id())
                ->where('tbl_logs.is_accepted', '=', $isAccepted)
                ->paginate($perPage);

        if ($logs->total() === 0 || $logs->currentPage() > $logs->lastPage()) {
            return response()->json([
                "message" => "No data available."
            ], 422);
        }

        return response()->json([
            'data' => $logs->items(),
            'pagination' => [
                'total' => $logs->total(),
                'per_page' => $logs->perPage(),
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
            ],
        ]);
    }

    public function completed_logs(Request $request){

        $validatedData = $request->validate([
            'per_page' => 'nullable|integer',  // Optional, defaults to 10 if not provided
            'is_completed' => 'nullable|integer|min:0|max:1', // Optional, defaults to 0 if not provided
        ]);

        $perPage = $validatedData['per_page'] ?? 10;  
        $is_completed = $validatedData['is_completed'] ?? 0; 

        $logs = DB::table('tbl_faculty')
            ->leftJoin('tbl_logs', 'tbl_logs.person_to_visit', '=', 'tbl_faculty.user_id')
            ->select(
                DB::raw('CONCAT(tbl_faculty.f_name, " ", COALESCE(tbl_faculty.m_name, ""), " ", tbl_faculty.l_name) as faculty_name'),
                'tbl_logs.full_name', 
                'tbl_logs.date_visited', 
                'tbl_logs.time_in', 
                'tbl_logs.time_out', 
                'tbl_logs.person_to_visit', 
                'tbl_logs.purpose', 
                'tbl_logs.action_taken', 
                'tbl_logs.is_accepted', 
                'tbl_logs.is_completed', 
                'tbl_logs.req_category')
                ->where('tbl_logs.person_to_visit', '=', Auth::id())
                ->where('tbl_logs.is_completed', '=', $is_completed)
                ->paginate($perPage);

        if ($logs->total() === 0 || $logs->currentPage() > $logs->lastPage()) {
            return response()->json([
                "message" => "No data available."
            ], 422);
        }

        return response()->json([
            'data' => $logs->items(),
            'pagination' => [
                'total' => $logs->total(),
                'per_page' => $logs->perPage(),
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
            ],
        ]);
    }
}
