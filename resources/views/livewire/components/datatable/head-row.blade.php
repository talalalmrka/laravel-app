<tr>
    @foreach ($this->cols() as $col)
        <th class="{{ $this->cellClass }}{{ !empty($col->headClass) ? ' ' . $col->headClass : '' }}">
            @if ($col->sortable)
                <div wire:click="sortBy('{{ $col->name }}')"
                    class="w-full flex justify-between flex-space-2 cursor-pointer">
                    <div class="grow">{{ $col->getLabel() }}</div>
                    <div class="flex flex-col text-xxs">
                        <i
                            class="icon bi-chevron-up {{ $sortField === $col->name && $sortDirection === 'asc' ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        <i
                            class="icon bi-chevron-down {{ $sortField === $col->name && $sortDirection === 'desc' ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    </div>

                </div>
            @else
                {{ $col->getLabel() }}
            @endif
        </th>
    @endforeach
</tr>
