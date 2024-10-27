<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use App\CPU\Helpers;
use App\Models\Rating;
use App\Models\Country;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\WishList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\ProductQuestion;
use App\Models\HomepageSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Subscriber;
use App\Models\ProductStock;
use App\Models\SpecificationKey;
use App\Models\ProductSpecification;
use App\Repositories\Interface\BannerRepositoryInterface;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\FlashDealRepositoryInterface;
use App\Repositories\Interface\BrandRepositoryInterface;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Interface\CouponRepositoryInterface;

class HomePageController extends Controller
{
    private $banner;
    private $brands;
    private $product;
    private $flashDeals;
    private $userRepository;
    private $couponRepository;

    public function __construct(
        BannerRepositoryInterface $banner,
        ProductRepositoryInterface $product,
        BrandRepositoryInterface $brands,
        FlashDealRepositoryInterface $flashDeals,
        UserRepositoryInterface $userRepository,
        CouponRepositoryInterface $couponRepository,
    ) {
        $this->brands = $brands;
        $this->banner = $banner;
        $this->product = $product;
        $this->flashDeals = $flashDeals;
        $this->userRepository = $userRepository;
        $this->couponRepository = $couponRepository;
    }

    public function visibility(Request $request, $section)
    {
        try {
            $validSections = [
                'bannerSection',
                'sliderSection',
                'midBanner',
                'dealOfTheDay',
                'trending',
                'brands',
                'popularANDfeatured',
                'newslatter',
            ];

            if (!in_array($section, $validSections)) {
                return response()->json(['error' => 'Invalid section provided.', 'success' => false]);
            }

            $settings = HomepageSettings::first();

            if ($settings) {
                $settings->$section = !$settings->$section;
                $settings->last_updated_by = Auth::guard('admin')->id();
                $settings->save();

                Session::put('homepage_setting.' . $section, $settings->$section);
                Session::put('homepage_setting.last_updated_by', Auth::guard('admin')->user()->name);
                Session::put('homepage_setting.last_updated_at', $settings->updated_at);

                return response()->json(['success' => true, 'message' => Str::upper($section) . ' Section status updated successfully.']);
            } else {
                return response()->json(['error' => 'Homepage settings not found.', 'success' => false]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function addToCart(Request $request)
    {
        $slug = $request->slug;
        $quantity = $request->quantity ? $request->quantity : 1;
        $item_sub_total_price = 0;

        if($quantity > 100) {
            return response()->json(['status' => false, 'message' => 'This product is not available in the desired quantity or not in stock']);
        }

        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => "Product not Found"
            ]);
        }

        // Find or create a cart for the user or by IP address
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::guard('customer')->user()->id ?? null, 'ip' => $request->ip()],
            ['total_quantity' => 0, 'currency_id' => 1]
        );

        // Check if the product already exists in the cart
        $cartDetail = CartDetail::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        // If the product exists in the cart, update quantity
        if ($cartDetail) {

            if(($cartDetail->quantity + $quantity) > 100) {
                return response()->json(['status' => false, 'message' => 'This product is not available in the desired quantity or not in stock ']);
            }

            $stockResponse = getProductStock($product->id, ($cartDetail->quantity + $quantity));
            if(!$stockResponse['status']) {
                return response()->json($stockResponse);
            }

            $quantity += $cartDetail->quantity;
            if(($stockResponse['stock']) < $quantity) {
                return response()->json(['status' => true, 'message' => 'This product is not available in the desired quantity or not in stock ']);
            }

            $cartDetail->quantity = $quantity;
            $cartDetail->save();

            $price = $this->product->discountPrice($cartDetail->product);
            $item_sub_total_price = $cartDetail->quantity * $price;

        } else {

            if($quantity > 100) {
                return response()->json(['status' => false, 'message' => 'This product is not available in the desired quantity or not in stock ']);
            }

            $stockResponse = getProductStock($product->id, $quantity);
            if(!$stockResponse['status']) {
                return response()->json($stockResponse);
            }

            if(($stockResponse['stock']) < $quantity) {
                return response()->json(['status' => true, 'message' => 'This product is not available in the desired quantity or not in stock ']);
            }

            // Otherwise, create a new cart detail
            $cartDetail = new CartDetail([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
            $cartDetail->save();

            $price = $this->product->discountPrice($cartDetail->product);
            $item_sub_total_price = $cartDetail->quantity * $price;
        }


        // Update cart total price and quantity
        $cart->total_quantity = $quantity;
        $cart->save();

        $total_price = 0;
        $items = CartDetail::where('cart_id', $cart->id)->get();
        foreach($items as $item) {
            $price = $this->product->discountPrice($item->product);
            $total_price += ($price * $item->quantity);
        }

        $total_price = format_price(convert_price($total_price));
        $item_sub_total_price = format_price(convert_price($item_sub_total_price));
        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully',
            'thumb_image' => asset($product->thumb_image),
            'name' => $product->name,
            'total_price' => $total_price,
            'cart_sub_total_amount' => $total_price,
            'cart_total_amount' => $total_price,
            'total_quantity' => $cart->total_quantity,
            'item_sub_total' => $item_sub_total_price,
            'id' => $cartDetail->id
        ]);
    }

    public function subToCart(Request $request)
    {
        $slug = $request->slug;
        $quantity = $request->quantity ? $request->quantity : 1;
        $item_sub_total_price = 0;
        $load = false;

        if($quantity < 1) {
            return response()->json(['status' => false, 'message' => 'You crossed minimum purchase quantity']);
        }

        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => "Product not Found"
            ]);
        }

        // Find or create a cart for the user or by IP address
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::guard('customer')->user()->id ?? null, 'ip' => $request->ip()],
            ['total_quantity' => 0, 'currency_id' => 1]
        );

        // Check if the product already exists in the cart
        $cartDetail = CartDetail::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        // If the product exists in the cart, update quantity
        if ($cartDetail) {

            if(($cartDetail->quantity - $quantity) < 1) {
                return response()->json(['status' => false, 'message' => 'You crossed minimum purchase quantity']);
            }

            $cartDetail->quantity -= $quantity;
            $cartDetail->save();

            $price = $this->product->discountPrice($cartDetail->product);
            $item_sub_total_price = $cartDetail->quantity * $price;

            if($cartDetail->quantity == 0) {
                $cartDetail->delete();
                $load = true;
            }
        }


        // Update cart total price and quantity
        $cart->total_quantity = $quantity;
        $cart->save();

        $total_price = 0;
        $items = CartDetail::where('cart_id', $cart->id)->get();
        foreach($items as $item) {
            $price = $this->product->discountPrice($item->product);
            $total_price += ($price * $item->quantity);
        }

        $total_price = format_price(convert_price($total_price));
        $item_sub_total_price = format_price(convert_price($item_sub_total_price));
        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully',
            'thumb_image' => asset($product->thumb_image),
            'name' => $product->name,
            'total_price' => $total_price,
            'cart_sub_total_amount' => $total_price,
            'cart_total_amount' => $total_price,
            'total_quantity' => $cart->total_quantity,
            'item_sub_total' => $item_sub_total_price,
            'id' => $cartDetail->id,
            'load' => $load
        ]);
    }

    public function getCartItems(Request $request) 
    {
        $items = [];
        $counter = 0;
        $total_price = 0;
        $models = [];
        
        if(Auth::guard('customer')->check()) {
            $cart = Cart::where('user_id', Auth::guard('customer')->user()->id)->first();
        } else {
            $cart = Cart::where('ip', $request->ip())->first();
        }

        if(!$cart) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::guard('customer')->user()->id ?? null, 'ip' => $request->ip()],
                ['total_quantity' => 0, 'currency_id' => 1]
            );
        }

        $items = CartDetail::where('cart_id', $cart->id)->get();

        $cart_updated = false;
        foreach($items as $item) {
            $stockResponse = getProductStock($item->product_id);
            if(!$stockResponse['status']) {
                $cart_updated = true;
                $itemQuantity = $item->quantity;
                $item->delete();
                $cart->total_quantity -= $itemQuantity;
                $cart->save();
            } else {
                $price = $this->product->discountPrice($item->product);
                $total_price += ($price * $item->quantity);

                $models[] = [
                    'id' => $item->id,
                    'slug' => $item->product->slug,
                    'thumb_image' => asset($item->product->thumb_image),
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $price
                ];
            }
        }

        // Return view with cart items
        $counter = count($models);
        $total_price = format_price(convert_price($total_price));
        if($request->has('show') && $request->show == 'main-cart-area') {
            $html = view('frontend.components.main_cart_listing', compact('models', 'cart_updated'))->render();
        } else {
            $html = view('frontend.components.cart_listing', compact('models', 'cart_updated'))->render();
        }
        return response()->json(['content' => $html, 'total_price' => $total_price, 'counter' => $counter]);
    }

    public function removeCartItems(Request $request)
    {
        $id = $request->id;

        if (!$id) {
            return response()->json(['status' => false, 'message' => 'Cart not found. ']);
        }

        $item = CartDetail::find($id);
        if (!$item) {
            return response()->json(['status' => false, 'message' => 'Cart sad item not found. ']);
        }
        $cartId = $item->cart_id;

        $cart = Cart::find($cartId);
        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart item not found. ']);
        }

        $item->delete();

        $items = CartDetail::where('cart_id', $cartId)->get();
        $total_quantity = 0;

        if ($items) {
            foreach ($items as $item) {
                $total_quantity += $item->quantity;
            }
        }

        $items = CartDetail::where('cart_id', $cart->id)->get();

        $models = [];
        $total_price = 0;
        foreach($items as $item) {
            $price = $this->product->discountPrice($item->product);
            $total_price += ($price * $item->quantity);

            $models[] = [
                'id' => $item->id,
                'slug' => $item->product->slug,
                'thumb_image' => asset($item->product->thumb_image),
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $price
            ];
        }

        // Return view with cart items
        $counter = count($models);
        $total_price = format_price(convert_price($total_price));
        if ($request->has('show') && $request->show == 'main-cart-area') {
            $html = view('frontend.components.main_cart_listing', compact('models'))->render();
        } else {
            $html = view('frontend.components.cart_listing', compact('models'))->render();
        }
        return response()->json(['status' => true, 'message' => 'Item is removed', 'content' => $html, 'total_price' => $total_price, 'counter' => $counter]);
    }

    public function cart(Request $request)
    {
        $items = [];
        $counter = 0;
        $total_price = 0;

        // Check if customer is logged in
        if(Auth::guard('customer')->check()) {
            $cart = Cart::where('user_id', Auth::guard('customer')->user()->id)->first();
        } else {
            $cart = Cart::where('ip', $request->ip())->first();
        }

        // If cart exists, get the cart details
        if(!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart not found']);
        }

        $items = CartDetail::where('cart_id', $cart->id)->get();

        $cart_updated = false;
        $models = [];
        foreach($items as $item) {
            $stockResponse = getProductStock($item->product_id);
            if(!$stockResponse['status']) {
                $cart_updated = true;
                $itemQuantity = $item->quantity;
                $item->delete();
                $cart->total_quantity -= $itemQuantity;
                $cart->save();
            } else {
                $price = $this->product->discountPrice($item->product);
                $total_price += ($price * $item->quantity);

                $models[] = [
                    'id' => $item->id,
                    'slug' => $item->product->slug,
                    'thumb_image' => asset($item->product->thumb_image),
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $price
                ];
            }
        }

        // Return view with cart items
        $counter = count($models);

        return view('frontend.cart', compact('models', 'cart_updated', 'counter', 'total_price'));
    }

    public function compare()
    {
        list($specifications, $models, $product_id_array) = $this->product->compare();

        $product_id_array = array_reverse($product_id_array);
        // dd($product_id_array, $specifications, $models);
        return view('frontend.compare', compact('models', 'product_id_array', 'specifications'));
    }

    public function removeCompare($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if($product) {
            if(session()->has('compare_list') && is_array(session()->get('compare_list'))) {
                if(in_array($product->id, session()->get('compare_list'))) {
                    $newCompareList = array_diff( session()->get('compare_list'), [$product->id] );
                    session()->put('compare_list', $newCompareList);
                }
            }
        }

        return redirect()->route('compare');
    }

    public function index(Request $request)
    {

        $banners = Cache::remember('banners', now()->addMinutes(300), function () {
            $data = $this->banner->getAllBanners();

            return $data->where('status', 1)
                ->groupBy('banner_type')
                ->filter(function ($group, $key) {
                    if ($key === 'main_sidebar' && $group->count() >= 2) {
                        return $group->shuffle()->take(2);
                    }
                    return $key !== 'main_sidebar' ? $group : collect();
                });
        });


        $n = isset($request->best_seller) ? 'best_seller' : (isset($request->featured) ? 'featured' : (isset($request->offred) ? 'offred' : ''));


        if ($request->ajax()) {
            $products = Cache::remember('homeProducts_' . $n, now()->addMinutes(10), function () use ($request) {
                return $this->product->index($request);
            });

            if (isset($request->best_seller)) {
                return view('frontend.homepage.sellers-tab', compact('products'));
            } elseif (isset($request->featured)) {
                return view('frontend.homepage.featured-tab', compact('products'));
            } elseif (isset($request->offred)) {
                return view('frontend.homepage.offred-tab', compact('products'));
            } elseif (isset($request->on_sale_product)) {
                
                $products = Cache::remember('on_sale_products_', (36000 * 10), function () use ($request) {
                    return $this->product->index($request);
                });

                return view('frontend.homepage.on-sale-tab-tab', compact('products'));

            } elseif (isset($request->trending)) {
                
                $products = Cache::remember('trending_', (36000 * 10), function () use ($request) {
                    return $this->product->index($request);
                });

                return view('frontend.homepage.trending-tab', compact('products'));

            } elseif (isset($request->is_featured_list)) {
                $products = Cache::remember('featured_products_', (36000 * 10), function () use ($request) {
                    return $this->product->index($request);
                });

                return view('frontend.homepage.featured-list-tab', compact('products'));
            } elseif (isset($request->top_rated_product)) {
                $products = Cache::remember('top_rated_product', (36000 * 10), function () use ($request) {
                    return $this->product->index($request);
                });

                return view('frontend.homepage.top_rated_product_tab', compact('products'));
            }  elseif (isset($request->brands)) {

                $brands = Cache::remember('brands_', (36000 * 10), function () use ($request) {
                    return $this->brands->getAllBrands()->select('slug', 'logo', 'name', 'status')->where('status', 1);
                });

                return view('frontend.homepage.brands-tab', compact('brands'));
            }



            if (isset($request->mid_banners)) {
                $midBanners = Cache::remember('mid_banners', now()->addMinutes(300), function () {
                    $data = $this->banner->getAllBanners();

                    return $data->where('status', 1)
                        ->groupBy('banner_type')
                        ->filter(function ($group, $key) {
                            if ($key === 'mid' && $group->count() >= 3) {
                                return $group->shuffle()->take(3);
                            }
                        });
                });

                return response()->json(['success' => true, 'data' => $midBanners]);
            }


            // Not Implemented Yet
            if (isset($request->flash_deals)) {
                $flashDeals = $this->flashDeals();
                return view('frontend.homepage.falsh_deals-tab',compact('flashDeals'));
            }
        }

        $newProducts = Cache::remember('newProducts', now()->addMinutes(10), function () {

            return $this->product->index(null);
        });


        return view('frontend.homepage.index', compact('banners', 'newProducts'));
    }

    public function quickview($slug)
    {
        $product = Cache::remember($slug, now()->addMinutes(10), function () use ($slug) {
            return $this->product->quickview($slug);
        });
        return view('frontend.modals.quick-view', compact('product'));
    }

    private function flashDeals()
    {

        return Cache::remember('flashDeals', now()->addMinutes(2), function () {

            $deals = $this->flashDeals->getAllDeals();

            $now = Carbon::now();

            if ($deals->isNotEmpty()) {
                return $deals->filter(function ($deal) use ($now) {
                    if ($deal->status != 1 || $deal->type->isEmpty()) {
                        return false;
                    }

                    $startingTime = get_system_date($deal->starting_time);
                    $endTime = null;

                    // Calculate end time based on deadline_type
                    switch ($deal->deadline_type) {
                        case 'day':
                            $endTime = Carbon::parse($startingTime)->addDays($deal->deadline_time);
                            break;
                        case 'hour':
                            $endTime = Carbon::parse($startingTime)->addHours($deal->deadline_time);
                            break;
                        case 'minute':
                            $endTime = Carbon::parse($startingTime)->addMinutes($deal->deadline_time);
                            break;
                        case 'week':
                            $endTime = Carbon::parse($startingTime)->addWeeks($deal->deadline_time);
                            break;
                        case 'month':
                            $endTime = Carbon::parse($startingTime)->addMonths($deal->deadline_time);
                            break;
                        default:
                            break;
                    }

                    $deal->end_time = $endTime ? $endTime->toDateTimeString() : null;

                    return $endTime && $endTime->isFuture();
                })->map(function ($deal) {

                    $dealTypes = $deal->type()->select('id', 'product_id')->get();

                    $productDetails = $dealTypes->map(function ($type) {
                        $product = $type->product()
                            ->with(['details' => function ($query) {
                                $query->select('product_id', 'current_stock', 'number_of_sale'); 
                            }])
                            ->select('id', 'thumb_image','name', 'slug', 'unit_price', 'discount_type', 'discount')
                            ->first();

                        $discountedPrice = $product ? $product->unit_price : 0;

                        if ($product && $product->discount_type && $product->discount > 0) {
                            $discountAmount = $product->discount_type == 'amount'
                                ? $product->discount
                                : ($product->unit_price * ($product->discount / 100));
                            $discountedPrice = $product->unit_price - $discountAmount;
                        }

                        $currentStock = $product && $product->details ? $product->details->current_stock : 0;
                        $numberOfSale = $product && $product->details ? $product->details->number_of_sale : 0;

                        return [
                            'id' => $product ? $product->id : null,
                            'name' => $product ? $product->name : null,
                            'thumb_image' => $product ? $product->thumb_image : null,
                            'slug' => $product ? $product->slug : null,
                            'unit_price' => $product ? format_price(convert_price($product->unit_price)) : null,
                            'discounted_price' => format_price(convert_price($discountedPrice)),
                            'current_stock' => $currentStock,
                            'number_of_sale' => $numberOfSale,
                        ];
                    });


                    $deal->starting_time = get_system_date($deal->starting_time);
                    $deal->product_details = $productDetails;

                    return [
                        'id' => $deal->id,
                        'title' => $deal->title,
                        'slug' => $deal->slug,
                        'image' => $deal->image,
                        'starting_time' => $deal->starting_time,
                        'end_time' => $deal->end_time,
                        'product_details' => $productDetails
                    ]; 
                });
            }
        });
    }

    public function submitQuestionForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'product' => 'nullable|string',
            'message' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::where('slug', $request->product)->where('status', 1)->first();
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        ProductQuestion::create([
            'product_id' => $product->id,
            'user_id' => Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null,
            'name' => $request->name,
            'message' => $request->message
        ]);

        return response()->json(['status' => true, 'message' => 'Question Submitted Successfully', 'load' => true]);
    }

    public function submitReviewForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'product' => 'nullable|string',
            'message' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->rating < 1) {
            return response()->json(['status' => false, 'message' => 'Please add a rating first.']);
        }

        $product = Product::where('slug', $request->product)->where('status', 1)->first();
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        // add to rating table
        $rating = Rating::create([
            'product_id' => $product->id,
            'user_id' => Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review' => $request->message
        ]);

        if ($rating) {
            $numberOfRating = Rating::where('product_id', $product->id)->count();
            $newNumberOfRating = $numberOfRating;

            $averageRating = (Rating::where('product_id', $product->id)->sum('rating') / $numberOfRating);

            $details = ProductDetail::where('product_id', $product->id)->first();
            $details->number_of_rating = $newNumberOfRating;
            $details->average_rating = $averageRating;
            $details->save();
        }

        return response()->json(['status' => true, 'message' => 'Review Submitted Successfully', 'load' => true]);
    }

    public function addToCompareList(Request $request)
    {
        $productId = $request->id;
        $compareList = session()->get('compare_list', []);

        if (!in_array($productId, $compareList)) {

            $product = Product::where('slug', $productId)->first();
            if($product) {
                $compareList[] = $product->id;
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found.',
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => 'This product is already added to your compare list.',
            ]);
        }

        if (count($compareList) > 3) {
            return response()->json([
                'status' => false,
                'message' => 'You can not add more then 3 product at a time.',
            ]);
        }

        session()->put('compare_list', $compareList);

        $counter = count($compareList);

        return response()->json([
            'status' => true,
            'counter' => $counter,
            'message' => 'Product added to compare list successfully.',
        ]);
    }

    public function addToWishList(Request $request)
    {
        $productId = $request->id;

        if (!Auth::guard('customer')->check()) {
            return response()->json(['status' => false, 'message' => 'You must login or create an account to save products on your wishlist.']);
        }

        $userId = Auth::guard('customer')->user()->id;

        if (WishList::where('user_id', $userId)->where('product_id', $productId)->first()) {
            return response()->json(['status' => false, 'message' => 'This product is already added to your wishlist.']);
        }

        WishList::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json(['status' => true, 'message' => 'Successfully added to your Wishlist.']);
    }

    public function currencyChange(Request $request)
    {
        $country = Country::find($request->global_country_id);
        $currency = Currency::find($request->global_currency_id);

        // For Currency
        $request->session()->put('currency_id', $currency->id);
        $request->session()->put('currency_code', $currency->code);
        $request->session()->put('currency_symbol', $currency->symbol);
        $request->session()->put('currency_exchange_rate', $currency->exchange_rate);

        // for country
        $request->session()->put('user_country', $country->name);
        $request->session()->put('country_flag', asset($country->image));

        session()->flash('success', 'Country changed to ' . $country->name . ' and Currency changed to ' . $currency->name);
    }

    public function allCategories()
    {
        $categories = Category::where('status', 1)->where('parent_id', null)->orderBy('name', 'ASC')->get();
        return view('frontend.categories', compact('categories'));
    }

    public function allBrands()
    {
        $brands = $this->brands
            ->getAllBrands()
            ->where('status', 1);

        return view('frontend.brands', compact('brands'));
    }

    public function postNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->email;

        if(Subscriber::where('email', $email)->first()) {
            return response()->json(['status' => false, 'message' => 'You are already subscribed']);
        } 

        Subscriber::create([
            'email' => $email
        ]);

        return response()->json(['status' => true, 'message' => 'Thank you for subscribe']);
    }

    public function couponCheck(Request $request)
    {

        $data['coupon_code'] = $request->coupon;
        return $this->couponRepository->checkCoupon($data);

    }
}
