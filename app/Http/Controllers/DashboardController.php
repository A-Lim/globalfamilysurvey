<?php
namespace App\Http\Controllers;

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
        $permission_role = \DB::table('permission_role')->get();
        // query related questions, answers that are linked to the report
        $reports = Report::with(['leader_question.answers' => function ($query) {
            // query to filter answers based on user's level
            $query->permitted();
        }, 'member_question.answers' => function ($query) {
            // query to filter answers based on user's level
            $query->permitted();
        }])->get();


        $data = [
            'submissions_count' => Submission::count(),
            'churches_count' => Church::count(),
            'countries_count' => Church::distinct('country')->count('country'),
        ];
        return view('dashboard.index', compact('data', 'permission_role', 'reports'));
    }

    public function members_report() {
        $permission_role = \DB::table('permission_role')->get();

        // get all categories together with questions
        $categories = Category::with(['questions' => function ($query) {
            // where questions has survey of type member
            $query->whereHas('survey', function ($query) {
                $query->where('type', 'member');
            // retrieve questions together with answers
            })->with(['answers' => function ($query) {
                // where answers are filtered according to user level
                // see answer model for more info
                $query->permitted();
            }])->orderBy('sequence');
        }])->get();
        return view('dashboard.members-report', compact('permission_role', 'categories'));
    }
}
