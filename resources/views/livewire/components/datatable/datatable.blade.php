<div class="datatable" @itemUpdated($refresh)>
    <div class="md:flex-space-2 md:justify-between md:items-center p-2">
        @if ($this->hasButtons)
            <div class="btn-group sm">
                @foreach ($this->buttons as $button)
                    {!! $button->render() !!}
                @endforeach
            </div>
        @endif
        <div class="grow flex-space-2 justify-end mt-2 md:mt-0">
            <div class="flex-space-1 items-center space-x-1 rtl:space-x-reverse">
                <label for="perPage" class="form-label mb-0">{{ __('entries:') }}</label>
                <fgx:select id="perPage" class="xs pill min-w-32" wire:model.live.debounce.300ms="perPage"
                    startIcon="bi-list" :options="per_page_options()" />
            </div>
            <div class="flex-space-1">
                <label class="form-label mb-0" for="search">{{ __('search:') }}</label>
                <fgx:input type="search" id="search" class="xs pill" wire:model.live.debounce.300ms="search"
                    startIcon="bi-search" :placeholder="__('Search')" />
            </div>
        </div>
    </div>


    <div class="table-container">
        <table class="table table-striped table-divide table-rounded xs {{ $this->tableClass }}">
            <thead class="{{ $this->headClass }}">
                @include('livewire.components.datatable.head-row')
            </thead>
            <tbody class="{{ $this->bodyClass }}">
                @if ($this->items()->isNotEmpty())
                    @foreach ($this->items() as $item)
                        <tr class="{{ $this->rowClass }}" wire:key="{{ data_get($item, 'id', '') }}">
                            @foreach ($this->cols() as $col)
                                <td class="{{ $this->cellClass }}{{ !empty($col->class) ? ' ' . $col->class : '' }}">
                                    @if ($col->customContent)
                                        {!! call_user_func($col->customContent, $item) !!}
                                    @else
                                        {!! data_get($item, $col->name, '') !!}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr class="{{ $this->rowClass }}">
                        <td class="{{ $this->cellClass }} text-center" colspan="{{ sizeof($this->cols()) }}">
                            {{ __('No items found.') }}
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot class="{{ $this->footClass }}">
                @include('livewire.components.datatable.head-row')
            </tfoot>
        </table>
    </div>
    <div class="p-2.5">
        {!! $this->links() !!}
    </div>
</div>
