@extends('layouts.app')
@section('title', 'Categories')
@section('head-text')
    <h1 class="font-bold text-xl border-b-2 border-dashed p-1 text-center">
        Tüm Kategoriler
    </h1>
@endsection
@section('content')
    <div class="p-4 sm:ml-64">
        <div
            class="pl-20 pr-20 pb-5 pt-5 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-5 flex justify-center">
            <table class="table-auto border" id="categories-table">
                <thead>
                    <tr>
                        <th class="border p-3">Kategori Adı</th>
                        <th class="border">Kategori Tipi</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @foreach ($categories as $category)
                        <tr class="p-3">
                            <td class="text-sm">
                                {{ $category->name }}
                            </td>
                            <td class="text-sm">
                                @if ($category->parent_id == null)
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Ana
                                        Kategori</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Alt
                                        Kategori</span>
                                @endif
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
            let table = new DataTable('#categories-table');
        });
    </script>
@endsection
