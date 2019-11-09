<?php
namespace App\Http\Controllers;

use DataTables;
use App\Church;
use Illuminate\Http\Request;
use App\Http\Requests\Church\CreateRequest;
use App\Http\Requests\Church\UpdateRequest;

use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\ChurchRepositoryInterface;

class ChurchesController extends Controller {
    private $churchRepository;
    private $countryRepository;
    private $surveyRepository;
    private $settingsRepository;

    public function __construct(ChurchRepositoryInterface $churchRepositoryInterface,
        CountryRepositoryInterface $countryRepositoryInterface,
        SurveyRepositoryInterface $surveyRepositoryInterface,
        SettingsRepositoryInterface $settingRepositoryInterface) {
        $this->middleware('auth');
        $this->churchRepository = $churchRepositoryInterface;
        $this->countryRepository = $countryRepositoryInterface;
        $this->surveyRepository = $surveyRepositoryInterface;
        $this->settingsRepository = $settingRepositoryInterface;
    }

    public function index() {
        $this->authorize('view', Church::class);
        return view('churches.index');
    }

    public function create() {
        $this->authorize('create', Church::class);
        $countries = $this->countryRepository->all_options();
        return view('churches.create', compact('countries'));
    }

    public function store(CreateRequest $request) {
        $this->authorize('create', Church::class);
        $this->churchRepository->create($request);
        session()->flash('success', 'Church successfully created');
        return redirect('churches');
    }

    public function edit(Church $church) {
        $this->authorize('update', Church::class);
        return view('churches.edit', [
            'countries' => $this->countryRepository->all_options(),
            'church' => $church,
            'surveys' => $this->surveyRepository->all(),
            'survey_base_url' => $this->settingsRepository->get('survey_base_url')
        ]);
    }

    public function update(UpdateRequest $request, Church $church) {
        $this->authorize('update', $church);
        $this->churchRepository->update($church, $request);
        session()->flash('success', 'Church successfully updated');
        return redirect('/churches');
    }

    public function destroy(Church $church) {
        $this->authorize('delete', Church::class);
        $this->churchRepository->delete($church);
        session()->flash('success', 'Church successfully deleted');
        return back();
    }

    public function datatable() {
        return Datatables::of($this->churchRepository->datatable_query())
            ->addIndexColumn()
            ->addColumn('action', function($church) {
                $html = '';
                if (auth()->user()->can('update', Church::class)) {
                    $html .= edit_button('churches', $church->id).' ';
                }
                if (auth()->user()->can('delete', Church::class)) {
                    $html .= delete_button('churches', $church->id);
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
