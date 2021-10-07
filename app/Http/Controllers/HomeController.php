<?php

namespace App\Http\Controllers;

use App\Entity\NewsItem;
use App\Entity\UserInterface;
use App\EntityManager;
use App\Providers\NewsItemProviderInterface;
use App\Providers\SettingProviderInterface;
use App\Repository\MachineRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\SlideRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Util\Settings;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends Controller
{
    private const PARTY_MODE_SESSION = 'party';
    private const PARTY_MODE_ON = 'on';
    private const PARTY_MODE_OFF = 'off';

    private SlideRepositoryInterface $slideRepository;

    private NewsItemProviderInterface $newsItemProvider;

    private SessionInterface $session;

    private UserRepositoryInterface $userRepository;

    private SettingProviderInterface $settingProvider;

    private MachineRepositoryInterface $machineRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct(
        EntityManager $entityManager,
        SlideRepositoryInterface $slideRepository,
        NewsItemProviderInterface $newsItemProvider,
        SessionInterface $session,
        UserRepositoryInterface $userRepository,
        SettingProviderInterface $settingProvider,
        MachineRepositoryInterface $machineRepository,
        RoleRepositoryInterface $roleRepository
    )
    {
        $this->slideRepository = $slideRepository;
        $this->newsItemProvider = $newsItemProvider;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->settingProvider = $settingProvider;
        $this->machineRepository = $machineRepository;
        $this->roleRepository = $roleRepository;

        parent::__construct($entityManager);
    }

    public function index(Request $request)
    {
        $slides = $this->slideRepository->findAll();
        $news = $this->newsItemProvider->provideForUser($this->getUser());

        $newsItem = new NewsItem();

        $newsItem->setAlert(false);
        $newsItem->setContent("asd");
        $newsItem->setRole($this->roleRepository->findDefaultRole());

        $this->entityManager->persist($newsItem);
        $this->entityManager->flush();

        return view('index', [
            'slides' => $slides,
            'news' => $news
        ]);
    }

    public function party(): Response
    {
        if ($this->session->get(self::PARTY_MODE_SESSION) === self::PARTY_MODE_ON) {
            $this->session->set(self::PARTY_MODE_SESSION, self::PARTY_MODE_OFF);
        } else {
            $this->session->set(self::PARTY_MODE_SESSION, self::PARTY_MODE_ON);
        }

        return redirect()->back();
    }

    public function indexLogin(Request $request)
    {
        $slides = $this->slideRepository->findAll();

        return view('index', [
            'login' => 1,
            'slides' => $slides
        ]);
    }

    public function getUsers(Request $request): Response
    {
        $users = $this->userRepository->findAllInClub();

        return response()->json([
            'users' => $users->map(
                static function (UserInterface $user): string {
                    return $user->getName();
                }
            ),
            'ids' => $users->map(
                static function (UserInterface $user): int {
                    return $user->getId();
                }
            )
        ]);
    }

    public function machineStatus()
    {
        $setting = $this->settingProvider->provide(Settings::SETTING_CURRENT_MACHINE);
        $machine = $this->machineRepository->find();

        return view('machines.status', [
            'machine' => $machine
        ]);
    }

    public function getMachineStatus(Request $request)
    {
        $setting = Setting::where('name', 'current_machine')->first();

        $machine = Machine::find($setting->setting);

        $total_stitches = $request->input('total_stitches');
        $actual_total_stitches = $machine->total_stitches;

        $stitches = [];

        foreach (json_decode($machine->current_dst) as $color) {
            foreach ($color as $stitch) {
                $stitches[] = $stitch;
            }
        }

        if ($machine->current_stitch != $machine->total_stitches) {
            $current_offset = $stitches[$machine->current_stitch];
        } else {
            $current_offset = $stitches[0];
        }

        if ($total_stitches != $actual_total_stitches) {
            return response()->json([
                'new_design' => true
            ]);
        } else {
            return response()->json([
                'state' => $machine->state,
                'current_stitch' => $machine->current_stitch,
                'status' => $machine->getState(),
                'current_offset' => $current_offset,
                'x_offset' => abs($machine->x_offset),
                'y_offset' => abs($machine->y_offset),
                'current_design' => $machine->current_design,
                'total_designs' => $machine->design_count,
                'progress_bar' => $machine->getProgressBar(),
                'total_stitches' => $machine->total_stitches
            ]);
        }
    }

    public function getProgressBar()
    {
        $setting = Setting::where('name', 'current_machine')->first();
        $machine = Machine::find($setting->setting);

        return response()->json([
            'state' => $machine->getState(),
            'progress_bar' => $machine->getProgressBar(),
            'current_stitch' => $machine->current_stitch,
            'total_stitches' => $machine->total_stitches,
            'current_design' => $machine->current_design,
            'total_designs' => $machine->design_count
        ]);
    }

    public function sitemap()
    {
        $urls = [
            route('index'),
            route('gallery.index'),
            route('faq.index')
        ];

        return view('sitemap', [
            'urls' => $urls
        ]);
    }
}