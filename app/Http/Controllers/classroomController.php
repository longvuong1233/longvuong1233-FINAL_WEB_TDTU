<?php

namespace App\Http\Controllers;

use App\Models\classDetails;
use App\Models\Classroom;
use App\Models\classStore;
use App\Models\commentClass;
use App\Models\peopleAndClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Haruncpi\LaravelIdGenerator\IdGenerator;

use function PHPUnit\Framework\isEmpty;

class classroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (trim(Auth::user()->role_user) == "admin") {
            $classroom =  Classroom::all();
            return response()->json($classroom);
        }
        $classroom =  Classroom::all()->where("id_owner", Auth::id());
        return response()->json($classroom);
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


        $id = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 7);





        $classroom = new Classroom;
        $classroom->id = $id;
        $classroom->nameclass = $request->nameClass;
        $classroom->part = $request->part;
        $classroom->title = $request->title;
        $classroom->room = $request->room;
        $classroom->id_owner = Auth::id();
        $classroom->save();
        //
        $peopleAndClass = new peopleAndClass;
        $peopleAndClass->id_class = $id;
        $peopleAndClass->id_people = Auth::id();
        $peopleAndClass->save();

        return redirect()->route('dashboard');
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
        $classroom = Classroom::find($id);
        if ($classroom == null) {
            return redirect()->route("dashboard");
        }
        $peopleAndClass = peopleAndClass::all()->where("id_people", Auth::id())->where("id_class", $id);
        if (count($peopleAndClass) == 0) {
            return redirect()->route("dashboard");
        }
        $classDetails = classDetails::all()->where("id_class", $id);
        foreach ($classDetails as $cd) {
            $cd->numComment = count(commentClass::all()->where("id_status", $cd->id));
        }



        return view('welcome', ["classroom" => $classroom, "classDetails" => $classDetails, "stream" => true]);
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

        $classroom = Classroom::findOrFail($id);
        $classroom->nameclass = $request->name_class;
        $classroom->part = $request->part;
        $classroom->title = $request->title;
        $classroom->room = $request->room;

        if ($request->hasFile("img")) {

            $file_extension = $request->file("img")->getClientOriginalExtension();

            if ($file_extension == "png" || $file_extension == "jpg" || $file_extension == "svg" || $file_extension == "jfif") {
                $filename = time() . '.' . $file_extension;
                $result = Storage::cloud()->put($filename, (string) file_get_contents($request->file("img")), 'public');
                if ($result == 1) {
                    $classroom->img = collect(Storage::cloud()->listContents("/", false))->where("name", "=", $filename)->first()['basename'];
                }
            }
        }

        $classroom->save();
        return redirect()->back();
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
        return redirect()->back();
    }
}