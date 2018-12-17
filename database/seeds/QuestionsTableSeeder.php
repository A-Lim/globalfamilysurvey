<?php

use Illuminate\Database\Seeder;
use App\Survey;
use App\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->leader_seed_questions();
        $this->member_seed_questions();
    }

    public function leader_seed_questions() {
        $path = storage_path('app/public/json/leader.json');
        $contents = json_decode(file_get_contents($path));

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'leader');
            Question::saveFromJson($contents);
        });
    }

    public function member_seed_questions() {
        $path = storage_path('app/public/json/member.json');
        $contents = json_decode(file_get_contents($path));

        DB::transaction(function() use ($contents){
            Survey::saveFromJson($contents, 'member');
            Question::saveFromJson($contents);
        });
    }
}
