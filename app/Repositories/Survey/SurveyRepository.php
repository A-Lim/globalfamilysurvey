<?php
namespace App\Repositories;

use App\Survey;

use Illuminate\Http\Request;

class SurveyRepository implements SurveyRepositoryInterface
{
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
    public function saveFromJson($data, $json) {
        $survey = Survey::find($json->id);
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
        \Cache::forget(Survey::CACHE_KEY);
    }
}
