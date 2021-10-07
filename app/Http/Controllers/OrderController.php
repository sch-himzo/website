<?php

namespace App\Http\Controllers;

use App\EntityManager;
use App\Providers\SettingProvider;
use App\Providers\SettingProviderInterface;
use App\Util\Settings;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    private SettingProviderInterface $settingProvider;

    public function __construct(
        EntityManager $entityManager,
        SettingProvider $settingProvider
    )
    {
        parent::__construct($entityManager);

        $this->settingProvider = $settingProvider;
    }

    public function create(Request $request)
    {
        $minimumOrderTime = $this->settingProvider->provide(Settings::SETTING_MINIMUM_ORDER_TIME)->getSetting();
        $minimumOrderDate = $this->settingProvider->provide(Settings::SETTING_MINIMUM_ORDER_DATE)->getSetting();

        if ($minimumOrderDate === null || (int)$minimumOrderDate < time()) {
            if ($minimumOrderTime === null) {
                $minimumTime = date('Y-m-d', 7 * 24 * 60 + time());
            } else {
                $minimumTime = date('Y-m-d', (int)$minimumOrderTime + time());
            }
        } else {
            $minimumTime = date('Y-m-d', $minimumOrderDate);
        }

        $view = view(
            'orders.new',
            [
                'min_date' => $minimumTime,
                'title' => Session::get('title'),
                'comment' => Session::get('comment'),
                'time_limit' => Session::get('time_limit'),
                'public_albums' => Session::get('public_albums'),
                'error_fields' => Session::get('error_fields') ?? [],
                'error_messages' => Session::get('error_messages') ?? [],
            ]
        );

        Session::forget(['title', 'comment', 'time_limit', 'public_albums', 'error_fields', 'error_messages']);

        return $view;
    }
}
