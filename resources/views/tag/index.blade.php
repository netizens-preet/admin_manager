<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold dark:text-gray-200">Manage Tags</h2>
                <a href="{{ route('tag.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    + Add New Tag
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b dark:border-gray-700">
                                <th class="py-3 px-4 font-semibold uppercase text-sm">Name</th>
                                <th class="py-3 px-4 font-semibold uppercase text-sm">Slug</th>
                                <th class="py-3 px-4 font-semibold uppercase text-sm text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tags as $tag)
                                <tr
                                    class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="py-4 px-4">{{ $tag->name }}</td>
                                    <td class="py-4 px-4 text-gray-500 dark:text-gray-400 font-mono text-xs">
                                        {{ $tag->slug }}</td>
                                    <td class="py-4 px-4 text-right flex justify-end gap-2">
                                        <a href="{{ route('tag.edit', $tag) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                        <form action="{{ route('tag.destroy', $tag) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500">No tags found. Start by creating
                                        one!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>