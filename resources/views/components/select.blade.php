@props(['options'])

<select {!! $attributes->merge(['class' => 'select']) !!}>
    @foreach($options as $key => $value)
    <option value="{{ $key }}">{{ ucfirst($value) }}</option>
    @endforeach
</select>
