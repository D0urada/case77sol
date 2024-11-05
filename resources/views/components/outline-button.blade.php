@isset($default)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800']) }}>
		{{ $default }}
@endisset
@isset($dark)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800']) }}>
		{{ $dark }}
@endisset
@isset($green)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800']) }}>
		{{ $green }}
@endisset
@isset($red)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900']) }}>
		{{ $red }}
@endisset
@isset($yellow)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900']) }}>
		{{ $yellow }}
@endisset
@isset($purple)
	<button {{ $attributes->merge([ 'type' => 'button', 'class'=> 'text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900']) }}>
		{{ $purple }}
@endisset
	</button>





