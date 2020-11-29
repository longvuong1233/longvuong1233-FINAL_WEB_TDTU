<?php

namespace App\Http\Controllers;

use App\Models\classDetails;
use App\Models\Classroom;
use App\Models\classStore;
use App\Models\commentClass;
use App\Models\peopleAndClass;
use App\Models\peopleAssignment;
use App\Models\peopleStore;
use App\Models\User;
use App\Notifications\notifycommon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class classDetailsController extends Controller
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



        $classDetails = new classDetails();
        $classDetails->content = $request->content;
        $classDetails->id_class = $request->id_class;
        if (isset($request->assignment)) {
            if ($request->assignment == "yes") {
                $classDetails->description = $request->description;
                $classDetails->state = "assignment";
                $classDetails->deadline = $request->deadline;
            }
        } else {
            if ($request->hasFile("my_files")) {
                $classDetails->state = "item";
            }
        }
        $classDetails->owner = Auth::id();
        $classDetails->save();
        //
        if ($request->hasFile('my_files')) {
            foreach ($request->file("my_files") as $file) {
                $classStore = new classStore;
                $file_extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $result = Storage::cloud()->put($filename, (string) file_get_contents($file), 'public');


                if ($result == 1) {
                    $classStore->name_file = $filename;
                    $classStore->id_status = $classDetails->id;
                    $classStore->type = $file_extension;
                    $classStore->base_name = collect(Storage::cloud()->listContents("/", false))->where("name", "=", $filename)->first()['basename'];
                    $classStore->save();
                }
            };
        }

        $peopleAndClass = peopleAndClass::all()->where("id_class", $request->id_class)->pluck("id_people");

        $users = User::find($peopleAndClass);
        $data = array(
            "id_class" => $request->id_class,
            "owner" => Auth::id()
        );

        \Notification::send($users, new notifycommon($data));

        return redirect()->back();
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
        $status = classDetails::find($id);
        $classroom = Classroom::find($status->id_class);
        $listComment = commentClass::all()->where("id_status", $id)->where("id_class", $status->id_class);
        $listStore = classStore::all()->where("id_status", $id);
        $countPeopleClass = peopleAndClass::all()->where("id_class", $status->id_class)->count();
        $countSubmitLate = count(peopleAssignment::all()->where("id_status", $id)->where("state", "late"));
        $countSubmitOntime = count(peopleAssignment::all()->where("id_status", $id)->where("state", "ontime"));
        $isSubmitAssignment = count(peopleAssignment::all()->where("id_people", Auth::id())->where("id_status", $id)) == 0 ? false : true;
        $inforSubmit = peopleAssignment::where("id_people", Auth::id())->where("id_status", $id)->first();

        $peopleAssignment = peopleAssignment::all()->where("id_status", $id);
        $data = [];
        foreach ($peopleAssignment as $ps) {
            $ele = new infor();
            $ele->username = (User::find($ps->id_people))->name;
            $ele->submitAt = $ps->created_at;
            $ele->state = $ps->state;
            $store = peopleStore::all()->where("id_people_assignment", $ps->id)->pluck("base_name");
            foreach ($store as $file) {
                array_push($ele->files, $file);
            }
            array_push($data, $ele);
        }





        return view('welcome', [
            'classroom' => $classroom,
            'status' => $status, 'listComment' => $listComment,
            'listStore' => $listStore, 'showStatus' => true,
            'countPeopleClass' => $countPeopleClass,
            "countSubmitLate" => $countSubmitLate,
            "countSubmitOntime" => $countSubmitOntime,
            "isSubmitAssignment" => $isSubmitAssignment,
            "inforSubmit" => $inforSubmit,
            "listSubmit" => $data
        ]);
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

        $classDetails = classDetails::find($id);
        if (Auth::id() == $classDetails->owner) {
            $classDetails->delete();
        }
        return redirect()->back();
    }
}
class infor
{
    public $username;
    public $submitAt;
    public $state;
    public $files = [];
}