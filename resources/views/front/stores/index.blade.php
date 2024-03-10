@extends('layouts.app')
@section('title', 'Stores')
@section('head-text')
    <h1 class="font-bold text-xl border-b-2 border-dashed p-1 text-center">
        Tüm Storelar
    </h1>
@endsection
@section('content')
    <div class="p-4 sm:ml-64">
        <div
            class="pl-20 pr-20 pb-5 pt-5 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-5 flex justify-center">
            <table class="table-auto border" id="stores-table">
                <thead>
                    <tr>
                        <th class="border p-3">Store Adı</th>
                        <th class="border">Store Country</th>
                        <th class="border">Oluşturma Tarihi</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @foreach ($stores as $store)
                        <tr class="p-3">
                            <td class="text-sm">
                                {{ $store->name }}
                            </td>
                            <td class="text-sm">
                                {{ $store->country }}
                            </td>
                            <td class="text-sm text-lime-500">
                                {{ \Carbon\Carbon::parse($store->created_at)->locale('tr')->diffForHumans() }}
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
            let table = new DataTable('#stores-table');
        });
    </script>
@endsection
