<div>
    <div class="w-full bg-white bg-white shadow p-2 inline-block rounded-lg">
        @if ($labels->count() > 0)

            <table class="table-auto">
                <thead class="bg-gray-200">
                    <tr class="rounded-t-lg">
                        <th class="py-1 w-2/12">Name</th>
                        <th class="py-1 w-1/12">Started At</th>
                        <th class="py-1 w-1/12">Completed At</th>
                        <th class="py-1 w-2/12">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labels as $label)
                        {{-- <tr>
                                <td colspan="8">{{ json_encode($label) }}</td>
                            </tr> --}}
                        <tr class="hover:bg-gray-100">
                            <td class="p-2">
                                <div class="my-2">
                                    <a href="{{ route('labels.configure', ['label' => $label->id]) }}">
                                        <x-icon.cog></x-icon.cog>
                                    </a>
                                    <a href="#">
                                        <x-icon.download></x-icon.download>
                                    </a>
                                    <span class="text-xl">{{ $label->name }}</span>
                                </div>
                                <div class="flex mb-1">
                                    <div class="inline-flex shadow-md hover:shadow-lg focus:shadow-lg btn-group"
                                        role="group">
                                        <button type="button" class="btn-sm px-3">
                                            Sets <span class="bg-blue-900 ml-1 px-1">{{ $label->sets_count }}</span>
                                        </button>
                                        <button type="button" class="btn-sm px-3">
                                            Fields <span
                                                class="bg-blue-900 ml-1 px-1">{{ $label->fields_count }}</span>
                                        </button>
                                        <button type="button" class="btn-sm px-3">
                                            Downloads <span
                                                class="bg-blue-900 ml-1 px-1">{{ $label->downloads_count }}</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-sm">{!! $label->started_at ?? '<em>Not Started</em>' !!}</td>
                            <td class="text-center text-sm">{!! $label->completed_at ?? '<em>Not Completed</em>' !!}</td>
                            <td class="text-center text-sm">{{ $label->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $labels->links() }}
            </div>
        @else
            <div class="w-full text-center mb-0 pt-16">
                <h2>
                    Generate your first Label!
                    <a href="/labels/create" class="btn mx-4">
                        <span>
                            <x-icon.add></x-icon.cog>
                            Create Now
                        </span>
                    </a>
                </h2>
            </div>
            <div class="flex items-center">
                <div class="w-1/2 mx-auto">
                    @include("vectors.add")
                </div>
            </div>
        @endif
    </div>
</div>
