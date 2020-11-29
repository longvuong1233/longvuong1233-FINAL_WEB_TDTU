<?php

namespace App\Http\Controllers;

use App\Models\classDetails;
use App\Models\peopleAssignment;
use App\Models\peopleStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class assignmentClassRoomController extends Controller
{
    //




    public function submitAgain($id_status)
    {

        $peopleAssignment = peopleAssignment::all()->where("id_people", Auth::id())->where("id_status", $id_status)->first();
        $peopleStore = peopleStore::all()->where("id_people_assignment", $peopleAssignment->id);
        if (count($peopleStore) != 0) {

            foreach ($peopleStore as $ps) {
                $ps->delete();
            }
        }
        $peopleAssignment->delete();

        return redirect()->back();
    }

    public function submitAssignment(Request $request)
    {

        $status = classDetails::find($request->id_status);
        if ($status != null) {
            if ($status->state == "assignment") {
                $people_assignment = new peopleAssignment;
                $people_assignment->id_status = $request->id_status;
                $people_assignment->id_people = Auth::id();
                $deadline = date('Y-m-d h:i:s', strtotime($status->deadline));
                $currentTime = date('Y-m-d h:i:s');
                if ($deadline < $currentTime) {
                    $people_assignment->state = "late";
                } else {
                    $people_assignment->state = "ontime";
                }
                $people_assignment->save();

                if ($request->hasFile('my_files')) {

                    foreach ($request->file("my_files") as $file) {
                        $peopleStore = new peopleStore;
                        $file_extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $file_extension;
                        $result = Storage::cloud()->put($filename, (string) file_get_contents($file), 'public');


                        if ($result == 1) {
                            $peopleStore->name_file = $filename;
                            $peopleStore->id_people_assignment = $people_assignment->id;
                            $peopleStore->type = $file_extension;
                            $peopleStore->base_name = collect(Storage::cloud()->listContents("/", false))->where("name", "=", $filename)->first()['basename'];
                            $peopleStore->save();
                        }
                    };
                }
            }
        }
        return redirect()->back();
    }
}