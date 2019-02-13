<?php

namespace App\Http\Requests\Webhooks;

use App\Webhook;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize() {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules() {
        return [
            'name' => 'required|string',
            'survey_id' => 'required|exists:surveys,id',
            'event_type' => 'required|in:'.implode(',', Webhook::EVENTS),
            'object_type' => 'required|in:'.implode(',', Webhook::TYPES),
        ];
    }

    public function messages() {
        return [

        ];
    }

    public function update_webhook($token) {
        $webhook = $this->webhook;
        $client = new Client();
        try {
            $response = $client->patch(Webhook::URL_WEBHOOK.'/'.$webhook->id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ],
                'json' => [
                    'name' => request('name'),
                    'event_type' => request('event_type'),
                    'object_type' => request('object_type'),
                    'object_ids' => [request('survey_id')],
                    'subscription_url' => url('api/surveys/'.request('survey_id').'/subscription'),
                    // 'subscription_url' => 'http://dev.globalfamilychallenge.com/api/surveys/'.request('survey_id').'/subscription',
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $json = json_decode($contents);

            // if there is no error
            if (!isset($json->error)) {
                $webhook->update([
                    'name' => request('name'),
                    'event_type' => request('event_type'),
                    'survey_id' => request('survey_id'),
                    'object_type' => request('object_type'),
                    'subscription_url' => url('api/surveys/'.request('survey_id').'/subscription'),
                ]);
            }

            return ['status' => true, 'content' => $json];
        } catch (\Exception $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }
}
