<?php

namespace App\Http\Requests\Roles;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'label' => 'required|string',
            'permissions'  => 'exists:permissions,id',
        ];
    }

    public function save() {
        $role = Role::create(request()->input());
        $role->givePermissions(request('permissions'));

        // clear cache so that page will have new info
        \Cache::forget('roles');
    }
}
