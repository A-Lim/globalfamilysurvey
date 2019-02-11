<?php

namespace App\Http\Requests;

use App\Webhook;
use GuzzleHttp\Client;
use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
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

    public function save($token) {
        switch (request()->method()) {
            case 'POST':
                return $this->create_webhook_request($token);
                break;

            case 'PATCH':
                break;

            default:
                break;
        }
    }

    public function messages() {
        return [

        ];
    }

    protected function create_webhook_request($token) {
        $client = new Client();
        try {
            $response = $client->post(Webhook::URL_WEBHOOK, [
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
                    'name' => request('name'),
                    'type' => request('type'),
                    'survey_id' => request('survey_id'),
                    'subscription_url' => url('api/surveys/'.request('survey_id').'/subscription'),
                ]);
            }

            return ['status' => true, 'content' => $response->getBody()->getContents()];
        } catch (\Exception $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }

    protected function update_webhook_request($token) {
        $webhook = Webhook::find($this->webhook->id);
        $client = new Client();
        try {
            $response = $client->patch(Webhook::URL_WEBHOOK, [
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
                $webhook->update([
                    'name' => request('name'),
                    'type' => request('type'),
                    'survey_id' => request('survey_id'),
                    'subscription_url' => url('api/surveys/'.request('survey_id').'/subscription'),
                ]);
            }

            return ['status' => true, 'content' => $response->getBody()->getContents()];
        } catch (\Exception $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }


    protected function delete_webhook_request($token) {
        $webhook = Webhook::find($this->webhook->id);
        $client = new Client();
        try {
            $response = $client->delete(Webhook::URL_WEBHOOK.'/'.$webhook->id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $json = json_decode($contents);

            // if there is no error
            if (!isset($json->error))
                $webhook->delete();

            return ['status' => true, 'content' => $response->getBody()->getContents()];
        } catch (\Exception $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }

}
