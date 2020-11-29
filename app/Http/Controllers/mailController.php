<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\notifyMail;
use App\Models\peopleAndClass;
use App\Models\User;
use App\Notifications\askingJoinClass;
use App\Notifications\inviteClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class mailController extends Controller
{
    //


    public function askingJoinClass(Request $request)
    {
        $classroom = Classroom::find($request->id_class);
        $recipient = User::find($classroom->id_owner);
        if ($recipient != null) {
            $peopleClass = peopleAndClass::all()->where("id_class", $request->id_class)->where("id_people", Auth::id());

            if (count($peopleClass) == 0) {

                $data = array(
                    "id_class" => $request->id_class,
                    "id_sender" => Auth::id(),
                    "id_recipient" => $recipient->id
                );

                $notifyMail = new notifyMail();

                $notifyMail->recipient = $recipient->id;
                $notifyMail->sender = Auth::id();
                $notifyMail->id_class = $request->id_class;
                $notifyMail->type = "asking";
                $notifyMail->save();

                $recipient->notify(new askingJoinClass($data));
            }
        }
        return redirect()->back();
    }


    public function inviteClass(Request $request)
    {
        $recipient = User::where("email", $request->email)->first();
        if ($recipient != null) {
            $peopleClass = peopleAndClass::all()->where("id_class", $request->id_class)->where("id_people", $request->recipient);
            if (count($peopleClass) == 0) {
                $data = array(
                    "id_class" => $request->id_class,
                    "id_sender" => Auth::id(),
                    "id_recipient" => $recipient->id
                );

                $notifyMail = new notifyMail();

                $notifyMail->recipient = $recipient->id;
                $notifyMail->sender = Auth::id();
                $notifyMail->id_class = $request->id_class;
                $notifyMail->type = "invite";
                $notifyMail->save();

                $recipient->notify(new inviteClass($data));
            }
        }



        return redirect()->back();
    }
}