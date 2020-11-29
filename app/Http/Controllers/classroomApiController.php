<?php

namespace App\Http\Controllers;

use App\Models\classDetails;
use App\Models\Classroom;
use App\Models\commentClass;
use App\Models\peopleAndClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class classroomApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $classroom = Classroom::find($id);
        $classroom->nameclass = $request->nameclass;
        $classroom->part = $request->part;
        $classroom->title = $request->title;
        $classroom->room = $request->room;


        $classroom->save();



        if (Auth::user()->role_user == "admin") {
            $classroom =  Classroom::all();
            return response()->json($classroom);
        }
        $classroom =  Classroom::all()->where("owner", Auth::id());
        return response()->json($classroom);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //


        $classroom = Classroom::find($id);
        if ($classroom != null) {
            peopleAndClass::where("id_class", $id)->delete();
            commentClass::where("id_class", $id)->delete();
            classDetails::where("id_class", $id)->delete();
            $classroom->delete();
        }

        if (Auth::user()->role_user == "admin") {
            $classroom =  Classroom::all();
            return response()->json($classroom);
        }
        $classroom =  Classroom::all()->where("owner", Auth::id());
        return response()->json($classroom);
    }
}