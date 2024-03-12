<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\Issues;
use App\Models\ProductListings;
use App\Models\Notes;
use App\Models\Currencies;

class FetchFunctions extends Controller
{
    /**
     * Fetch notes from API
     * param array $allData
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
     * Fetch listings from API
     * param array $allData
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
     * Fetch images from API
     * param array $allData
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
     * Fetch issues from API
     * param array $allData
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

    // public function fetchCurrencies($allData)
    // {
    //     foreach ($allData as $currency) {
    //         $selectedCurrencies[] = Currencies::updateOrCreate([
    //             'currency' => $currency['currency'],
    //             'symbol' => $currency['currency_smybol'],
    //         ]);
    //     }
    // }
}
