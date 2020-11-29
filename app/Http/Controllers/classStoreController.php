<?php

namespace App\Http\Controllers;

use App\Models\classStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class classStoreController extends Controller
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
        if ($request->hasFile('my_files')) {
            foreach ($request->file("my_files") as $file) {
                $classStore = new classStore;
                $file_extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $result = Storage::cloud()->put($filename, (string) file_get_contents($file), 'public');


                if ($result == 1) {
                    $classStore->name_file = $filename;
                    $classStore->id_status = $request->id_status;
                    $classStore->type = $file_extension;
                    $classStore->base_name = collect(Storage::cloud()->listContents("/", false))->where("name", "=", $filename)->first()['basename'];
                    $classStore->save();
                }
            };
        }
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

        $classStore = classStore::find($id);
        if ($classStore != null) {
            $classStore->delete();
        }
        return redirect()->back();
    }
}