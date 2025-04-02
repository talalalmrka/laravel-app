<?php

namespace App\Livewire\Components\Datatable;

use App\Livewire\Components\Datatable\Actions\Action;
use App\Livewire\Components\Datatable\Buttons\Button;
use App\Livewire\Components\Datatable\Columns\Column;
use App\Livewire\Components\Datatable\Columns\DateColumn;
use App\Traits\WithToast;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

abstract class Datatable extends Component
{
    use WithPagination, WithToast;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    #[Computed]
    public $tableClass = '';
    #[Computed]
    public $headClass = '';
    #[Computed]
    public $footClass = '';
    #[Computed]
    public $bodyClass = '';
    #[Computed]
    public $rowClass = '';
    #[Computed]
    public $cellClass = '';
    public $selected = [];
    public $selectAll = false;
    public $checkbox = true;
    public $created_at_column = true;
    public $id_column = false;
    public $date_format = null;
    abstract public function builder();

    abstract public function getColumns();
    abstract public function render();
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedSelectAll($value)
    {
        $this->selectAll = $value;
        if ($value) {
            $this->selected = $this->items()->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }
    #[Computed]
    public function hasSelected()
    {
        return sizeof($this->selected) > 0;
    }
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
    public function getActions()
    {
        return [
            Action::make('show')->icon('bi-eye'),
            Action::make('edit')->icon('bi-pencil-square'),
            Action::make('delete')->icon('bi-trash'),
        ];
    }
    #[Computed]
    public function actions()
    {
        return $this->getActions();
    }
    #[Computed]
    public function hasActions()
    {
        return sizeof($this->actions()) > 0;
    }
    public function getButtons()
    {
        return [
            Button::make('create')
                ->icon('bi-plus-lg')
                ->color('green'),

            Button::make('deleteSelected')
                ->icon('bi-trash')
                ->color('red')
                ->disabled(!$this->hasSelected()),
        ];
    }
    #[Computed]
    public function buttons()
    {
        return $this->getButtons();
    }
    #[Computed]
    public function hasButtons()
    {
        return sizeof($this->buttons()) > 0;
    }
    public function createdAtColumnExists(): bool
    {
        foreach ($this->getColumns() as $col) {
            if ($col->name == 'created_at') {
                return true;
            }
        }
        return false;
    }
    public function mustAddCreatedAt(): bool
    {
        return $this->created_at_column && !$this->createdAtColumnExists();
    }
    public function getCreatedAtColumn()
    {
        $date_column = DateColumn::make('created_at')
            ->label('Creation date');
        if ($this->date_format) {
            $date_column = $date_column->format($this->date_format);
        }
        return $date_column;
    }
    #[Computed]
    public function cols()
    {
        $cols = [];
        if ($this->checkbox) {
            $cols[] = Column::make('id')
                ->label(view('livewire.components.datatable.check-all'))
                ->content(function ($item) {
                    return view('livewire.components.datatable.check-item', [
                        'item' => $item,
                    ]);
                });
        }
        if ($this->id_column) {
            $cols[] = Column::make('id')
                ->sortable()
                ->label(__('Id'));
        }
        foreach ($this->getColumns() as $column) {
            $cols[] = $column;
        }
        if ($this->mustAddCreatedAt()) {
            $cols[] = $this->getCreatedAtColumn();
        }
        if ($this->hasActions()) {
            $cols[] = Column::make('actions')
                ->label(__('Actions'))
                ->content(function ($item) {
                    return view('livewire.components.datatable.actions', [
                        'actions' => $this->actions(),
                        'item' => $item,
                    ]);
                });
        }
        return $cols;
        //return $this->getColumns();
    }
    #[Computed]
    public function items()
    {
        $query = $this->builder();
        if ($this->search) {
            $query->where(function ($q) {
                foreach ($this->cols() as $col) {
                    if ($col->searchable) {
                        $q->orWhere($col->name, 'like', "%{$this->search}%");
                    }
                }
            });
        }
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }
        return $query->paginate($this->perPage);
    }
    #[Computed]
    public function links()
    {
        return $this->items()->links();
    }
    public function setTableClass($class = null)
    {
        $this->tableClass = $class;
    }
    public function setHeadClass($class = null)
    {
        $this->headClass = $class;
    }
    public function setFootClass($class = null)
    {
        $this->footClass = $class;
    }
    public function setBodyClass($class = null)
    {
        $this->bodyClass = $class;
    }
    public function setRowClass($class = null)
    {
        $this->rowClass = $class;
    }
    public function setCellClass($class = null)
    {
        $this->cellClass = $class;
    }
    /*public function delete($id)
    {
        $item = $this->builder()->find($id);
        if ($item) {
            $delete = $item->delete();
            if ($delete) {
                $this->toastSuccess(__('Item deleted.'));
            } else {
                $this->toastError(__('Failed to delete item!'));
            }
        } else {
            $this->toastError(__('Item not found!'));
        }
    }*/
    public function deleteSelected()
    {
        if (!empty($this->selected)) {
            $count = sizeof($this->selected);
            // Bulk delete the selected items
            $this->builder()->whereIn('id', $this->selected)->delete();

            // Clear the selection after deletion
            $this->selected = [];
            $this->selectAll = false;

            // Optionally, show a success message
            $this->toastSuccess(__(':count items deleted successfully.', ['count' => $count]));
        } else {
            // Optionally, show an error message
            $this->toastError(__('No items selected for deletion!'));
        }
    }

    #[Computed]
    public function table()
    {
        return view('livewire.components.datatable.datatable', [
            'search' => $this->search,
            'perPage' => $this->perPage,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
            'selectAll' => $this->selectAll,
            'selected' => $this->selected,
            'checkbox' => $this->checkbox,
        ]);
    }

    public function getSingularName()
    {
        return Str::singular($this->builder()->getModel()->getTable());
    }
    /*public function show($id)
    {
        //dd($id);
        $this->dispatch("show-" . $this->getSingularName(), $id);
    }*/
    /*public function create()
    {
        $this->dispatch("edit-" . $this->getSingularName());
    }*/
    /*public function edit(mixed $id)
    {
        //$this->toastSuccess("edit-" . $this->getSingularName());
        $this->dispatch("edit-" . $this->getSingularName(), $id);
    }*/

    #[On('data-item-updated')]
    public function onItemUpdated(string $model_name, int|null $itemId = null)
    {
        if ($model_name == $this->getSingularName()) {
            $this->dispatch('itemUpdated');
        }
    }
}
