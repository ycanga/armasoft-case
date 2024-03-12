<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Stores;
use App\Models\Marketplaces;
use App\Models\Products;
use Illuminate\Support\Str;
use App\Models\Currencies;
use App\Models\MarketplaceDetails;


class FetchProductsController extends Controller
{
    private $apiUrl;
    private $apiUsername;
    private $apiPassword;

    /**
     * FetchData constructor.
     */
    public function __construct()
    {
        $this->apiUrl = env('API_URL');
        $this->apiUsername = env('API_USERNAME');
        $this->apiPassword = env('API_PASSWORD');
    }

    /**
     * Execute the console command.
     */
    public function index()
    {
        $allData = $this->allData($this->apiUrl, $this->apiUsername, $this->apiPassword);
        $this->fetchCategories($allData);
        $this->fetchStore($allData);
        $this->fetchMarketplace($allData);
        $this->fetchProducts($allData);

        return response()->json([
            'status' => 200,
            'message' => 'Data fetched successfully',
        ]);
    }

    /**
     * Fetch all data from API
     * param string $apiUrl
     * param string $apiUsername
     * param string $apiPassword
     * return array
     */
    public function allData($apiUrl, $apiUsername, $apiPassword)
    {
        $client = new \GuzzleHttp\Client();
        $page = 1;
        $allData = [];

        do {
            $response = $client->request('GET', $apiUrl . "?page=" . $page, [
                'auth' => [$apiUsername, $apiPassword]
            ]);

            $data = json_decode($response->getBody(), true);
            $allData = array_merge($allData, $data['data']);

            $page++;
        } while (!empty($data['next_page_url']));

        return $allData;
    }

    /**
     * Fetch categories from API
     * param array $allData
     */
    public function fetchCategories($allData)
    {
        foreach ($allData as $category) {
            if ($category['as_category_id'] != null && $category['as_category_name'] != null) {
                $selectedCategories[] = Categories::firstOrCreate(
                    [
                        'id' => $category['as_category_id'],
                        'name' => $category['as_category_name'],
                    ],
                );
            }
        }
    }

    /**
     * Fetch stores from API
     * param array $allData
     */
    public function fetchStore($allData)
    {
        foreach ($allData as $store) {
            $selectedStores[] = Stores::updateOrCreate(
                [
                    'id' => $store['store_id'],
                    'name' => $store['store_name'],
                    'country' => $store['store_country'],
                ],
            );
        }
    }

    /**
     * Fetch marketplaces from API
     * param array $allData
     */
    public function fetchMarketplace($allData)
    {
        foreach ($allData as $marketplace) {
            $selectedMarketplaces[] = Marketplaces::updateOrCreate(
                [
                    'id' => $marketplace['marketplace_id'],
                    'name' => $marketplace['marketplace_name'],
                ],
            );
        }
    }

    /**
     * Fetch products from API
     * param array $allData
     */
    public function fetchProducts($allData)
    {
        try {
            foreach ($allData as $product) {
                $findProduct = Products::find($product['product_id']);

                if (!$findProduct) {
                    $currency = Currencies::updateOrCreate([
                        'currency' => $product['currency'],
                        'symbol' => $product['currency_smybol'],
                    ]);

                    $marketplaceDetails = MarketplaceDetails::updateOrCreate([
                        'marketplace_category' => $product['marketplace_category'],
                        'marketplace_qty' => $product['marketplace_qty_value'],
                        'marketplace_price' => $product['marketplace_price_value'],
                        'marketplace_sale_price' => $product['marketplace_sale_price_value'],
                        'marketplace_listing_number' => $product['marketplace_listing_number'],
                        'marketplace_handling' => $product['marketplace_handling'],
                        'marketplace_status' => $product['marketplace_status'],
                    ]);

                    $productData = Products::updateOrCreate(
                        [
                            'id' => $product['product_id'],
                            'category_id' => $product['as_category_id'],
                            'slug' => Str::slug($product['listing_title']['value'] ?? $product['product_id'] . '-' . $product['sku']),
                            'name' => $product['listing_title']['value'] ?? null,
                            'sku' => $product['sku'],
                            'store_id' => $product['store_id'],
                            'marketplace_id' => $product['marketplace_id'],
                            'marketplace_details_id' => $marketplaceDetails->id,
                            // 'marketplace_category' => $product['marketplace_category'],
                            // 'marketplace_qty' => $product['marketplace_qty_value'],
                            // 'marketplace_price' => $product['marketplace_price_value'],
                            // 'marketplace_sale_price' => $product['marketplace_sale_price_value'],
                            // 'marketplace_listing_number' => $product['marketplace_listing_number'],
                            // 'marketplace_status' => $product['marketplace_status'],
                            // 'marketplace_handling' => $product['marketplace_handling'],
                            'has_offers' => $product['has_offers'],
                            'is_linked' => $product['is_linked'],
                            'is_on_sale' => $product['is_on_sale'],
                            'asin' => $product['asin'],
                            'publish_status' => $product['publish_status'],
                            'item_page_url' => $product['item_page_url'],
                            'currency' => $currency->id,
                        ],
                    );


                    $productID = $productData->id;

                    $fetchFunctions = new FetchFunctions();
                    $fetchFunctions->fetchNotes($allData, $productID);
                    $fetchFunctions->fetchProductListings($allData, $productID);
                    $fetchFunctions->fetchProductImages($allData, $productID);
                    $fetchFunctions->fetchProductIssues($allData, $productID);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
