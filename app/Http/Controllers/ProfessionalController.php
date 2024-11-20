<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use Validator;
use Redirect;

class ProfessionalController extends Controller
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
        $professionals       = Professional::latest();

        if ($request->has('search')){
            $sort_search  = $request->search;
            $professionals = $professionals->where('name', 'like', '%'.$sort_search.'%');
        }
        $professionals = $professionals->paginate(10);
        //echo '<pre>'; print_r($professionals); exit;
        return view('admin.member_profile_attributes.professional.index', compact('professionals','sort_search'));
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

        $professionals              = new Professional;
        $professionals->name        = $request->name;
        $professionals->present     = 1;

        if($professionals->save()){
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
        $professional          = Professional::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.professional.edit', compact('professional'));
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

        $professional              = Professional::findOrFail($id);
        $professional->name        = $request->name;
        if($professional->save())
        {
            flash('Professional has been updated successfully')->success();
            return redirect()->route('professional.index');
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
        if (Professional::destroy($id)) {
            flash('Professional has been deleted successfully')->success();
            return redirect()->route('castes.index');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function updateStatus(Request $request)
    {
        $p = Professional::findOrFail($request->id);
        $p->present = $request->status;
        if($p->save()){
            return 1;
        }
        return 0;
    }
}
