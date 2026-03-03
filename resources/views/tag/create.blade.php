<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-bold mb-8 text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-3">Create New Tag</h2>

                <form action="{{ route('tag.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Tag Name')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <x-text-input id="name" name="name" type="text" class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500" :value="old('name')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('tag.index') }}"
                            class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">Cancel</a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg font-bold uppercase tracking-widest transition">Create Tag</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>