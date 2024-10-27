<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interface\BannerRepositoryInterface;

class BannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->bannerRepository->dataTable();
        }

        return view('backend.banner.index');
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        return $this->bannerRepository->createBanner($request);
    }

    public function edit($id)
    {
        $model = $this->bannerRepository->findBannerById($id);
        $source = null;
        if ($model->source_type != null) {
            $source = $this->bannerRepository->getSourceOptions($model->source_type);
        }
        return view('backend.banner.edit', compact('model', 'source'));
    }

    public function update(Request $request, $id)
    {
        return $this->bannerRepository->updateBanner($id, $request);
    }

    public function destroy($id)
    {
        $this->bannerRepository->deleteBanner($id);

        return response()->json([
            'status' => true,
            'load' => true,
            'message' => "Banner deleted successfully"
        ]);
    }

    public function show()
    {
        return 1;
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->bannerRepository->updateStatus($request, $id);
    }
}
