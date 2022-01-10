<div>
    <div class="w-full bg-white bg-white shadow p-2 inline-block rounded-lg">
        <table class="table-auto w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th>User</th>
                    <th>Event</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity_logs as $log)
                    <tr class="hover:bg-gray-100 p-2">
                        <td>{{ $log->causer?->name }}</td>
                        <td>{{ $log->event }}</td>
                        <td>{!! $this->subjectDisplay($log) !!}</td>
                        <td>{{ $log->description }}</td>
                        <td x-data="{ showProperties: false, properties: {{ $log->properties }}}">
                            <x-small-button @click="showProperties = true">
                                <x-icon.eye></x-icon.eye>
                            </x-small-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $activity_logs->links() }}
        </div>
    </div>
</div>
