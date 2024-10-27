<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Images;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\StockPurchase;
use App\Http\Requests\StockRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\CityRepositoryInterface;
use App\Repositories\Interface\ZoneRepositoryInterface;
use App\Repositories\Interface\CountryRepositoryInterface;
use App\Repositories\Interface\CurrencyRepositoryInterface;
use App\Repositories\Interface\ProductStockRepositoryInterface;

class ProductStockController extends Controller
{
    private $stockRepository;
    private $currencyRepository;
    private $zoneRepository;
    private $countryRepository;
    private $cityRepository;

    public function __construct(
        ProductStockRepositoryInterface $stockRepository,
        CurrencyRepositoryInterface $currencyRepository,
        ZoneRepositoryInterface $zoneRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->stockRepository = $stockRepository;
        $this->currencyRepository = $currencyRepository;
        $this->zoneRepository = $zoneRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->stockRepository->dataTable();
        }

        return view('backend.stock.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product_id = null;
        if($request->get('product_id')) {
            $product_id = $request->get('product_id');
        }

        $currencies = $this->currencyRepository->getAllActiveCurrencies();
        $zones = $this->zoneRepository->getAllActiveZones();
        $countries = $this->countryRepository->getAllActiveCountry();
        $cities = $this->cityRepository->getAllActiveCity();

        return view('backend.stock.create', compact('currencies','zones', 'countries', 'cities', 'product_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        return $this->stockRepository->createStock($request->all());        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = $this->stockRepository->findStockById($id);

        return view('backend.stock.show', compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->stockRepository->deleteStock($id);
    }

    /**
     * Update the specified resource from storage.
     */
    public function updateStatus(Request $request, $id)
    {
        return $this->stockRepository->updateStatus($request, $id);
    }
}
