@extends('layouts.app')

@section('title', 'Product Detail')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 flex justify-center">
            <section class="text-gray-700 body-font overflow-hidden bg-white p-5 text-sm">
                <div class="container px-5 pt-5 grid grid-cols-2 gap-4 content-center">
                    <!-- Resim -->
                    <div class="border-2 border-gray-200 border-dashed  content-start">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-96">
                    </div>

                    <!-- Diğer içerik -->
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 lg:mt-0 pl-5">
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">
                            {{ $product->category_name }}</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">The Catcher in the Rye</h1>
                        <ul class="leading-relaxed text-sm mt-3">
                            <li><strong>SKU:</strong> {{ $product->sku }}</li>
                            <li><strong>ASIN:</strong> {{ $product->asin ?? '-' }}</li>
                            <li><strong>MARKETPLACES:</strong> {{ $product->marketplace_name }}</li>
                            <li><strong>MARKETPLACE STATUS:</strong> {{ $product->marketplace_status ?? '-' }} </li>
                        </ul>

                        <div class="flex mt-6 items-center pb-5 border-b-2 border-dashed border-gray-200 mb-5">
                            <span class="title-font font-medium text-2xl text-lime-500">{{ $product->currency_symbol }}
                                {{ $product->marketplace_price ?? '---' }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @if ($product->issue_details)
            <div class="p-5">
                <div role="alert">
                    <div
                        class="@if ($product->issue_status == 'ERROR') bg-red-500 @else bg-orange-500 @endif text-white font-bold rounded-t px-4 py-2">
                        {{ $product->issue_status }}
                    </div>
                    <div
                        class="border border-t-0 @if ($product->issue_status == 'ERROR') border-red-400 bg-red-100 text-red-700 @else text-orange-500  border-orange-500 bg-orange-100 @endif  rounded-b  px-4 py-3 ">
                        <p>{{ $product->issue_details }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="details-tab" data-tabs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="false">Details</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="details" role="tabpanel"
                aria-labelledby="details-tab">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <strong>Store:</strong> {{ $product->store_name }} <br>
                    <strong>Marketplace Category:</strong> {{ $product->marketplace_category }} <br>
                    <strong>Marketplace Listing Number:</strong> {{ $product->marketplace_listing_number ?? "---" }} <br>
                    <strong>Marketplace Quantity:</strong> {{ $product->marketplace_qty ?? "---" }} <br>
                    <strong>Marketplace Handling:</strong> {{ $product->marketplace_handling ?? "---" }} <br>
                    <strong>Barcode: </strong> {{ $product->listing_barcode ?? "---" }} <br>
                    <strong>F-channel: </strong> {{ $product->listing_f_channel ?? "---" }} <br>
                    <strong>Browse Node: </strong> {{ $product->listing_browse_node ?? "---" }} <br>
                    @if ($product->item_page_url)
                        <strong>Item URL:</strong> <a href="{{ $product->item_page_url }}">{{ $product->item_page_url }} </a>
                    @endif
                </p>
            </div>
        </div>

    </div>
@endsection
