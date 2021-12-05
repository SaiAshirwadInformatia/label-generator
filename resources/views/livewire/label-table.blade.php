<div>
    <div class="w-full bg-white bg-white shadow p-4 rounded-lg">
        @if ($labels->count() > 0)
            <div class="border-gray-200 border p-2">
                <table class="table-fixed">
                    <thead class="bg-gray-200">
                        <tr>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        <span class="text-xl">{{ $label->name }}</span>
                                    </div>
                                    <div class="flex mb-1">
                                        <div class="inline-flex shadow-md hover:shadow-lg focus:shadow-lg btn-group"
                                            role="group">
                                            <button type="button" class="btn-sm px-3">
                                                Sets <span
                                                    class="bg-blue-900 ml-1 px-1">{{ $label->sets_count }}</span>
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
            </div>
        @else
            <div class="w-full text-center mb-8">
                <h2>
                    Generate your first Label!
                    <a href="/labels/create" class="btn">
                        <span>
                            @include('icons.add')
                            Create Now
                        </span>
                    </a>
                </h2>
            </div>
            <div class="flex flex-nowrap">
                <div class="w-1/3 mx-auto">
                    @include("vectors.add")
                </div>
            </div>
        @endif
    </div>
</div>
