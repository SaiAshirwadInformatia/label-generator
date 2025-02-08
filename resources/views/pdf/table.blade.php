<style>
    @page { margin: 5px; }
    body { margin: 0px; font-family: Roboto; }
    .table {
        margin: 0px auto 0px auto;
        width: 99%;
        max-width: 99%;
        border-collapse: collapse;
    }

    .table td p {
        border-bottom: 1px solid #000000;
        margin: 0;
        padding: 5px 0 5px 0;
    }

    .table td p:last-child {
        border-bottom: none;
    }

    .table td p, .table td p span {
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal; /* Avoids text spilling out */
    }


    .table td p strong {
        margin-left: 3px;
        margin-top: 2px;
        display: inline-block;
        width: {{ $set->header_width }}%;
        vertical-align: top;
    }

    .table td p span {
        display: inline-block;
        width: {{ 100 - $set->header_width - 2 }}%;
        vertical-align: top;
    }

    .table td {
        width: {{ floor(100 / intval($set->label->settings['column_nos'])) - 5 }}%;
        max-width: {{ floor(100 / intval($set->label->settings['column_nos'])) - 5 }}%;
        border: 1px solid #000000;
        border-right: 2px;
        vertical-align: top;
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
                    @if($set->settings['fragile'] ?? false)
                    <p style="padding: 15px 0;font-size: 1.8rem;text-align: center">FRAGILE ITEMS | HANDLE WITH CARE</p>
                    @endif
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
                    @if($set->settings['fragile'] ?? false)
                        <p style="padding: 15px 0;font-size: 1.8rem;text-align: center">FRAGILE ITEMS | HANDLE WITH CARE</p>
                    @endif
                </td>
                @if($set->label->settings['column_nos'] > 1 && $loop->index == 0 && $loop->last)
                    <td style="visibility: hidden;"></td>
                @if($set->label->settings['column_nos'] >= 3)
                    <td style="visibility: hidden;"></td>
                @endif
                @if($set->label->settings['column_nos'] == 4)
                    <td style="visibility: hidden;"></td>
                @endif
                @elseif($loop->index == 1 && $loop->last && $set->label->settings['column_nos'] > 2)
                    <td style="visibility: hidden;"></td>
                @if($set->label->settings['column_nos'] == 4)
                    <td style="visibility: hidden;"></td>
                @endif
                @elseif($loop->index == 2 && $loop->last && $set->label->settings['column_nos'] > 3)
                    <td></td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>
</div>
@if(!$loop->last)
{{--<div class="page-break"></div>--}}
<div style="margin-bottom: 10px"></div>
@endif
@endforeach
