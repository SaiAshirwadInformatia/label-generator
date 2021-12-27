@foreach(config('sai.fonts') as $font)
    @foreach($font['weight'] as $weight)
    .{{ $font['name'].'-'.strtolower($weight) }} {
        
    }
    @endforeach
@endforeach