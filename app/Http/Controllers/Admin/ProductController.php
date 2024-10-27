<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\BrandTypeRepositoryInterface;
use App\Repositories\Interface\TaxRepositoryInterface;
use App\Repositories\Interface\CityRepositoryInterface;
use App\Repositories\Interface\ZoneRepositoryInterface;
use App\Repositories\Interface\CountryRepositoryInterface;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\Interface\CurrencyRepositoryInterface;
use App\Repositories\Interface\ProductSpecificationRepositoryInterface;

class ProductController extends Controller
{
    protected $categoryRepository;
    protected $productRepository;
    protected $specificationRepository;
    private $taxRepository;
    private $currencyRepository;
    private $zoneRepository;
    private $countryRepository;
    private $cityRepository;
    private $brandTypeRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        TaxRepositoryInterface $taxRepository,
        ProductSpecificationRepositoryInterface $specificationRepository,
        CurrencyRepositoryInterface $currencyRepository,
        ZoneRepositoryInterface $zoneRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository,
        BrandTypeRepositoryInterface $brandTypeRepository,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->specificationRepository = $specificationRepository;
        $this->taxRepository = $taxRepository;
        $this->currencyRepository = $currencyRepository;
        $this->zoneRepository = $zoneRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
        $this->brandTypeRepository = $brandTypeRepository;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            if($request->category_id != null || $request->brand_id != null) {
                return $this->productRepository->dataTableWithAjaxSearch($request->category_id, $request->brand_id);
            } else {
                return $this->productRepository->dataTable();
            }
        }

        $category_id = $request->category_id;
        $brand_id = $request->brand_id;

        return view('backend.product.index', compact('category_id', 'brand_id'));
    }

    public function create(Request $request)
    {
        if (isset($request->parent_id)) {
            return response()->json(['subs' => $this->categoryRepository->categoriesDropDown($request)]);
        }

        $taxes = $this->taxRepository->getAllActiveTaxes();
        $currencies = $this->currencyRepository->getAllActiveCurrencies();
        $zones = $this->zoneRepository->getAllActiveZones();
        $countries = $this->countryRepository->getAllActiveCountry();
        $cities = $this->cityRepository->getAllActiveCity();

        return view('backend.product.create', compact('taxes', 'currencies', 'zones', 'countries', 'cities'));
    }

    public function store(Request $request)
    {
        return $this->productRepository->storeProduct($request);
    }

    public function destroy($id)
    {
        $this->productRepository->deleteProduct($id);

        return response()->json([
            'status' => true,
            'load' => true,
            'message' => "Product deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->productRepository->updateStatus($request, $id);
    }

    public function updateFeatured(Request $request, $id)
    {
        return $this->productRepository->updateFeatured($request, $id);
    }
    public function specification(Request $request)
    {
        if (isset($request->category_id)) {
            $ids = $this->categoryRepository->getParentCategoryIds($request->category_id);
            return response()->json(['keys' => $this->specificationRepository->allKeysIncludingParent($ids)]);
        } elseif ($request->key_id) {
            return response()->json(['types' => $this->specificationRepository->types($request->key_id)]);
        } elseif ($request->type_id) {
            return response()->json(['attributes' => $this->specificationRepository->attributes($request->type_id)]);
        }
        return false;
    }

    public function edit($id)
    {
        $model = $this->productRepository->getProductById($id);

        $brandTypes = null;
        if($model->brand_id) {
            $brandTypes = $this->brandTypeRepository->getAllBrandTypesByBrandId($model->brand_id);
        }
        $taxes = $this->taxRepository->getAllActiveTaxes();
        $currencies = $this->currencyRepository->getAllActiveCurrencies();
        $zones = $this->zoneRepository->getAllActiveZones();
        $countries = $this->countryRepository->getAllActiveCountry();
        $cities = $this->cityRepository->getAllActiveCity();
        return view('backend.product.edit', compact('model', 'brandTypes', 'taxes', 'currencies', 'zones', 'countries', 'cities'));
    }

    public function update(Request $request, $id)
    {
        return $this->productRepository->updateProduct($request, $id);
    }

    public function stock($id)
    {
        $models = $this->productRepository->getProductStockPurchaseDetails($id);

        return view('backend.product.stock', compact('models'));
    }

    public function duplicate(Request $request, $id) 
    {
        return $this->productRepository->duplicateProduct($request, $id);
    }
    public function specificationproducts(Request $request){

        if ($request->ajax()) {
            return $this->productRepository->specificationproductsDatatable();
        }

        return view('backend.product.specification.index');
    }


    public function specificationproductModal($id)
    {
        return $this->productRepository->specificationproductModal($id);
    }
    
    public function specificationProductPage($id)
    {
        return $this->productRepository->specificationProductPage($id);
    }

    public function keyfeature($id)
    {
        return $this->productRepository->keyfeature($id);
    }
    
    public function delete($id) 
    {
        return $this->productRepository->delete($id);
    }

    public function specificationsAdd(Request $request,$id)
    {
        return $this->productRepository->specificationsAdd($request,$id);
    }
}
