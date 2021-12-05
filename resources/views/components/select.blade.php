@props(['options'])

<select {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    @foreach($options as $key => $value)
    <option value="{{ $key }}">{{ ucfirst($value) }}</option>
    @endforeach
</select>
