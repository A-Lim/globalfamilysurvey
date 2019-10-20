<?php
namespace App\Repositories;

use App\User;
use App\Role;
use App\Church;
use App\Network;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class AuthRepository implements AuthRepositoryInterface
{
    public function register_user(Request $request, $password) {
        $data = $request->all();
        $data['password'] = Hash::make($password);
        $user = User::create($data);

        $user->assignRoleById($request->role_id);
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function register_church(Request $request, $password) {
        $church_data = $request->all();
        $church_data['uuid'] = (string) Uuid::generate(4);

        // create church
        // link church to network
        $church = Church::create($church_data);

        // create user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password),
            'church_id' => $church->id
        ]);
        // assign role church pastor
        $user->assignRoleById(Role::CHURCH_PASTOR);

        \Cache::forget(Church::CACHE_KEY);
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function register_network(Request $request, $password) {
        // create network
        $network = Network::create(['uuid' => (string) Uuid::generate(4)]);

        $church_data = $request->all();
        // link church to network
        $church_data['network_uuid'] = $network->uuid;
        $church_data['uuid'] = (string) Uuid::generate(4);

        // create church
        $church = Church::create($church_data);

        // create user
        $user = User::create([
            'email' => request('email'),
            'password' => Hash::make($password),
            'church_id' => $church->id
        ]);
        // assign role network leader
        $user->assignRoleById(Role::NETWORK_LEADER);

        \Cache::forget(Church::CACHE_KEY);
        return $user;
    }
}
