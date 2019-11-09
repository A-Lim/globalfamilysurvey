<?php
namespace App\Http\Controllers;

use App\User;
use DataTables;
use Illuminate\Http\Request;

use App\Events\UserRegistered;

use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ChurchRepositoryInterface;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\AuthRepositoryInterface;

class UsersController extends Controller {
    private $churchRepository;
    private $surveyRepository;
    private $userRepository;
    private $settingsRepository;
    private $authRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface,
        AuthRepositoryInterface $authRepositoryInterface,
        ChurchRepositoryInterface $churchRepositoryInterface,
        SurveyRepositoryInterface $surveyRepositoryInterface,
        SettingsRepositoryInterface $settingsRepositoryInterface) {
        $this->middleware('auth');
        $this->userRepository = $userRepositoryInterface;
        $this->churchRepository = $churchRepositoryInterface;
        $this->surveyRepository = $surveyRepositoryInterface;
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->authRepository = $authRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('view', User::class);
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', User::class);
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request) {
        $this->authorize('create', User::class);

        $password = str_random(10);
        $user = $this->authRepository->register_user($request, $password);

        event(new UserRegistered($user, $password));
        session()->flash('success', 'User successfully registered');
        return redirect('/users');
    }

    /**
     * User profile page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        return view('users.edit', [
            'user' => auth()->user(),
            'surveys' => $this->surveyRepository->all(),
            'churches' => $this->churchRepository->all(),
            'survey_base_url' => \App\Setting::where('key', 'survey_base_url')->firstOrFail()
        ]);
    }

    /**
     * Edit user page
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit', [
            'user' => $this->userRepository->find($user->id),
            'surveys' => $this->surveyRepository->all(),
            'churches' => $this->churchRepository->all(),
            'survey_base_url' => $this->settingsRepository->get('survey_base_url')
        ]);
    }

    /**
     * Update user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user) {
        $this->authorize('update', $user);
        $this->userRepository->update($user, $request);
        session()->flash('success', 'User successfully updated');

        // means user is editing his own profile
        if (auth()->id() == $user->id) {
            return redirect('/dashboard');
        } else {
            return redirect('/users');
        }
    }

    /**
     * Delete user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $this->authorize('delete', $user);
        $this->userRepository->delete($user);

        session()->flash('success', 'User successfully deleted');
        return back();
    }

    public function datatable() {
        return Datatables::of($this->userRepository->datatable_query())
            ->addIndexColumn()
            ->addColumn('action', function($user) {
                $html = '';
                if (auth()->user()->can('update', User::class)) {
                    $html .= edit_button('users', $user->id).' ';
                }
                if (auth()->user()->can('delete', User::class)) {
                    $html .= delete_button('users', $user->id);
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
