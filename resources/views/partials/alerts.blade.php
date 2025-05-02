{{-- Session Flash Messages --}}
@if (session('success'))
    <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-4 border border-green-200 dark:border-green-700">
        <div class="flex">
            <div class="flex-shrink-0">
                {{-- Optional: Heroicon solid/check-circle --}}
                <svg class="h-5 w-5 text-green-400 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-4 border border-red-200 dark:border-red-700">
        <div class="flex">
             <div class="flex-shrink-0">
                {{-- Optional: Heroicon solid/x-circle --}}
                 <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1