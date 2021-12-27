<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table td p {
        border-bottom: 1px solid #000000;
        margin: 0;
        padding: 0;
        padding-bottom: 3px;
        padding-top: 1px;
    }

    .table td p:last-child {
        border-bottom: none;
    }

    .table td p strong {
        margin-left: 3px;
        margin-top: 2px;
        display: inline-block;
        width: 35%;
    }

    .table td {
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
<table class="table">
    @foreach (array_chunk($tableRows, $set->label->settings['column_nos']) as $records)
        <tr>
            @foreach ($records as $record)
                <td>
                    @foreach ($set->fields as $index => $field)
                        <p>
                            <strong style="{{ $field->css() }}">{{ $field->display_name }}</strong>
                            <span style="{{ $field->css() }}">{{ $record[$index] }}</span>
                        </p>
                    @endforeach
                </td>
            @endforeach
        </tr>
    @endforeach
</table>
