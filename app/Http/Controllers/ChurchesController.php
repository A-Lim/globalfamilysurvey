<?php

namespace App\Http\Controllers;

use DataTables;
use App\Country;
use App\Church;
use App\Http\Requests\ChurchRequest;
use Illuminate\Http\Request;

class ChurchesController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', Church::class);
        return view('churches.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Church::class);
        $countries = Country::select('id', 'name')->get();
        return view('churches.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChurchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChurchRequest $request) {
        $this->authorize('create', Church::class);
        $request->save();
        session()->flash('success', 'Church successfully created');
        return redirect('churches');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Church  $church
     * @return \Illuminate\Http\Response
     */
    public function edit(Church $church) {
        $this->authorize('update', Church::class);
        $countries = Country::select('id', 'name')->get();
        return view('churches.edit', [
            'countries' => $countries,
            'church' => $church,
            'surveys' => \App\Survey::all(),
            'survey_base_url' => \App\Setting::where('key', 'survey_base_url')->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ChurchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ChurchRequest $request, Church $church) {
        $this->authorize('update', $church);
        $request->save();
        session()->flash('success', 'Church successfully updated');
        return redirect('/churches');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Church $church) {
        $this->authorize('delete', Church::class);
        $church->delete();
        session()->flash('success', 'Church successfully deleted');
        return back();
    }

    public function datatable() {
        $query = Church::join('countries', 'churches.country_id', '=', 'countries.id')
                    ->select('churches.*', 'countries.full_name as country_name');
        return Datatables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($user) {
            $html = '';
            if (auth()->user()->can('update', Church::class)) {
                $html .= edit_button('churches', $user->id).' ';
            }
            if (auth()->user()->can('delete', Church::class)) {
                $html .= delete_button('churches', $user->id);
            }
            return $html;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
