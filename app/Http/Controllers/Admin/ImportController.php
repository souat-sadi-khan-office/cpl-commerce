<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\BrandType;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\CPU\Images;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\Interface\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    private $brandRepository;
    private $productRepository;
    private $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function category()
    {
        return view('backend.import.category');
    }

    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if(is_array($rows) && count($rows) > 201) {
            return response()->json([
                'status' => false,
                'message' => 'Maximum 200 column at a single time',
            ]);
        }

        $importedCategories = [];
        $errors = [];

        $helperController = new HelperController($this->productRepository, $this->categoryRepository, $this->brandRepository);

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            if($row[1] == '') {
                continue;
            }

            if(Category::where('name', $row[1])->first()) {
                continue;
            }
            
            $parentId = $row[0] ?? null;
            if ($row[0] !== 'parent') {
                $parentCategory = Category::where('name', $row[0])->first();
                $parentId = $parentCategory->id;
            } else {
                $parentId = null;
            }

            $slug = $row[2];
            $request->slug = $slug;
            $slugExists = $helperController->checkSlug($request);
            
            $data = json_decode($slugExists->getContent(), true);
            if ($data['exists'] == true) {
                $slug = $row[2] . '-'. rand(10000, 1000000);
            }

            $imagePath = null;
            $imageUrl = $row[11] ?? null;
            if ($imageUrl) {
                $imagePath = Images::uploadImageFromUrl($imageUrl, 'categories', $row[1]);
                if (!$imagePath) {
                    $errors[] = "Image upload failed for row $key.";
                    continue;
                }
            }

            $category = Category::create([
                'parent_id'         => $parentId,
                'admin_id'          => Auth::guard('admin')->user()->id,
                'name'              => $row[1],
                'slug'              => $slug,
                'photo'             => $imagePath ?? null,
                'icon'              => "<i class=\"fi-rr-dashboard-monitor\"></i>",
                'description'       => $row[1],
                'header'            => $row[3] ?? $row[1],
                'short_description' => $row[4] ?? $row[1],
                'site_title'        => $row[5] ?? $row[1],
                'meta_title'        => $row[6] ?? $row[1],
                'meta_keyword'      => $row[7] ?? $row[1],
                'meta_description'  => $row[8] ?? $row[1],
                'meta_article_tag'  => null,
                'meta_script_tag'   => null,
                'status'            => $row[9] ?? 0,
                'is_featured'       => $row[10] ?? 0,
            ]);

            $importedCategories[] = $row[1];
        }

        return response()->json([
            'load' => true,
            'status' => true,
            'message' => 'Categories Imported Successfully',
            'imported' => $importedCategories,
            'errors' => $errors,
        ]);
    }

    public function brand()
    {
        return view('backend.import.brand');
    }

    public function importBrands(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $helperController = new HelperController($this->productRepository, $this->categoryRepository, $this->brandRepository);

        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }

            if($row[0] == '') {
                continue;
            }

            if(Brand::where('name', $row[0])->first()) {
                continue;
            }
            
            $slug = $row[1];
            $request->slug = $slug;
            $slugExists = $helperController->checkSlug($request);
            
            $data = json_decode($slugExists->getContent(), true);
            
            if (isset($data['exists']) && $data['exists'] == false) {
                $slug = $row[1] . '-'. rand(10000, 1000000);
            }

            $imageUrl = $row[2] ?? null;
            if ($imageUrl) {
                $imagePath = Images::uploadImageFromUrl($imageUrl, 'brands', $row[1]);
                if (!$imagePath) {
                    $errors[] = "Image upload failed for row $key.";
                    continue;
                }
            }

            $brand = Brand::create([
                'admin_id' => Auth::guard('admin')->user()->id,
                'name' => $row[0],
                'slug' => $slug,
                'logo' => $imagePath ?? null,
                'description' => $row[3] ?? $row[0],
                'meta_title' => $row[4] ?? $row[0],
                'meta_keyword' => $row[5] ?? $row[0],
                'meta_description' => $row[6] ?? $row[0],
                'meta_article_tag' => null,
                'meta_script_tag' => null,
                'status' => $row[7] == 'Active' ? 1 : 0,
                'is_featured' => $row[8] == 'Active' ? 1 : 0,
                'created_by' => Auth::guard('admin')->user()->id
            ]);

            if($brand) {
                $componentArray = explode(', ', $row[9]);
                if(is_array($componentArray) && count($componentArray) > 0) {
                    foreach($componentArray as $component) {
                        if($component != '') {
                            BrandType::create([
                                'brand_id' => $brand->id,
                                'name' => $component,
                                'status' => $brand->status,
                                'is_featured' => 0
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Imported Successfully',
        ]);
    }

    public function product()
    {
        return view('backend.import.product');
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        ]);

        $categoryId = $request->category_id;

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $importedCategories = [];
        $errors = [];

        $helperController = new HelperController($this->productRepository, $this->categoryRepository, $this->brandRepository);

        foreach ($rows as $key => $row) {
            // Ignore the header column
            if ($key == 0) {
                continue;
            }

            // Ignore if the slug is empty
            if($row[3] == '') {
                $errors[] = "Slug for {$row[2]} can not be empty.";
                continue;
            }

            // Ignore if the Product name is already exist
            if(Product::where('name', $row[0])->first()) {
                $errors[] = "Product: {$row[2]} is already exist.";
                continue;
            }

            // Check for brand
            $brandId = null;
            $brand = Brand::where('name', $row[0])->first();
            if($brand) {
                $errors[] = "Brand: {$row[0]} not found. Inserted in empty brand.";
                $brandId = $brand->id;
            }

            // check for brand type
            $brandTypeId = null;
            if($brandId && $row[1]) {
                $brandType = BrandType::where('brand_id', $brandId)->where('name', $row[1])->first();
                if($brandType) {
                    $brandTypeId = $brandType->id;
                }
            }
            
            $slug = $row[3];
            $request->slug = $slug;
            $slugExists = $helperController->checkSlug($request);
            
            $data = json_decode($slugExists->getContent(), true);
            
            if (isset($data['exists']) && $data['exists'] == true) {
                $slug = $slug . '-'. rand(10000, 1000000);
            }

            $imageUrl = $row[4] ?? null;
            if ($imageUrl) {
                $imagePath = Images::uploadImageFromUrl($imageUrl, 'products', $row[2]);
                if (!$imagePath) {
                    $errors[] = "Image upload failed for row $row[2].";
                    continue;
                }
            }

            DB::beginTransaction();

            $product = Product::create([
                'admin_id'      =>  Auth::guard('admin')->user()->id,
                'category_id'   =>  $categoryId,
                'brand_id'      =>  $brandId ?? 1,
                'brand_type_id' =>  $brandTypeId,
                'name'          =>  $row[2],
                'slug'          =>  $slug,
                'thumb_image'   =>  $imageUrl ?? null,
                'sku'           =>  $row[6],
                'status'        =>  $row[7] == 'Active' ? 1 : 0,
                'is_featured'   =>  $row[8] == 'Active' ? 1 : 0,
                'is_returnable' =>  $row[10] == 'Yes' ? 1 : 0,
                'return_deadline' => is_int($row[11]) ? $row[11] : null,
                'stock_types'   =>  'globally'
            ]);

            if($product) {

                ProductDetail::create([
                    'product_id' => $product->id,
                    'current_stock' => 0,
                    'low_stock_quantity' => $row[9] ?? 0,
                    'cash_on_delivery' => $row[12] == 'Yes' ? 1 : 0,
                    'est_shipping_days' => $row[13] ?? 0,
                    'number_of_sale' => 0,
                    'average_rating' => 0,
                    'number_of_rating' => 0,
                    'average_purchase_price' => 0,
                    'site_title' => $row[14] ?? $row[2],
                    'meta_title' => $row[12] ?? $row[2],
                    'meta_keyword' => $row[16] ?? $row[2],
                    'meta_description' => $row[17] ?? $row[2],
                    'video_link'    => $row[18] ?? null
                ]);

                if($row[5]) {
                    $images = explode(', ', $row[5]);
                    foreach($images as $image) {
                        $imagePath = Images::uploadImageFromUrl($image, 'products', $row[2]);
                        if (!$imagePath) {
                            $errors[] = "Image upload failed for row $row[2].";
                            continue;
                        } else {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'image'     => $imagePath,
                                'status'    => 1
                            ]);
                        }
                    }
                }

                dd("done");
            }

            DB::commit();
        }

        if(count($errors) > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Some Products are not imported',
                'errors' => $errors
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product Imported Successfully',
        ]);
    }
}
