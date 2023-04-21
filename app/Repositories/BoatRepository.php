<?php
namespace App\Repositories;

use App\Models\Boat;
use App\Libs\AppCache;
use App\Models\ConfigSaisonDates;
use App\Models\Customer;
use App\Repositories\Ext\SelectOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BoatRepository extends Repository
{
    use SelectOptions;

    protected static $model = Boat::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_BOAT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_BOAT;
    /**
     * @var Customer $customer
     */
    protected $customer;

    public function getOptionsData($orderBy = 'name', $relations = null)
    {
        $modifiedRelations = [];
        if($relations) {
            if(is_string($relations)) {
                $modifiedRelations = ['customer', $relations];
            } elseif(is_array($relations)) {
                array_push($modifiedRelations, 'customer');
            }
            $modifiedRelations = array_unique($modifiedRelations);
        }
        $query = Boat::with($modifiedRelations)
            ->whereHas(
                'customer', function (Builder $query) {
                    if($this->customer) {
                        $query->whereCustomerId($this->customer->id);
                    }
                    $query->whereType('permanent');
                }
            )
            ->orderBy('name')
        ;
        $this->selectOptionsData = $query->get();

        return $this->selectOptionsData;
    }

    /**
     * @param Customer $customer
     * @return BoatRepository
     */
    public function setCustomer(Customer $customer): BoatRepository
    {
        $this->customer = $customer;
        return $this;
    }

    public function getBoatSaisonOptions(): Collection
    {
        return ConfigSaisonDates::where('key','=', 'customer')
            ->get()
            ->keyBy('mode')
            ->map
            ->name;
    }
}
