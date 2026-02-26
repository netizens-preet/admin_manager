<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('category.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Create Category') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($message = Session::get('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-3 px-4 text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">ID</th>
                                    <th class="py-3 px-4 text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Name</th>
                                    <th class="py-3 px-4 text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Description</th>
                                    <th class="py-3 px-4 text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="py-4 px-4 text-sm font-medium">{{ $category->id }}</td>
                                        <td class="py-4 px-4 text-sm font-semibold">{{ $category->name }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($category->description, 50) }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-right space-x-2">
                                            <a href="{{ route('category.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold uppercase text-xs">
                                                Edit
                                            </a>
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-bold uppercase text-xs" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
