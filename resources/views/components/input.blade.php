@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'p-2 disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 disabled:shadow-none rounded-md shadow-sm border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
