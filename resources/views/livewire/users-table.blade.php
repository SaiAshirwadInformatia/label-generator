<div>
    <div class="w-full bg-white bg-white shadow p-2 inline-block rounded-lg">
        <table class="table-auto">
            <thead class="bg-gray-200">
                <tr class="rounded-t-lg">
                    <th class="py-1 w-2/12">Name</th>
                    <th class="py-1 w-1/12">Email</th>
                    <th class="py-1 w-1/12">Company</th>
                    <th class="py-1 w-1/12">Email Verified</th>
                    <th class="py-1 w-2/12">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    {{-- <tr>
                                <td colspan="8">{{ json_encode($label) }}</td>
                            </tr> --}}
                    <tr class="hover:bg-gray-100">
                        <td class="p-2">
                            <div class="my-2">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                                    <x-icon.edit></x-icon.edit>
                                </a>
                                <a href="{{ route('activation.update', ['user' => $user->id]) }}">
                                    <x-icon.lock></x-icon.lock>
                                </a>
                                <a href="{{ route('impersonate', $user->id) }}">
                                    <x-icon.login></x-icon.login>
                                </a>
                                <span class="text-xl">{{ $user->name }}</span>
                                @if($user->id == auth()->user()->id)
                                <span class="font-thin">(You)</span>
                                @endif
                            </div>
                            <div class="flex mb-1">
                                <div class="inline-flex shadow-md hover:shadow-lg focus:shadow-lg btn-group"
                                    role="group">
                                    <button type="button" class="btn-sm px-3">
                                        Labels <span class="bg-blue-900 ml-1 px-1">{{ $user->labels_count }}</span>
                                    </button>
                                    <button type="button" class="btn-sm px-3">
                                        Sets <span class="bg-blue-900 ml-1 px-1">{{ $user->sets_count }}</span>
                                    </button>
                                    <button type="button" class="btn-sm px-3">
                                        Downloads <span
                                            class="bg-blue-900 ml-1 px-1">{{ $user->downloads_count }}</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="text-center text-sm">{!! $user->email !!}</td>
                        <td class="text-center text-sm">{!! $user->company !!}</td>
                        <td class="text-center text-sm">{{ $user->email_verified_at }}</td>
                        <td class="text-center text-sm">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>
