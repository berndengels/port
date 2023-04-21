<?php

dataset('price_data_caravan', function () {
    return [
        'caravan_id'    => 2,
        'from'          => '2021-10-01',
        'until'         => '2021-10-05',
        'persons'       => 2,
        'electric'      => false,
        'carlength'     => 9,
    ];
});
dataset('price_data_guest_boat', function () {

    return [
        'from'          => '2021-07-01',
        'until'         => '2021-07-03',
        'length'        => 9,
    ];
});
dataset('price_data_boat_saison', function () {

    return [
        'boat_id'       => 1,
        'from'          => '2022-05-01',
        'until'         => '2022-10-30',
        'crane'         => true,
        'mast_crane'    => true,
        'cleaning'      => false,
        'transport'     => true,
    ];
});
dataset('price_data_boat_winter', function () {
    return [
        'boat_id'       => 1,
        'from'          => '2021-10-31',
        'until'         => '2021-04-30',
        'crane'         => true,
        'mast_crane'    => true,
        'cleaning'      => true,
        'transport'     => true,
    ];
});
