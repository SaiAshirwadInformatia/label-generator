<table>
    @foreach (array_chunk($tableRows, $set->label->settings['column_nos']) as $records)
        <tr>
            @foreach ($records as $record)
                <td>
                    <table>
                        @foreach ($set->fields as $index => $field)
                            <tr>
                                <th>{{ $field->display_name }}</th>
                                <td>{{ $index }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>
