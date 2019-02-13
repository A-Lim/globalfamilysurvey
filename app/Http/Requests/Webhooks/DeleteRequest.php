<?php

namespace App\Http\Requests\Webhooks;

use App\Webhook;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [

        ];
    }

    public function messages() {
        return [

        ];
    }

    public function delete_webhook($token) {
        $webhook = $this->webhook;
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

            return ['status' => true, 'content' => $json];
        } catch (\Exception $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents())->error;
            $contents = json_decode($exception->getResponse()->getBody());
            return ['status' => false, 'message' => 'Status Code ('.$error->http_status_code.'): '.$error->message, 'content' => $contents];
        }
    }

}
