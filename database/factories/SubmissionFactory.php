<?php

use Faker\Generator as Faker;

$factory->define(App\Submission::class, function (Faker $faker) {
    $surveys = ['TNg8WK', 'wOCspU'];
    $church = factory(Church::class)->create();
    return [
        'survey_id' => $faker->numberBetween(0, 1),
        'church_id' => $church->id
    ];
});

$factory->afterCreating(App\Submission::class, function ($submission, $faker) {
    $questions = \App\Question::with(['survey' => function ($query) {
        $query->where('type', 'member');
    }])->get();
    foreach ($questions as $question) {
        switch ($question->id) {
            case 'NIpVvk6gUI4w':
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'boolean',
                    'value' => serialize([true])
                ]);
                break;

            case 'oqPFZsmIe9bZ':
                $choices = ['I\'m Male', 'I\'m Female'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'boolean',
                    'value' => serialize([$faker->randomElement($choices)])
                ]);
                break;

            case 'Z7Qf3TBhFyzu':
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'number',
                    'value' => serialize([$faker->numberBetween(6, 90)])
                ]);
                break;

             case 'mh5iJ7YeCPGr':
                $choices = ['Single -never married', 'Single -widowed', 'Single -divorced', 'Married', 'Legally married, but separated'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$faker->randomElement($choices)]),
                ]);
                 break;

             case 'b7qSSwgttNPB':
                $choices = ['Yes', 'No'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$faker->randomElement($choices)]),
                ]);
                 break;

             case 'iXNVXrRRhjjH':
                $choices = ['I am actively seeking marriage and will probably get married in the future',
                            'I am actively seeking marriage, but the possibility of marriage is low',
                            'I am not actively seeking marriage, but am open to marriage',
                            'I am not actively seeking marriage and will probably remain single'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$faker->randomElement($choices)]),
                ]);
                 break;

             case 'mgU53hRD8kek':
                $choices = ['Pornography', 'Masturbation', 'Sexting', 'Oral sex', 'Sexual intercourse',
                            'Multiple sex partners', 'Homosexuality', 'Sex buddy', 'Prostitution',
                            'None of the above'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choices',
                    'value' => serialize([$choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)]]),
                ]);
                 break;

             case 'QebvfRJpJNpQ':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'TrsNZ07QmwQb':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'yes_no',
                     'value' => serialize([$faker->boolean]),
                 ]);
                 break;

             case 'pMV1TjOYSr71':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'CfE7yyEQfxHk':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'x9DXGM2kqOgW':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'grcS5F4vCXZM':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'yes_no',
                     'value' => serialize([$faker->boolean]),
                 ]);
                 break;

             case 'Cy5ZmHqJLUcf':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'HmagkY9shb4A':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'f7jXXtJGra2Q':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'zEUDjesnhrtG':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'd0M0wUziuIvJ':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'yes_no',
                     'value' => serialize([$faker->boolean]),
                 ]);
                 break;

             case 'OkWq9Kh6x8SJ':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!', 'My dad has passed away.'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 4)]]),
                ]);
                 break;

             case 'lsxEB9b0Psz6':
                $choices = ['I don’t have a stepdad.', 'DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 4)]]),
                ]);
                 break;

             case 'owI7AqSydQpK':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!', 'My mom has passed away.'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 4)]]),
                ]);
                 break;

             case 'KqLHWxTiKXXx':
                $choices = ['I don’t have a stepmom.', 'DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 4)]]),
                ]);
                 break;

             case 'IatoKUsfy9KU':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 3)]]),
                ]);
                 break;

             case 'pdQdVDTLcd6p':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 3)]]),
                ]);
                 break;

             case 'JO2oxdd9vPaa':
                $choices = ['Cigarettes', 'Alcoholic beverages', 'Drugs', 'Skipping school without authorisation', 'Gambling',
                            'Masturbation', 'Pornography', 'Sexting', 'None of the above',
                            'None of the above'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choices',
                    'value' => serialize([$choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)], $choices[$faker->numberBetween(0, 9)]]),
                ]);
                 break;

             case 'f9gkhmF0cgAx':
                $choices = ['Holding hands (in a romantic way)', 'Kissing on the lips', 'French kissing', 'Heavy petting', 'Oral sex',
                            'Sexual intercourse', 'None of the above'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choices',
                    'value' => serialize([$choices[$faker->numberBetween(0, 6)], $choices[$faker->numberBetween(0, 6)], $choices[$faker->numberBetween(0, 6)], $choices[$faker->numberBetween(0, 6)], $choices[$faker->numberBetween(0, 6)]]),
                ]);
                 break;

             case 'XI91zKHIlUfo':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 3)]]),
                ]);
                 break;

             case 'pj919CvbWdO6':
                $choices = ['DEFINITELY YES!!', 'Yes', 'No', 'DEFINITELY NOT!!'];
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'multiple_choice',
                    'value' => serialize([$choices[$faker->numberBetween(0, 3)]]),
                ]);
                 break;

             case 'RAvYm0P6KR49':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'WkPbw3GHSfLT':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'gooZc4FpYel9':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

             case 'zL2YXm2hLSxm':
                 factory(App\Answer::class)->create([
                     'question_id' => $question->id,
                     'submission_id' => $submission->id,
                     'type'  => 'opinion_scale',
                     'value' => serialize([$faker->numberBetween(1, 6)]),
                 ]);
                 break;

            default:
                factory(App\Answer::class)->create([
                    'question_id' => $question->id,
                    'submission_id' => $submission->id,
                    'type'  => 'opinion_scale',
                    'value' => serialize([$faker->numberBetween(1, 10)]),
                ]);
                break;

        }
    }
});
