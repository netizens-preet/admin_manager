<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $category->name }}
            </h2>
            <a href="{{ route('category.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded border dark:border-gray-700">
                <p class="text-sm text-gray-500 uppercase font-bold">Category Name</p>
                <p class="text-2xl font-bold">{{ $category->name }}</p>
            </div>

            <div class="flex justify-end pr-2">
                <a href="{{ route('category.edit', $category) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded font-bold text-sm hover:bg-indigo-700 transition shadow">
                    Edit Category
                </a>
            </div>
        </div>
    </div>
</x-app-layout>