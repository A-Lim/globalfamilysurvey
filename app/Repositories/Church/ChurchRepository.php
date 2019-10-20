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
        return \Cache::rememberForEver(Church::CACHE_KEY, function() {
            return Church::all();
        });
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
        \Cache::forget(Church::CACHE_KEY);
        return Church::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Church $church, Request $request) {
        \Cache::forget(Church::CACHE_KEY);
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

        \Cache::forget(Church::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function datatable_query() {
        return Church::join('countries', 'churches.country_id', '=', 'countries.id')
                ->where('churches.deleted_at', null)
                ->select('churches.*', 'countries.name as country_name');
    }
}
