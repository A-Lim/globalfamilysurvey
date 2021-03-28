<?php
namespace App\Repositories;

use App\Church;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;

class ChurchRepository implements ChurchRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return Church::orderBy('id', 'desc')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Church::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(Request $request) {
        $data = $request->all();
        $data['uuid'] = (string) Uuid::generate(4);
        return Church::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Church $church, Request $request) {
        return $church->update($request->all());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Church $church, $forceDelete = false) {
        if ($forceDelete)
            $church->forceDelete();
        else
            $church->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function datatable_query() {
        return Church::join('countries', 'churches.country_id', '=', 'countries.id')
                ->where('churches.deleted_at', null)
                ->orderBy('churches.id', 'desc')
                ->select('churches.*', 'countries.name as country_name');
    }
}
