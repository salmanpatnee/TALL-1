<div>
    @if(session()->has('message'))
        <div class=" flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Success</span>
            <div>
            {{session('message')}}
            </div>
        </div>
    @endif

    <div class="mt-5 text-right mt-5">
        <x-button class="mr-3" wire:click="confirmNoteSave()">
            Add a note
        </x-button>
    </div>
    <div class="relative overflow-x-auto p-5">
        <div class="flex w-full justify-between mb-5">
            <div>
                <input
                    type="search"
                    wire:model.live.debounce="s"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search"
                />
            </div>
            <div class="flex items-center">
                <input
                    id="active"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    wire:model.live="isActive"
                />
                <label
                    for="active"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >Active Records</label
                >
            </div>
        </div>
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">
                        <button wire:click="sort('body')">Note</button>
                        @if ($sortOrder == 'ASC' && $column == 'body')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 inline-block"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m4.5 15.75 7.5-7.5 7.5 7.5"
                            />
                        </svg>
                        @endif @if ($sortOrder == 'DESC' && $column == 'body')
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 inline-block"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m19.5 8.25-7.5 7.5-7.5-7.5"
                            />
                        </svg>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button wire:click="sort('priority')">Priority</button>
                        @if ($sortOrder == 'ASC' && $column == 'priority')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 inline-block"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m4.5 15.75 7.5-7.5 7.5 7.5"
                            />
                        </svg>
                        @endif @if ($sortOrder == 'DESC' && $column ==
                        'priority')
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 inline-block"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m19.5 8.25-7.5 7.5-7.5-7.5"
                            />
                        </svg>
                        @endif
                    </th>
                    @if (!$isActive)
                    <th scope="col" class="px-6 py-3">Active</th>
                    @endif

                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{$note->id}}
                    </th>
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{$note->body}}
                    </th>
                    <td class="px-6 py-4">
                        {{$note->priority}}
                    </td>
                    @if (!$isActive)
                    <td class="px-6 py-4">
                        {{$note->active}}
                    </td>
                    @endif
                    <td class="px-6 py-4">
                        <x-button
                            wire:click="edit({{$note->id}})"
                            wire:loading.attr="disabled"
                        >
                            {{ __("Edit") }}
                        </x-button>
                        <x-danger-button
                            wire:click="confirmNoteDeletion({{$note->id}})"
                            wire:loading.attr="disabled"
                        >
                            {{ __("Delete") }}
                        </x-danger-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 px-3 py-5">
            {{$notes->links()}}
        </div>
    </div>

    <!-- Delete Note Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingNoteDeletion">
        <x-slot name="title">
            {{ __("Delete Note") }}
        </x-slot>

        <x-slot name="content">
            {{ __("Are you sure you want to delete this note.") }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button
                wire:click="$toggle('confirmingNoteDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __("Cancel") }}
            </x-secondary-button>

            <x-danger-button
                class="ms-3"
                wire:click="deleteNote({{ $confirmingNoteDeletion }})"
                wire:loading.attr="disabled"
            >
                {{ __("Delete Note") }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="confirmingNoteAdd">
        <x-slot name="title">
            {{!$editMode ? 'Add Note' : 'Edit Note'}}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="body" value="{{ __('Note') }}" />
                <x-input id="body" type="text" class="mt-1 block w-full" wire:model="body" required />
                <x-input-error for="body" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="priority" value="{{ __('Priority') }}" />
                <select name="priority" id="priority" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full mt-1 block w-full" wire:model="priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                
                <x-input-error for="priority" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button
                wire:click="$toggle('confirmingNoteAdd')"
                wire:loading.attr="disabled"
            >
                {{ __("Cancel") }}
            </x-secondary-button>

            <x-button
                class="ms-3"
                wire:click="saveNote()"
                wire:loading.attr="disabled"
            >
            {{!$editMode ? 'Add Note' : 'Update Note'}}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
