<?php

namespace App\Http\Controllers;

use App\Models\commentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class commentClassController extends Controller
{

    public function getComment(Request $request)
    {
        $listComment = [];
        $comments = commentClass::all()
            ->where("id_class", $request->id_class)
            ->where("id_status", $request->id_status);
        foreach ($comments as $cm) {
            $cm->nameOwner = User::find($cm->owner);
            array_push($listComment, $cm);
        }

        return response()->json($listComment);
    }
    public function comment(Request $request)
    {

        $comment = new commentClass;
        $comment->id_class = $request->id_class;
        $comment->id_status = $request->id_status;
        $comment->comment = $request->comment;
        $comment->owner = Auth::id();
        $comment->save();
        return response()->json($comment);
    }
    public function deleteComment(Request $request)
    {
        $comment = commentClass::find($request->id_comment);
        if ($comment != null) {
            $comment->delete();
        }
        return response()->json($comment);
    }
}