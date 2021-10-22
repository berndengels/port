<?php
namespace Database\Factories;

use App\Libs\BoatPriceCalculator;
use App\Libs\CaravanPriceCalculator;
use App\Models\Boat;
use App\Models\BoatDates;
use Carbon\Carbon;
use Database\Factories\Ext\MainFactory;

class BoatDatesFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoatDates::class;
    protected $parentModel = Boat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modi       = ['guest','permanent'];
        $boats      = $this->getParents();
        $max        = max($boats->keys()->toArray()) - 1;
        $randomDateEnd = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $randIndex  = rand(0, $max);
        $modus      = $modi[rand(0,1)];
        $boatType   = $boats[$randIndex]->boat_type;
        $length     = $boats[$randIndex]->length;
        $width      = $boats[$randIndex]->width;
        $weight     = $boats[$randIndex]->weight;

        if('sail' === $boatType) {
            $mastLength     = $boats[$randIndex]->mast_length;
            $mastWeight     = $boats[$randIndex]->mast_weight;
            $crane          = $boats[$randIndex]->crane;
            $mastCrane      = $boats[$randIndex]->mastCrane;
            $cleaning       = $boats[$randIndex]->cleaning;
            $priceData  = (new BoatPriceCalculator())->getPrice($modus, $length, $width, $weight, $mastLength, $mastWeight, $crane, $mastCrane, $cleaning);
        } else {
            $priceData  = (new BoatPriceCalculator())->getPrice($modus, $length, $width, $weight);
        }
        $price      = $priceData['total'];
        $prices     = json_encode($priceData['prices']);

        return [
            'boat_id'   => $boats[$randIndex]->id,
            'modus'     => $modus,
            'from'      => $from,
            'until'     => $until,
            'price'     => $price,
            'prices'    => $prices,
        ];
    }
}
