<?php

namespace App\Http\Controllers;

use App\Entity\UserInterface;
use App\EntityManager;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected EntityManager $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;

        Carbon::setLocale('hu');
    }

    protected function getUser(): ?UserInterface
    {
        $user = Auth::user();

        if ($user instanceof UserInterface) {
            return $user;
        }

        return null;
    }
}
