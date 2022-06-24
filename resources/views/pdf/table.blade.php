<style>
    @page { margin: 8px; }
    body { margin: 0px; }
    .table {
        margin: 8px auto 60px auto;
        width: 99%;
        max-width: 99%;
        border-collapse: collapse;
    }

    .table td p {
        border-bottom: 1px solid #000000;
        margin: 0;
        padding: 1px 0 3px;
    }

    .table td p:last-child {
        border-bottom: none;
    }

    .table td p strong {
        margin-left: 3px;
        margin-top: 2px;
        display: inline-block;
        width: {{ $set->header_width }}%;
    }

    .table td {
        width: {{ floor(100 / intval($set->label->settings['column_nos'])) }}%;
        max-width: {{ floor(100 / intval($set->label->settings['column_nos'])) }}%;
        border: 1px solid #000000;
        border-right: 2px;
    }

    .table td {
        border-bottom: 2px solid #000000;
    }

    .table th {
        text-align: left;
    }

    .page-break {
        page-break-after: always;
    }

    @include('pdf.fonts')

</style>
@foreach($tables as $tableRows)
<div class="display: block;width: 100%">
<table class="table">
    @foreach (array_chunk($tableRows, intval($set->label->settings['column_nos'])) as $records)
        <tr>
            @foreach ($records as $index => $record)
                <td>
                    @foreach ($set->fields()->orderBy('sequence')->get() as $field)
                        @if($field->type == 'EmptyRow')
                        <p>
                            <strong style="{{ $field->headerCss }};font-size: {{ $set->header_font }}px">&nbsp;</strong>
                            <strong style="{{ $field->css }}">&nbsp;</strong>
                        </p>
                        @else
                        <p>
                            <strong style="{{ $field->headerCss }};font-size: {{ $set->header_font }}px">{{ $field->display_name }}</strong>
                            <span style="{{ $field->css }}">{!! $record[$field->name] !!}</span>
                        </p>
                        @endif
                    @endforeach
                </td>
                @if($loop->index == 0 && $loop->last)
                <td></td>
                <td></td>
                @elseif($loop->index == 1 && $loop->last)
                <td></td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>
</div>
@if(!$loop->last)
{{--<div class="page-break"></div>--}}
<div style="margin-bottom: 60px"></div>
@endif
@endforeach
