<?php
namespace App\Http\Controllers;

use DB;
use App\Submission;
use App\Church;
use App\Report;
use App\Answer;
use App\Question;
use App\Category;
use Illuminate\Http\Request;

use App\Repositories\ChurchRepositoryInterface;

class DashboardController extends Controller {

    private $churchRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ChurchRepositoryInterface $churchRepositoryInterface) {
        $this->middleware('auth');
        $this->churchRepository = $churchRepositoryInterface;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $permission_role = DB::table('permission_role')->get();
        $reports = Report::with('leader_question', 'member_question')->get();
        
        $data = [
            'submissions_count' => Submission::count(),
            'churches_count' => Church::count(),
            // count the number of unique countries
            'countries_count' => Church::select('country_id', DB::raw('count(country_id)'))
                ->groupBy('country_id')
                ->get()->count()
        ];
        return view('dashboard.index', compact('data', 'permission_role', 'reports'));
    }

    public function members_report() {
        $categories = Category::with('questions')->get();
        $permission_role = \DB::table('permission_role')->get();
        $question_ids = Question::whereHas('categories', function($query) use ($categories) {
            $query->whereIn('category_id', $categories->pluck('id')->toArray());
        })->get()->pluck('id');

        return view('dashboard.members-report', compact('permission_role', 'categories', 'question_ids'));
    }
}
