@if ($message = Session::get('success'))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm" role="alert">
            <p class="font-bold">Whoops! Something went wrong.</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif