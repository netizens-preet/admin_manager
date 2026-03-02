<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-6 dark:text-gray-100">Create New Tag</h2>

                <form action="{{ route('tag.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Tag Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('tag.index') }}"
                            class="px-4 py-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Cancel</a>
                        <x-primary-button>Create Tag</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>