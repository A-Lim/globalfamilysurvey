<?php
namespace App\Repositories;

use App\Network;

use Illuminate\Http\Request;

class NetworkRepository implements NetworkRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return Network::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Network::find($id);
    }
}
