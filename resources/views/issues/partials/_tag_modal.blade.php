<div id="issue-tags"
     data-attach-url="{{ url('/issues/'.$issue->id.'/tags') }}"
     data-detach-url="{{ url('/issues/'.$issue->id.'/tags') }}">
    <div class="mb-3 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Tags</h2>
        <button type="button" id="open-tag-modal"
                class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Manage Tags
        </button>
    </div>

    <div id="issue-tags-list" class="flex flex-wrap gap-2">
        @forelse ($issue->tags as $tag)
            <span class="issue-tag inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium text-white"
                  data-tag-id="{{ $tag->id }}"
                  style="background-color: {{ $tag->displayColor() }}">
                {{ $tag->name }}
            </span>
        @empty
            <p id="issue-tags-empty" class="text-sm text-slate-500">No tags attached yet.</p>
        @endforelse
    </div>
</div>

<div id="issue-members"
     data-attach-url="{{ url('/issues/'.$issue->id.'/users') }}"
     data-detach-url="{{ url('/issues/'.$issue->id.'/users') }}">
    <div class="mb-3 mt-8 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Assigned Members</h2>
        <button type="button" id="open-members-modal"
                class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Manage Members
        </button>
    </div>

    <div id="issue-members-list" class="flex flex-wrap gap-2">
        @forelse ($issue->users as $user)
            <span class="issue-member inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-800"
                  data-user-id="{{ $user->id }}">
                {{ $user->name }}
            </span>
        @empty
            <p id="issue-members-empty" class="text-sm text-slate-500">No members assigned yet.</p>
        @endforelse
    </div>
</div>

@push('modals')
    <div id="tag-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4" aria-hidden="true">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Manage Tags</h3>
                <button type="button" id="close-tag-modal" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <ul id="tag-modal-list" class="max-h-64 space-y-2 overflow-y-auto">
                @foreach ($tags as $tag)
                    @php $attached = $issue->tags->contains('id', $tag->id); @endphp
                    <li class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2"
                        data-tag-id="{{ $tag->id }}">
                        <span class="inline-flex items-center gap-2 text-sm">
                            <span class="h-3 w-3 rounded-full" style="background-color: {{ $tag->displayColor() }}"></span>
                            {{ $tag->name }}
                        </span>
                        <button type="button"
                                class="tag-toggle rounded-md px-2 py-1 text-xs font-medium {{ $attached ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200' }}"
                                data-attached="{{ $attached ? '1' : '0' }}"
                                data-tag-id="{{ $tag->id }}">
                            {{ $attached ? 'Detach' : 'Attach' }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <p id="tag-error-generic" class="mt-3 hidden text-sm text-red-600"></p>
        </div>
    </div>

    <div id="members-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4" aria-hidden="true">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Manage Members</h3>
                <button type="button" id="close-members-modal" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            <ul id="members-modal-list" class="max-h-64 space-y-2 overflow-y-auto">
                @foreach ($users as $user)
                    @php $assigned = $issue->users->contains('id', $user->id); @endphp
                    <li class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2"
                        data-user-id="{{ $user->id }}">
                        <span class="text-sm text-slate-800">{{ $user->name }}</span>
                        <button type="button"
                                class="member-toggle rounded-md px-2 py-1 text-xs font-medium {{ $assigned ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200' }}"
                                data-assigned="{{ $assigned ? '1' : '0' }}"
                                data-user-id="{{ $user->id }}">
                            {{ $assigned ? 'Unassign' : 'Assign' }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <p id="members-error-generic" class="mt-3 hidden text-sm text-red-600"></p>
        </div>
    </div>
@endpush
