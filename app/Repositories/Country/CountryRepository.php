<?php
namespace App\Repositories;

use App\Country;

use Illuminate\Http\Request;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Country::CACHE_KEY, function() {
            return Country::all();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function all_options() {
        return \Cache::rememberForEver(Country::CACHE_KEY.':options', function() {
            return Country::select('id', 'name')->get();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Country::find($id);
    }
}
