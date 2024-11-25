<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'f_name' => 'required|string|max:100',
            'm_name' => 'nullable|string|max:100',
            'l_name' => 'required|string|max:100',
            'sex' => 'required|integer|max:1',
        ]);

        $profile_checker = Faculty::find(Auth::id());

        if($profile_checker){
            return response()->json([
                "message" => "Profile has already updated.",
            ], 422);
        }

        $faculty = Faculty::create([
            'f_name' => $data['f_name'],
            'm_name' => $data['m_name'],
            'l_name' => $data['l_name'],
            'sex' => $data['sex'],
            'user_id' => Auth::id(),
        ]);

        if($faculty){
            return response()->json([
                "message" => "Profile successfully updated.",
            ], 201);
        }else{
            return response()->json([
                "message" => "To update your profile, you must login first.",
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id)
    {
        $data = $request->validate([

        ]);
    }

    public function availability(Request $request){
        
        $profile_checker = Faculty::find(Auth::id());

        if($profile_checker){

            $request->validate([
                'availability' => 'integer|required|min:1|max:3',
                'user_id' => Auth::id()
            ]);

            $profile_checker->update($request->all());
            return response()->json([
                "message" => "Status successfully updated.",
                "data" => $request->all()
            ], 201);

        }else{
            return response()->json([
                "message" => "Please update your profile first.",
            ], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
