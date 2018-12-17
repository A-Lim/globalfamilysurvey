<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    // $questions = \App\Question::with('survey')->get();
    // $submission = factory(\App\Submission::class)->create();


    // $question = $questions->slice(0, 1)->first();

    // switch ($question->id) {
    //     case 'NIpVvk6gUI4w':
    //         factory(\App\Submission::class)->create([
    //             // 'submission_id' => $submission->id,
    //             // 'question_id' => $question->id,
    //             'type'  => 'boolean',
    //             'value' => serialize([true]),
    //         ]);
    //         break;
    //
    //     case 'oqPFZsmIe9bZ':
    //         $choices = ['I\'m Male', 'I\'m Female'];
    //         return [
    //             // 'submission_id' => $submission->id,
    //             // 'question_id' => $question->id,
    //             'type'  => 'boolean',
    //             'value' => serialize([$faker->randomElement[$choices]]),
    //         ];
    //         break;
    //
    //     case 'Z7Qf3TBhFyzu':
    //         return [
    //             // 'submission_id' => $submission->id,
    //             // 'question_id' => $question->id,
    //             'type'  => 'number',
    //             'value' => serialize([rand(6,90)]),
    //         ];
    //         break;
    //
    //      case 'mh5iJ7YeCPGr':
    //         $choices = ['Single -never married', 'Single -widowed', 'Single -divorced', 'Married', 'Legally married, but separated'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$faker->randomElement[$choices]]),
    //          ];
    //          break;
    //
    //      case 'b7qSSwgttNPB':
    //         $choices = ['Yes', 'No'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$faker->randomElement[$choices]]),
    //          ];
    //          break;
    //
    //      case 'iXNVXrRRhjjH':
    //         $choices = ['I am actively seeking marriage and will probably get married in the future',
    //                     'I am actively seeking marriage, but the possibility of marriage is low',
    //                     'I am not actively seeking marriage, but am open to marriage',
    //                     'I am not actively seeking marriage and will probably remain single'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$faker->randomElement[$choices]]),
    //          ];
    //          break;
    //
    //      case 'mgU53hRD8kek':
    //         $choices = ['Pornography', 'Masturbation', 'Sexting', 'Oral sex', 'Sexual intercourse',
    //                     'Multiple sex partners', 'Homosexuality', 'Sex buddy', 'Prostitution',
    //                     'None of the above'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choices',
    //              'value' => serialize([$choices[rand(0,9)], $choices[rand(0,9)], $choices[rand(0,9)], $choices[rand(0,9)]]),
    //          ];
    //          break;
    //
    //      case 'QebvfRJpJNpQ':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'TrsNZ07QmwQb':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'yes_no',
    //              'value' => serialize([$faker->boolean]),
    //          ];
    //          break;
    //
    //
    //
    //      case 'pMV1TjOYSr71':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'CfE7yyEQfxHk':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'x9DXGM2kqOgW':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'grcS5F4vCXZM':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'yes_no',
    //              'value' => serialize([$faker->boolean]),
    //          ];
    //          break;
    //
    //      case 'Cy5ZmHqJLUcf':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'HmagkY9shb4A':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'f7jXXtJGra2Q':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'zEUDjesnhrtG':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'd0M0wUziuIvJ':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'yes_no',
    //              'value' => serialize([$faker->boolean]),
    //          ];
    //          break;
    //
    //      case 'OkWq9Kh6x8SJ':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!', 'My dad has passed away.'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,4)]]),
    //          ];
    //          break;
    //
    //      case 'lsxEB9b0Psz6':
    //         $choices = ['I don’t have a stepdad.', 'DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,4)]]),
    //          ];
    //          break;
    //
    //      case 'owI7AqSydQpK':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!', 'My mom has passed away.'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,4)]]),
    //          ];
    //          break;
    //
    //      case 'KqLHWxTiKXXx':
    //         $choices = ['I don’t have a stepmom.', 'DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,4)]]),
    //          ];
    //          break;
    //
    //      case 'IatoKUsfy9KU':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,3)]]),
    //          ];
    //          break;
    //
    //      case 'pdQdVDTLcd6p':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,3)]]),
    //          ];
    //          break;
    //
    //      case 'JO2oxdd9vPaa':
    //         $choices = ['Cigarettes', 'Alcoholic beverages', 'Drugs', 'Skipping school without authorisation', 'Gambling',
    //                     'Masturbation', 'Pornography', 'Sexting', 'None of the above',
    //                     'None of the above'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choices',
    //              'value' => serialize([$choices[rand(0,9)], $choices[rand(0,9)], $choices[rand(0,9)], $choices[rand(0,9)]]),
    //          ];
    //          break;
    //
    //      case 'f9gkhmF0cgAx':
    //         $choices = ['Holding hands (in a romantic way)', 'Kissing on the lips', 'French kissing', 'Heavy petting', 'Oral sex',
    //                     'Sexual intercourse', 'None of the above'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choices',
    //              'value' => serialize([$choices[rand(0,6)], $choices[rand(0,6)], $choices[rand(0,6)], $choices[rand(0,6)], $choices[rand(0,6)]]),
    //          ];
    //          break;
    //
    //      case 'XI91zKHIlUfo':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,3)]]),
    //          ];
    //          break;
    //
    //      case 'pj919CvbWdO6':
    //         $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'multiple_choice',
    //              'value' => serialize([$choices[rand(0,3)]]),
    //          ];
    //          break;
    //
    //      case 'RAvYm0P6KR49':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'WkPbw3GHSfLT':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'gooZc4FpYel9':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //      case 'zL2YXm2hLSxm':
    //          return [
    //              // 'submission_id' => $submission->id,
    //              // 'question_id' => $question->id,
    //              'type'  => 'opinion_scale',
    //              'value' => serialize([rand(1,6)]),
    //          ];
    //          break;
    //
    //     default:
    //         return [
    //             // 'submission_id' => $submission->id,
    //             // 'question_id' => $question->id,
    //             'type'  => 'opinion_scale',
    //             'value' => serialize([rand(1,10)]),
    //         ];
    //         break;
    //
    // }

    // foreach ($questions as $question) {
    //     if ($question->survey->type == 'leader') {
    //         return [
    //             // 'submission_id' => $submission->id,
    //             // 'question_id' => $question->id,
    //             'type'  => 'opinion_scale',
    //             'value' => serialize([rand(1,10)]),
    //         ];
    //     } else {
    //
    //     }
    // }



    return [
        //
    ];
});
