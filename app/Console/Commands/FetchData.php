<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Categories;
use App\Models\Stores;
use App\Models\Marketplaces;
use App\Models\Notes;
use App\Models\ProductListings;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Issues;
use Illuminate\Support\Str;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = env('API_URL');
        $apiUsername = env('API_USERNAME');
        $apiPassword = env('API_PASSWORD');

        $allData = $this->allData($apiUrl, $apiUsername, $apiPassword);
        $this->fetchCategories($allData);
        $this->fetchStore($allData);
        $this->fetchMarketplace($allData);
        $this->fetchProducts($allData);
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

        echo "Tüm veriler API'den çekildi.\n";
        return $allData;
    }

    /**
     * Fetch categories from API and save them to database
     * param array $allData
     * return void
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

        echo "Tüm kategoriler database'e eklendi.\n";
    }

    /**
     * Fetch stores from API and save them to database
     * param array $allData
     * return void
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

        echo "Tüm mağazalar database'e eklendi.\n";
    }

    /**
     * Fetch products from API and save them to database
     * param array $allData
     * return void
     */
    public function fetchProducts($allData)
    {
        try {
            foreach ($allData as $product) {
                $findProduct = Products::find($product['product_id']);

                if (!$findProduct) {
                    $product = Products::updateOrCreate(
                        [
                            'id' => $product['product_id'],
                            'category_id' => $product['as_category_id'],
                            'slug' => Str::slug($product['listing_title']['value'] ?? $product['product_id'].'-'.$product['sku']),
                            'name' => $product['listing_title']['value'] ?? null,
                            'sku' => $product['sku'],
                            'store_id' => $product['store_id'],
                            'marketplace_id' => $product['marketplace_id'],
                            'marketplace_category' => $product['marketplace_category'],
                            'marketplace_qty' => $product['marketplace_qty_value'],
                            'marketplace_price' => $product['marketplace_price_value'],
                            'marketplace_sale_price' => $product['marketplace_sale_price_value'],
                            'marketplace_listing_number' => $product['marketplace_listing_number'],
                            'marketplace_status' => $product['marketplace_status'],
                            'marketplace_handling' => $product['marketplace_handling'],
                            'has_offers' => $product['has_offers'],
                            'is_linked' => $product['is_linked'],
                            'is_on_sale' => $product['is_on_sale'],
                            'asin' => $product['asin'],
                            'publish_status' => $product['publish_status'],
                            'item_page_url' => $product['item_page_url'],
                            'currency' => $product['currency'],
                            'currency_smybol' => $product['currency_smybol'],
                        ],
                    );

                    $productID = $product->id;

                    $this->fetchNotes($allData, $productID);
                    $this->fetchProductListings($allData, $productID);
                    $this->fetchProductImages($allData, $productID);
                    $this->fetchProductIssues($allData, $productID);
                }
            }
        } catch (\Exception $e) {
            echo "Hata: " . $e->getMessage() . "\n";
        }

        echo "Tüm ürünler database'e eklendi.\n";
    }

    /**
     * Fetch marketplaces from API and save them to database
     * param array $allData
     * return void
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

        echo "Tüm marketplaces database'e eklendi.\n";
    }

    /**
     * Fetch notes from API and save them to database
     * param array $allData
     * return void
     */
    public function fetchNotes($allData, $product)
    {
        foreach ($allData as $note) {
            if ($note['product_id'] == $product && $note['notes']) {
                $selectedNotes[] = Notes::updateOrCreate(
                    [
                        'product_id' => $product,
                        'type' => 0,
                        'note' => $note['notes'],
                    ],
                );

                if ($note['internal_notes'] != null) {
                    $selectedNotes[] = Notes::updateOrCreate(
                        [
                            'product_id' => $product,
                            'type' => 1,
                            'note' => $note['internal_notes'],
                        ],
                    );
                }
            }
        }
    }

    /**
     * Fetch product listings from API and save them to database
     * param array $allData
     * return void
     */
    public function fetchProductListings($allData, $product)
    {
        foreach ($allData as $productListing) {
            if ($productListing['product_id'] == $product) {
                $selectedProductListings[] = ProductListings::updateOrCreate([
                    'product_id' => $product,
                    'quantity' => $productListing['listing_quantity'],
                    'price' => $productListing['listing_price'],
                    'handling' => $productListing['listing_handling'],
                    'sale_price' => $productListing['listing_sale_price'],
                    'title' => $productListing['listing_title']['value'] ?? null,
                    'barcode' => $productListing['listing_barcode']['value'] ?? null,
                    'f_channel' => $productListing['listing_f_channel']['value'] ?? null,
                    'browse_node' => $productListing['listing_browse_node']['value'] ?? null,
                ]);
                break;
            }
        }

    }

    /**
     * Fetch product images from API and save them to database
     * param array $allData
     * return void
     */
    public function fetchProductImages($allData, $product)
    {
        foreach ($allData as $productImage) {
            if ($productImage['product_id'] == $product) {
                $selectedProductImages[] = ProductImages::updateOrCreate([
                    'product_id' => $product,
                    'image_url' => $productImage['main_image_url'],
                ]);
            }
        }
    }

    /**
     * Fetch product issues from API and save them to database
     * param array $allData
     * return void
     */
    public function fetchProductIssues($allData, $product)
    {
        foreach ($allData as $productIssue) {
            if ($productIssue['product_id'] == $product && $productIssue['listing_issues']) {
                $selectedProductIssues[] = Issues::firstOrCreate([
                    'product_id' => $product,
                    'details' => $productIssue['listing_issues'][0]['issue_details'],
                    'status' => $productIssue['listing_issues'][0]['severity'],
                    'date' => $productIssue['listing_issues'][0]['created_at'],
                ]);
            }
        }
    }
}
