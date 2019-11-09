<?php
namespace App\Repositories;

use DB;
use App\Survey;

use Illuminate\Http\Request;

class SurveyRepository implements SurveyRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all_count() {
        return \Cache::rememberForEver(Survey::CACHE_KEY.':count', function() {
            return Survey::count();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Survey::CACHE_KEY, function() {
            return Survey::withCount('questions')->get();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Survey::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        $this->clear_cache();
        return Survey::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Survey $survey, $data) {
        $this->clear_cache();
        $survey->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Survey $survey, $linked) {
        DB::beginTransaction();
        $ids = DB::table('questions')->where(['survey_id' => $survey->id])->pluck('id')->toArray();
        DB::table('surveys')->where(['id' => $survey->id])->delete();
        if ($linked) {
            DB::table('questions')->where('survey_id', $survey->id)->delete();
            DB::table('answers')->whereIn('question_id', $ids)->delete();
            DB::table('options')->whereIn('question_id', $ids)->delete();
            DB::table('submissions')->where('survey_id', $survey->id)->delete();
        }
        DB::commit();
        $this->clear_cache();
    }

    /**
     * {@inheritdoc}
     */
    public function saveFromJson($data, $json) {
        $survey = Survey::find($json->id);
        $data['title'] = $json->title;
        $data['preview_url'] = $json->preview;
        $data['language'] = $json->language;
        $data['analyze_url'] = $json->analyze_url;

        if (!$survey) {
            $data['id'] = $json->id;
            $this->create($data);
        } else {
            $this->update($survey, $data);
        };
    }

    private function clear_cache() {
        \Cache::forget(Survey::CACHE_KEY.':question_count_paginated');
        \Cache::forget(Survey::CACHE_KEY.':count');
        \Cache::forget(Survey::CACHE_KEY);
    }
}
