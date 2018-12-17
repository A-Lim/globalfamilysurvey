<?php

namespace App\Http\Requests;

use DB;
use App\Church;
use Illuminate\Foundation\Http\FormRequest;

class ChurchRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // check if user is admin
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'  => 'required|string|min:6|unique:churches',
                    'country' => 'required|string',
                    'denomination' => 'required|string'
                ];
                break;

            case 'PATCH':
                return [
                    'name'  => 'required|string|min:6|unique:churches,name,'.$this->church->id,
                    'country' => 'required|string',
                    'denomination' => 'required|string'
                ];
                break;

            default:
                break;
        }
    }

    /**
     * Store or Update church base on request method.
     */
    public function save() {
        switch (request()->method()) {
            case 'POST':
                Church::create([
                    'uuid' => (string) Uuid::generate(4),
                    'name' => request('name'),
                    'country' => request('country'),
                    'denomination' => request('denomination')
                ]);
                break;

            case 'PATCH':
                $this->church->update([
                    'name' => request('name'),
                    'country' => request('country'),
                    'denomination' => request('denomination')
                ]);
                break;

            default:
                break;
        }
        // clear cache so that cache information on churches are updated
        \Cache::forget('churches');
    }
}
