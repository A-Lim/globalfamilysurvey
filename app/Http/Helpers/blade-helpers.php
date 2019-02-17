<?php
function edit_button($module, $id) {
    return
    '<a class="link-btn" href="/'.$module.'/'.$id.'/edit" title="Edit">
        <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </button>
    </a>';
}

function view_button($module, $id) {
    return
    '<a class="link-btn" href="/'.$module.'/'.$id.'" title="View">
        <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
        </button>
    </a>';
}

function delete_button($module, $id) {
    return
    '<form id="delete-btn-'.$id.'" action="/'.$module.'/'.$id.'" method="post" class="form-btn">'.
        csrf_field().
        '<input type="hidden" name="_method" value="delete" />
        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this '.str_singular($module).'?\')">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </button>
    </form>';
}


function get_color_palettes($version) {
    switch ($version) {
        case 1:
            return ["#3e95cd", "#8e5ea2","#3cba9f","#f50057","#c45850", "#e8c3b9", "#ffeb3b", "#ff9800", "#607d8b", "#808080"];
            break;

        case 2:
            return ["#808080", "#c45850", "#ff9800", "#3e95cd", "#004d40", "#8e5ea2","#3cba9f","#e8c3b9", "#f50057", "#ffeb3b"];

        default:
            break;
    }
}

function tag_type_for_permisson($permission_name) {
    switch ($permission_name) {
        case str_contains($permission_name, 'view'):
            return "info";
            break;

        case str_contains($permission_name, 'retrieve'):
        case str_contains($permission_name, 'create'):
            return "primary";
            break;

        case str_contains($permission_name, 'update'):
            return "warning";
            break;

        case str_contains($permission_name, 'delete'):
            return "danger";
            break;

        default:
            break;
    }
}



// function row_template($name, $count, $total) {
//     $percentage = round($count / $total * 100, 2);
//     return '<tr>
//         <td>'.$name.'</td>
//         <td style="width: 70%;">
//             <div class="progress progress-xs">
//                 <div class="progress-bar" style="width: '.$percentage.'%; background-color:'.get_color_palettes(2)[$index].'"></div>
//             </div>
//         </td>
//         <td style="width: 30%;"><span class="badge" style="background-color:{{ get_color_palettes(2)[$index] }}">{{ round($percentage, 2) }}%</span></td>
//     </tr>';
// }

// function get_answers_count($array, $match) {
//     $count = 0;
//     foreach ($array as $value) {
//         if (count(array_intersect(array_map('strtolower', $match), array_map('strtolower', $value))) > 0) {
//             $count++;
//         }
//     }
//     return $count;
// }

// function chart_data($question) {
    // dd($question);
    // // flatten data into one level
    // $answers = array_flatten($values);
    // sort($answers);
    //
    // $data = array();
    // // values which are grouped according to their occurence
    // // eg array('holding hands' => 2, 'kissing' => 5)
    // $counts = array();
    // // number of submissions
    // $total = count($values);
    //
    // // raw counts
    // if (check_array_for_boolean($answers)) {
    //     $counts = count_boolean($answers);
    // } else {
    //     $counts = array_count_values($answers);
    // }
    //
    // $data['labels'] = json_encode(array_map('ucwords', array_keys($counts)));
    // $data['values'] = json_encode(array_values($counts));
    //
    // // percentages
    // $data['percentage'] = get_percentage_data($counts, $total);
    // return $data;
// }

// function get_chart_type($question) {
//     $pie = ['oqPFZsmIe9bZ', 'b7qSSwgttNPB', 'grcS5F4vCXZM', 'd0M0wUziuIvJ', 'TrsNZ07QmwQb'];
//
//     if (in_array($question->id, $pie)) {
//         return 'pie';
//     } else {
//         return 'bar';
//     }
// }

// function check_array_for_boolean($array) {
//     foreach ($array as $value) {
//         if (is_bool($value)) { return true; }
//     }
//     return false;
// }
//
// function count_boolean($array) {
//     return array(
//         'yes' => count(array_filter($array)),
//         'no' => count($array) - count(array_filter($array))
//     );
// }

// function get_percentage_data($counts, $total) {
//     $percentage = array();
//
//     foreach ($counts as $key => $count) {
//         $percentage[$key] = array();
//         $percentage[$key] = ($count / $total) * 100;
//     }
//     ksort($percentage);
//     return $percentage;
// }

// function get_ages_categories($answers) {
//     // get all the value in answers and put them into an array
//     $ages = $answers->pluck('value');
//
//     $data['5-17'] = count($ages->filter(function ($value, $key) {
//         // if $value which is an array is not empty,
//         // check if the first value in the array >= 5 or <= 17)
//         return !empty($value) ? ($value[0] >= 5 &&  $value[0] <= 17) : null;
//     }));
//
//     $data['18-34'] = count($ages->filter(function ($value, $key) {
//         return !empty($value) ? ($value[0] >= 18 &&  $value[0] <= 34) : null;
//     }));
//
//     $data['35-50'] = count($ages->filter(function ($value, $key) {
//         return !empty($value) ? ($value[0] >= 35 &&  $value[0] <= 50) : null;
//     }));
//
//     $data['51 and above'] = count($ages->filter(function ($value, $key) {
//         return !empty($value) ? $value[0] > 50 : null;
//     }));
//
//     return $data;
// }

// function get_report_body($question) {
//     $table = ['Z7Qf3TBhFyzu', 'mh5iJ7YeCPGr', 'iXNVXrRRhjjH', 'mgU53hRD8kek','OkWq9Kh6x8SJ',
//             'lsxEB9b0Psz6','owI7AqSydQpK', 'KqLHWxTiKXXx','IatoKUsfy9KU', 'pdQdVDTLcd6p',
//             'JO2oxdd9vPaa', 'f9gkhmF0cgAx', 'XI91zKHIlUfo', 'pj919CvbWdO6'];
//
//     if ($question->id == 'Z7Qf3TBhFyzu') {
//         $age_ranges = get_ages_categories($question->answers);
//         return html_age_table($age_ranges);
//
//     } else if (in_array($question->id, $table)) {
//         $values = $question->answers->pluck('value')->toArray();
//         $data = chart_data($values);
//         return html_percentage_table($data);
//
//     } else {
//         return '<canvas id="'.$question->id.'"></canvas>';
//     }
// }

// function html_age_table($data) {
//     $tbody = "";
//     $i = 0;
//     foreach($data as $key => $value) {
//         $tbody .= '<tr>
//             <td>'.$key.'</td>
//             <td><span class="badge" style="background-color:'.get_color_palettes(1)[$i].'">'.$value.'</span></td>
//         </tr>';
//         $i++;
//     }
//
//     return '
//     <table class="table table-bordered">
//         <thead><tr><td><strong>Age Range</strong></td><td><strong>Count</strong></td></tr></thead>
//         <tbody>'.$tbody.'</tbody>
//     </table>
//     ';
// }

// function html_percentage_table($data) {
//     $labels = json_decode($data['labels']);
//     $values = json_decode($data['values']);
//
//     $tbody = "";
//     $i = 0;
//     foreach ($values as $key => $value) {
//         $tbody .= '<tr>
//             <td>'.$labels[$i].'</td>
//             <td><span class="badge" style="background-color:'.get_color_palettes(1)[$i].'">'.$value.'</span></td>
//         </tr>';
//         $i++;
//     }
//
//     return '
//     <table class="table table-bordered">
//         <thead><tr><td><strong>Label</strong></td><td><strong>Count</strong></td></tr></thead>
//         <tbody>'.$tbody.'</tbody>
//     </table>
//     ';
// }
