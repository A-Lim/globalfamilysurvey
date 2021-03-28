<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Submission;
use App\Jobs\RequestSubmissions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Submission\PullSubmissionRequest;

use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SubmissionRepositoryInterface;
use App\Repositories\ChurchRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

class SubmissionsController extends Controller {
    private $submissionRepository;
    private $churchRepository;
    private $settingsRepository;
    private $requestLogRepository;
    private $surveyRepository;

    public function __construct(SubmissionRepositoryInterface $submissionRepositoryInterface,
        ChurchRepositoryInterface $churchRepositoryInterface,
        SettingsRepositoryInterface $settingsRepositoryInterface,
        SurveyRepositoryInterface $surveyRespositoryInterface) {
        $this->submissionRepository = $submissionRepositoryInterface;
        $this->churchRepository = $churchRepositoryInterface;
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->surveyRepository = $surveyRespositoryInterface;
    }

    public function test() {
        $data = '{
            "data": [
              {
                "id": "12509145357",
                "recipient_id": "",
                "collection_mode": "default",
                "response_status": "completed",
                "custom_value": "",
                "first_name": "",
                "last_name": "",
                "email_address": "",
                "ip_address": "",
                "logic_path": {},
                "metadata": {
                  "contact": {}
                },
                "page_path": [],
                "collector_id": "225801190",
                "survey_id": "166722093",
                "custom_variables": {
                  "ch": "63b0384f-92ad-4962-b228-b15c2944d6e4"
                },
                "edit_url": "https://www.surveymonkey.com/r/?sm=tM_2F_2BNJ_2FGV7xhMVxw5m8Oqw12Pv_2FCA3kOzulQBlMo3wtDZch_2BDItelD_2FcQsrYtlXp",
                "analyze_url": "https://www.surveymonkey.com/analyze/browse/qL56QOdbo_2B2gxt4Wnb0V7Bm4QcFg0BeOlFS7K0hWwZ0_3D?respondent_id=12509145357",
                "total_time": 150,
                "date_modified": "2021-03-21T04:58:26+00:00",
                "date_created": "2021-03-21T04:55:56+00:00",
                "href": "https://api.surveymonkey.net/v3/surveys/166722093/responses/12509145357",
                "pages": [
                  {
                    "id": "65782126",
                    "questions": []
                  },
                  {
                    "id": "59862203",
                    "questions": [
                      {
                        "id": "221566456",
                        "answers": [
                          {
                            "choice_id": "1520420106"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100636467",
                    "questions": [
                      {
                        "id": "221571893",
                        "answers": [
                          {
                            "choice_id": "1520452824"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "59871939",
                    "questions": [
                      {
                        "id": "221572685",
                        "answers": [
                          {
                            "choice_id": "1520458471"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "59870493",
                    "questions": []
                  },
                  {
                    "id": "100636493",
                    "questions": []
                  },
                  {
                    "id": "100636496",
                    "questions": []
                  },
                  {
                    "id": "100636918",
                    "questions": []
                  },
                  {
                    "id": "100636927",
                    "questions": []
                  },
                  {
                    "id": "100636931",
                    "questions": []
                  },
                  {
                    "id": "100636934",
                    "questions": []
                  },
                  {
                    "id": "100636939",
                    "questions": []
                  },
                  {
                    "id": "100637197",
                    "questions": []
                  },
                  {
                    "id": "100637199",
                    "questions": []
                  },
                  {
                    "id": "100637200",
                    "questions": []
                  },
                  {
                    "id": "100637203",
                    "questions": []
                  },
                  {
                    "id": "100637205",
                    "questions": []
                  },
                  {
                    "id": "100637292",
                    "questions": []
                  },
                  {
                    "id": "100637295",
                    "questions": [
                      {
                        "id": "221583770",
                        "answers": [
                          {
                            "choice_id": "1520528156",
                            "row_id": "1520528150"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100637297",
                    "questions": [
                      {
                        "id": "221606646",
                        "answers": [
                          {
                            "choice_id": "1520700129",
                            "row_id": "1520700125"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100637299",
                    "questions": [
                      {
                        "id": "221583878",
                        "answers": [
                          {
                            "choice_id": "1520529143",
                            "row_id": "1520529141"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100637701",
                    "questions": [
                      {
                        "id": "221584014",
                        "answers": [
                          {
                            "choice_id": "1520530290"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "60200773",
                    "questions": [
                      {
                        "id": "228517475",
                        "answers": [
                          {
                            "choice_id": "1565642788",
                            "row_id": "1565642784"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638022",
                    "questions": [
                      {
                        "id": "228517741",
                        "answers": [
                          {
                            "choice_id": "1565644058",
                            "row_id": "1565644053"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638040",
                    "questions": [
                      {
                        "id": "228517982",
                        "answers": [
                          {
                            "choice_id": "1565645527",
                            "row_id": "1565645524"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638045",
                    "questions": [
                      {
                        "id": "228518417",
                        "answers": [
                          {
                            "choice_id": "1565648497",
                            "row_id": "1565648493"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638046",
                    "questions": [
                      {
                        "id": "228518735",
                        "answers": [
                          {
                            "choice_id": "1565650173"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "61443323",
                    "questions": [
                      {
                        "id": "228519048",
                        "answers": [
                          {
                            "choice_id": "1565651878",
                            "row_id": "1565651875"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638079",
                    "questions": [
                      {
                        "id": "228519167",
                        "answers": [
                          {
                            "choice_id": "1565652635",
                            "row_id": "1565652631"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638084",
                    "questions": [
                      {
                        "id": "221583102",
                        "answers": [
                          {
                            "choice_id": "1520523977"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "61443384",
                    "questions": [
                      {
                        "id": "223038993",
                        "answers": [
                          {
                            "choice_id": "1530760613",
                            "row_id": "1530760606"
                          }
                        ]
                      }
                    ]
                  },
                  {
                    "id": "100638104",
                    "questions": [
                      {
                        "id": "223039532",
                        "answers": [
                          {
                            "choice_id": "1530763853",
                            "row_id": "1530763849"
                          }
                        ]
                      }
                    ]
                  }
                ]
              }
            ],
            "per_page": 100,
            "page": 1,
            "total": 1,
            "links": {
              "self": "https://api.surveymonkey.com/v3/surveys/166722093/responses/bulk?page=1&per_page=100"
            }
          }';

        $churches = $this->churchRepository->all();
        $this->submissionRepository->create_from_json(json_decode($data), $churches);

    }

    public function pull(PullSubmissionRequest $request) {
        $churches = $this->churchRepository->all();
        $token = $this->settingsRepository->get('token')->value;
        $surveys = $this->surveyRepository->all();

        $start_date = null;
        $end_date = null;

        switch ($request->type) {
            case Submission::REQ_TYPE_DATE:
                $dates = explode(' - ', $request->daterange);
                $start_date = Carbon::createFromFormat('d/m/Y', $dates[0])->toDateString();
                $end_date = Carbon::createFromFormat('d/m/Y', $dates[1])->toDateString();
                break;

            case Submission::REQ_TYPE_TODAY:
                $start_date = Carbon::today()->toDateString();
                $end_date = Carbon::tomorrow()->toDateString();
                break;
        }
        
        foreach ($surveys as $survey) {
            RequestSubmissions::dispatch($survey->id, Submission::STATUS_COMPLETED, $start_date, $end_date, $token, $churches);
        }

        session()->flash('success', 'Pull request for submission initiated. Please wait for a few minutes for submissions to be updated.');
        return back();
    }
}
