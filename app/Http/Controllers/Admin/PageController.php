<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Repositories\Interface\PageRepositoryInterface;

class PageController extends Controller
{
    private $pagedRepository;

    public function __construct(PageRepositoryInterface $pagedRepository)
    {
        $this->pagedRepository = $pagedRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->pagedRepository->dataTable();
        }

        return view('backend.page.index');
    }

    public function create()
    {
        $pages = $this->pagedRepository->getAllPages()->where('status', 1);

        return view('backend.page.create', compact('pages'));
    }

    public function store(PageRequest $request)
    {
        return $this->pagedRepository->createPage($request);
    }

    public function edit($id)
    {
        $model = $this->pagedRepository->findPageById($id);
        $pages = $this->pagedRepository->getAllPages()->where('status', 1);
        return view('backend.page.edit', compact('model', 'pages'));
    }

    public function update(PageRequest $request, $id)
    {
        return $this->pagedRepository->updatePage($id, $request);
    }

    public function destroy($id)
    {
        $this->pagedRepository->deletePage($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Page deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->pagedRepository->updateStatus($request, $id);
    }
}
