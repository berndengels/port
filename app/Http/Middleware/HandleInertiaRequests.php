<?php

namespace App\Http\Middleware;

use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth'  => [
                'user' => auth()->user() ?? null,
                'role'  => null,
            ],
            'menu'  => [
                'admin' => [
                    'caravans'  => [
                        'caravans.index'  => [
                            'text'  => 'Caravans',
                            'title' => 'Caravans',
                            'icon'  => 'fas fa-caravan',
                        ],
                        'caravanDates.index'  => [
                            'text'  => 'Caravan Rezeption',
                            'title' => 'Caravan Rezeption',
                            'icon'  => 'fas fa-concierge-bell',
                        ],
                    ],
                    'boote' => [],
                ],
                'public' => [
                    'map'   => [
                        'nautic'    => 'map.nautic',
                        'street'    => 'map.street',
                    ],
                ],
            ],
            'caravan' => [
                'dates' => [
                    'list' => function () {
                        return CaravanDates::pageList()->get()
                            ->map(function ($item) {
                                return [
                                    'id'        => $item->id,
                                    'caravan_id' => $item->caravan_id,
                                    'carnumber' => $item->caravan->carnumber,
                                    'carlength' => $item->caravan->carlength,
                                    'email'     => $item->caravan->email,
                                    'from'      => $item->from,
                                    'until'     => $item->until,
                                    'persons'   => $item->persons,
                                    'price'     => $item->price,
                                    'prices'    => $item->prices,
                                    'days'      => $item->days,
                                    'show_url'  => URL::route('caravanDates.show', ['caravanDate' => $item]),
                                    'edit_url'  => URL::route('caravanDates.edit', ['caravanDate' => $item]),
                                ];
                            });
                    },
                ],
            ],
        ]);
    }
}
