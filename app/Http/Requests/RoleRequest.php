<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|unique:roles,name',
                    'label' => 'required|string',
                    'permissions'  => 'exists:permissions,id',
                ];
                break;

            case 'PATCH':
                return [
                    'name' => 'required|string|unique:roles,name,'.$this->role->id,
                    'label' => 'required|string',
                    'permissions'  => 'exists:permissions,id',
                ];
                break;

            default:
                break;
        }
    }

    public function save() {
        switch (request()->method()) {
            case 'POST':
                $role = Role::create([
                    'name' => request('name'),
                    'label' => request('label'),
                ]);
                $role->givePermissions(request('permissions'));
                break;

            case 'PATCH':
                $this->role->update([
                    'name' => request('name'),
                    'label' => request('label'),
                ]);
                $this->role->permissions()->sync(request('permissions'));
                break;

            default:
                break;
        }
        // clear cache so that page will have new info
        \Cache::forget('roles');
    }
}
