<?php

namespace App\Http\Requests\Webhooks;

use App\ErrorLog;
use App\Webhook;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

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

    public function create_webhook($token) {
        $url = Webhook::URL_WEBHOOK;
        $client = new Client();
        try {
            $response = $client->post($url, [
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
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $json = json_decode($contents);

            // if there is no error
            if (!isset($json->error)) {
                Webhook::create([
                    'id' => $json->id,
                    'name' => request('name'),
                    'event_type' => request('event_type'),
                    'survey_id' => request('survey_id'),
                    'object_type' => request('object_type'),
                    'subscription_url' => url('api/surveys/'.request('survey_id').'/subscription'),
                ]);
            }
            return ['status' => true, 'content' => $json];
        } catch (ClientException $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }


}
