<footer class="py-16 overflow-hidden text-sm text-center text-gray-500 bg-white shadow-sm 0 dark:bg-gray-800">
    {{ $slot }}
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
</footer>
