@props(['options'])

<select {!! $attributes->merge(['class' => 'select']) !!}>
    <option value="">Select</option>
    @foreach($options as $key => $value)
    <option value="{{ $key }}">{{ ucfirst($value) }}</option>
    @endforeach
</select>
