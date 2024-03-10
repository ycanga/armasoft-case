@extends('layouts.app')

@section('title', 'Dashboard')

@section('head-text')
<h1 class="font-bold text-xl border-b-2 border-dashed p-1 text-center">
    Hoş geldiniz...
</h1>
@endsection

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="rounded-lg dark:border-gray-700 mt-5 flex justify-center">
            <div class="container">
                <div class="grid grid-cols-4 gap-4">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg border-2 p-3">
                        <div class="">
                            <div class="font-bold text-xl mb-2 text-center">Toplam Ürün Sayısı</div>
                            <p class="text-lime-500 text-xl font-bold text-center">
                                {{ $products }}
                            </p>
                        </div>
                        <div class="text-center mt-5 mb-3">
                            <a href="{{ route('front.products.index') }}"
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Tüm
                                ürünler</a>
                        </div>
                    </div>
                    <div class="max-w-sm rounded overflow-hidden shadow-lg border-2 p-3">
                        <div class="">
                            <div class="font-bold text-xl mb-2 text-center">Toplam Kategori Sayısı</div>
                            <p class="text-lime-500 text-xl font-bold text-center">
                                {{ $categories }}
                            </p>
                        </div>
                        <div class="text-center mt-5 mb-3">
                            <a href="{{ route('front.products.index') }}"
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Tüm
                                kategoriler</a>
                        </div>
                    </div>
                    <div class="max-w-sm rounded overflow-hidden shadow-lg border-2 p-3">
                        <div class="">
                            <div class="font-bold text-xl mb-2 text-center">Toplam Marketplace Sayısı</div>
                            <p class="text-lime-500 text-xl font-bold text-center">
                                {{ $marketplaces }}
                            </p>
                        </div>
                        <div class="text-center mt-5 mb-3">
                            <a href="{{ route('front.products.index') }}"
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Tüm
                                marketplaceler</a>
                        </div>
                    </div>
                    <div class="max-w-sm rounded overflow-hidden shadow-lg border-2 p-3">
                        <div class="">
                            <div class="font-bold text-xl mb-2 text-center">Toplam Store Sayısı</div>
                            <p class="text-lime-500 text-xl font-bold text-center">
                                {{ $stores }}
                            </p>
                        </div>
                        <div class="text-center mt-5 mb-3">
                            <a href="{{ route('front.products.index') }}"
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Tüm
                                storelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
