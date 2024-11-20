<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Educational;
use Validator;
use Redirect;

class EducationalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_educational'])->only('index');
        $this->middleware(['permission:edit_educational'])->only('edit');
        $this->middleware(['permission:delete_educational'])->only('destroy');

        $this->rules = [
            'name'  => [ 'required','max:200'],
        ];

        $this->messages = [
            'name.required'  => translate('Name is required'),
            'name.max'       => translate('Max 200 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search  = null;
        $educationals       = Educational::latest();

        if ($request->has('search')){
            $sort_search  = $request->search;
            $educationals = $educationals->where('name', 'like', '%'.$sort_search.'%');
        }
        $educationals = $educationals->paginate(10);
        //echo '<pre>'; print_r($educationals); exit;
        return view('admin.member_profile_attributes.educational.index', compact('educationals','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create(Request $request)
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
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back();
        }

        $educationals              = new Educational;
        $educationals->name        = $request->name;
        $educationals->present     = 1;

        if($educationals->save()){
            flash(translate('Education Info has been added successfully'))->success();
            return back();
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
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
        $educational          = Educational::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.educational.edit', compact('educational'));
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
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $educational              = Educational::findOrFail($id);
        $educational->name        = $request->name;
        if($educational->save())
        {
            flash('Educational has been updated successfully')->success();
            return redirect()->route('educational.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Educational::destroy($id)) {
            flash('Educational has been deleted successfully')->success();
            return redirect()->route('castes.index');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
}
