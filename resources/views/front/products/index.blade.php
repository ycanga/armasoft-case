@extends('layouts.app')
@section('title', 'Products')
@section('head-text')
<h1 class="font-bold text-xl border-b-2 border-dashed p-1 text-center">
    Tüm Ürünler
</h1>
@endsection
@section('content')
    <div class="p-4 sm:ml-64">
        <div
            class="pl-20 pr-20 pb-5 pt-5 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-5 flex justify-center">
            <table class="table-auto border" id="product-table">
                <thead>
                    <tr>
                        <th class="border p-3" data-orderable="false">Resim</th>
                        <th class="border">SKU</th>
                        <th class="border">İsim</th>
                        <th class="border">Kategori</th>
                        <th class="border">Asin</th>
                        <th class="border">Price</th>
                        <th class="border" data-orderable="false">İşlem</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @foreach ($products as $product)
                        <tr class="p-3">
                            <td>
                                <img src="{{ optional($product->images->first())->image_url }}" alt="{{ $product->name }}"
                                    class="w-20 h-20">
                            </td>
                            <td class="text-sm">
                                {{ $product->sku }}
                            </td>
                            <td class="text-sm">
                                {{ $product->name }}
                            </td>
                            <td>
                                {{ optional($product->category->first())->name }}
                            </td>
                            <td class="text-sm font-bold">
                                {{ $product->asin }}
                            </td>
                            <td class="text-lime-500">
                                {{ ($product->marketplace_price) ?? "-" }} {{ $product->currency_smybol }}
                            </td>
                            <td>
                                <a href="{{ route('front.products.show',  $product->slug) }}" class="outline outline-2 outline-offset-2 bg-blue-500 text-white p-2">Detay</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let table = new DataTable('#product-table');
        });
    </script>
@endsection
