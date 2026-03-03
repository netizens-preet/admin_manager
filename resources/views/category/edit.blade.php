<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700">
                <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Category Name')"
                            class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <x-text-input id="name" name="name" type="text"
                            class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                            :value="old('name', $category->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')"
                            class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <textarea id="description" name="description" rows="5"
                            class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">{{ old('description', $category->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('category.index') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                            Cancel
                        </a>
                        <x-primary-button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg font-bold uppercase tracking-widest transition">
                            {{ __('Update Category') }}
                        </x-primary-button>

                        <a href="{{ route('category.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>