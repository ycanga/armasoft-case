@extends('layouts.app')
@section('title', 'Products')
@section('head-text')
    <h1 class="font-bold text-xl border-b-2 border-dashed p-1 text-center">
        Tüm Ürünler
    </h1>
@endsection
@section('content')
    <div class="p-4 sm:ml-64">
        <button @click="fetchProducts" id="fetch-products" :disabled="loading"
            class="outline outline-2 outline-offset-2 bg-blue-500 text-white p-2 mt-4">
            <span v-if="loading">Yükleniyor...</span>
            <span v-else>Tüm ürünleri yeniden çek</span>
        </button>

        <button @click="clearAllData" id="clear-data" :disabled="loading_clear"
            class="outline outline-2 outline-offset-2 bg-red-500 text-white p-2 mt-4">
            <span v-if="loading_clear">Yükleniyor...</span>
            <span v-else>Tüm Verileri Temizle</span>
        </button>

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
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-20 h-20">
                            </td>
                            <td class="text-sm">
                                {{ $product->sku }}
                            </td>
                            <td class="text-sm">
                                {{ $product->name }}
                            </td>
                            <td>
                                {{ $product->category_name }}
                            </td>
                            <td class="text-sm font-bold">
                                {{ $product->asin }}
                            </td>
                            <td class="text-lime-500">
                                {{ $product->currency_symbol }} {{ $product->marketplace_price ?? '-' }}
                            </td>
                            <td>
                                <a href="{{ route('front.products.show', $product->slug) }}"
                                    class="outline outline-2 outline-offset-2 bg-blue-500 text-white p-2">Detay</a>
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

    <script>
        var app = new Vue({
            el: '#fetch-products',
            data: {
                loading: false
            },
            methods: {
                fetchProducts() {
                    this.loading = true;
                    Swal.fire({
                        icon: 'info',
                        title: 'İşlem Devam Ediyor',
                        text: 'Bu işlem biraz zaman alabilir.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    fetch("{{ route('fetch-data') }}")
                        .then(response => response.json())
                        .then(data => {
                            this.loading = false;
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Tüm ürünler başarıyla çekildi.',
                                showConfirmButton: false,
                                timer: 1500,
                                didClose: () => {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.loading = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Ürünler çekilirken bir hata oluştu.',
                            });
                        });
                }
            }
        });
    </script>

    <script>
        var app = new Vue({
            el: '#clear-data',
            data: {
                loading_clear: false
            },
            methods: {
                clearAllData() {
                    this.loading_clear = true;
                    Swal.fire({
                        icon: 'info',
                        title: 'İşlem Devam Ediyor',
                        text: 'Bu işlem biraz zaman alabilir.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    fetch("{{ route('clear-data') }}")
                        .then(response => response.json())
                        .then(data => {
                            this.loading_clear = false;
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Tüm veriler başarıyla temizlendi.',
                                showConfirmButton: false,
                                timer: 1500,
                                didClose: () => {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.loading_clear = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Veriler temizlenirken bir hata oluştu.',
                            });
                        });
                }
            }
        });
    </script>
@endsection
