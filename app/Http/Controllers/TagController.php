<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag, App\FileTag, Session, App\Models\File;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $file = File::find($request->file_id);
      if(!$file)
      {
          return [];
      }

      return $file->tags();

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

        $request->tag = explode(',', $request->tag);
        if(count($request->tag ) == 0)
        {
          $msg = ["type"=>"alert-danger","icon"=>"fa-ban","data"=>["The tags field is required."]];
          Session::flash("message",$msg);
          return back();
        }
        $tags  =  Tag::findTag($request);
        foreach($request->tag as $tag)
        {
          $filetag = FileTag::firstOrNew(array('file_id'=>$request->file_id, 'tag_id'=>$tags[$tag]));
          $filetag->file_id = $request->file_id;
          $filetag->tag_id = $tags[$tag];
          $filetag->save();
        }

        $msg = ["type"=>"alert-success","icon"=>"fa-check","data"=>["Tags added successfully!"]];
        Session::flash("message",$msg);
        return back();
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
    }
}