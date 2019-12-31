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

class DashboardController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $permission_role = DB::table('permission_role')->get();
        $reports = Report::all();

        $data = [
            'submissions_count' => Submission::count(),
            'churches_count' => Church::count(),
            'countries_count' => Church::groupBy('country_id')->count(),
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
