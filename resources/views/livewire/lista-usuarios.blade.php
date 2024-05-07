<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                @include('livewire.includes.search-bar')
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'nome',
                                    'displayName' => 'Nome'
                                ])
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'email',
                                    'displayName' => 'E-mail'
                                ])
                                @include('livewire.includes.table-sortable-th', [
                                    'name' => 'user_type',
                                    'displayName' => 'Tipo'
                                ])
                                <th scope="col" class="px-4 py-3">Joined</th>
                                <th scope="col" class="px-4 py-3">Last update</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr wire:key = "{{ $user->id }}" class="border-b dark:border-gray-700">
                                @if($editingUserId === $user->id)
                                    <td class="px-4 py-3">
                                        <input wire:model = "editingUserNome" type="text" class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
                                            @error('editingUserNome')
                                                <span class="text-red-500 text-xs block">{{ $message }}</span>
                                            @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input wire:model = "editingUserEmail" type="text" class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
                                            @error('editingUserEmail')
                                                <span class="text-red-500 text-xs block">{{ $message }}</span>
                                            @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input wire:model = "editingUserTipo" type="text" class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
                                            @error('editingUserTipo')
                                                <span class="text-red-500 text-xs block">{{ $message }}</span>
                                            @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <button wire:click = "update" class="mb-2 mt-3 px-4 py-2 bg-teal-500 text-white font-semibold rounded hover:bg-teal-600">Update</button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button wire:click = "cancelEditing" class="mb-2 mt-3 px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">Cancel</button>
                                    </td>
                                @else
                                        <td class="px-4 py-3">{{ $user->nome }}</td>
                                        <td class="px-4 py-3">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-green-500">{{ $user->user_type }}</td>
                                        <td class="px-4 py-3">{{ $user->created_at }}</td>
                                        <td class="px-4 py-3">{{ $user->updated_at }}</td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button wire:click = "edit({{ $user->id }})" class="text-sm text-teal-500 font-semibold rounded hover:text-teal-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                            <select
                                wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="py-4 px-3">
                    {{ $users->links()}}
                </div>
            </div>
        </div>
    </section>
</div>
