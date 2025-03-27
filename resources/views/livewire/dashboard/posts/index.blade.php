<div class="card" x-data="datatable">
    <div class="btn-group sm m-2">
        <button wire:click="deleteSelected" class="btn btn-red sm">
            <i class="icon bi-trash-fill"></i>
        </button>
        <a wire:navigate href="{{ route('dashboard.posts.create') }}" class="btn btn-green">
            <i class="icon bi-plus-lg"></i>
        </a>
    </div>
    <x-fgx::status class="m-2 alert-soft" />
    <div class="table-container">
        <table class="table table-striped table-divide table-rounded xs">
            <thead>
                <tr>
                    <th><input type="checkbox" x-model="selectedAll" x-bind="selectAll" /></th>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Author') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Creation data') }}</t>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($posts->isNotEmpty())
                    @foreach ($posts as $post)
                        <tr wire:key="{{ $post->id }}">
                            <td>
                                <input type="checkbox" x-model="selected" value="{{ $post->id }}"
                                    x-bind="selectItem" class="select-item" />
                            </td>
                            <td>{{ $post->id }}</td>
                            <td>
                                <div class="flex-space-2">
                                    <img src="{{ $post->user->getFirstMediaUrl('avatar') }}"
                                        class="w-6 h-6 rounded-full object-cover" alt="{{ $post->user->name }}">
                                    <div>{{ $post->author_name }}</div>
                                </div>
                            </td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->slug }}</td>
                            <td>{{ $post->created_at->format('d, M Y') }}</td>
                            <td>
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('post', $post) }}" target="_blank"
                                        class="btn btn-blue xs flex-space-1 justify-center">
                                        <i class="icon bi-eye-fill"></i>
                                    </a>
                                    <button wire:click="edit({{ $post->id }})" type="button"
                                        class="btn btn-green xs flex-space-1 justify-center">
                                        <i class="icon bi-pencil-square"></i>
                                        <x-fgx::loader wire:loading wire:target="edit({{ $post->id }})" />
                                    </button>
                                    <button wire:click="delete({{ $post->id }})"
                                        wire:confirm="{{ __('Are you sure to delete?') }}" type="button"
                                        class="btn btn-red xs flex-space-1 justify-center">
                                        <i class="icon bi-trash-fill"></i>
                                        <x-fgx::loader wire:loading wire:target="delete({{ $post->id }})" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">{{ __('No data found') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if ($posts->isNotEmpty())
        <div class="p-2">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@script
    <script>
        Alpine.data('datatable', () => ({
            selected: [],
            selectedAll: false,
            selectAll: {
                ['@change']() {
                    this.selectedAll = this.$el.checked;
                    console.log('select all changed', this.selectedAll);
                    this.toggleSelection();
                },
            },
            selectItem: {
                ['@change']() {

                },
            },

            toggleSelection() {
                console.log(this.selectItem);
                /*const checkboxes = Array.from(this.$el.querySelectorAll('.select-item'));
                console.log(checkboxes);
                const ids = checkboxes.map(checkbox => checkbox.value);

                if (this.selectedAll) {
                    this.selected = [...new Set([...this.selected, ...ids])];
                } else {
                    this.selected = this.selected.filter(id => !ids.includes(id));
                }*/
            }
        }));
    </script>
@endscript
