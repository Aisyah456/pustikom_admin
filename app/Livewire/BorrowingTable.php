<?php

namespace App\Livewire;

use App\Models\Borrowing;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Contracts\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class BorrowingTable extends PowerGridComponent
{
    public string $tableName = 'borrowingTable';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Borrowing::query()
            ->with([
                'item',
                // Load relasi polimorfik
                'borrowerUnit' => function (MorphTo $morphTo) {
                    // Tentukan relasi bersarang berdasarkan tipe model
                    $morphTo->morphWith([
                        \App\Models\StudyProgram::class => ['faculty'],
                    ]);
                }
            ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('borrower_name')
            ->add('borrower_unit_id')
            ->add('borrower_unit_type')
            ->add('item_id')
            ->add('borrow_date_formatted', fn(Borrowing $model) => Carbon::parse($model->borrow_date)->format('d/m/Y H:i:s'))
            ->add('estimated_return_date_formatted', fn(Borrowing $model) => Carbon::parse($model->estimated_return_date)->format('d/m/Y H:i:s'))
            ->add('purpose')
            ->add('quantity')
            ->add('condition_out')
            ->add('status')
            ->add('actual_return_date_formatted', fn(Borrowing $model) => Carbon::parse($model->actual_return_date)->format('d/m/Y H:i:s'))
            ->add('condition_in')
            ->add('notes')
            ->add('admin_out')
            ->add('admin_in')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Nama Peminjam', 'borrower_name')
                ->sortable()
                ->searchable(),

            // 2. Kolom Unit/Prodi/Fakultas (Custom Column)
            // Kolom ini akan diolah di render()
            Column::make('Unit Peminjam', 'unit_peminjam_display', 'borrower_unit_type')
                ->sortable(),

            // 3. Kolom Barang
            Column::make('Nama Barang', 'item_name', 'item_id')
                ->sortable()
                ->searchable(),

            // 4. Kolom Waktu dan Status
            Column::make('Tgl Pinjam', 'borrow_date')
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('Tgl Kembali Estimasi', 'estimated_return_date')
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('Status', 'status')
                ->sortable()
                ->makeInputSelect(config('powergrid.borrowing_statuses'), 'status', 'status'),

            // Kolom Lainnya
            Column::make('Admin Keluar', 'admin_out')
                ->sortable()
                ->searchable(),

            Column::make('Admin Kembali', 'admin_in')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('borrow_date'),
            Filter::datetimepicker('estimated_return_date'),
            Filter::datetimepicker('actual_return_date'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Borrowing $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    public function render(): View
    {
        $unitDisplay = fn(Borrowing $model) => $this->getBorrowerUnitDisplay($model);

        return view('powergrid::components.table', [
            'data' => $this->prepareData(
                $this->request()
            )->map(function (Borrowing $model) use ($unitDisplay) {

                // Tambahkan kolom virtual untuk nama item
                $model->item_name = $model->item->name;

                // Tambahkan kolom virtual untuk tampilan unit peminjam
                $model->unit_peminjam_display = $unitDisplay($model);

                return $model;
            })
        ]);
    }

    // Tambahkan metode helper ini
    protected function getBorrowerUnitDisplay(Borrowing $borrowing): string
    {
        $unit = $borrowing->borrowerUnit;

        if (!$unit) {
            return 'N/A';
        }

        $name = $unit->name;

        // Jika tipe-nya StudyProgram, tambahkan nama Fakultas
        if ($borrowing->borrower_unit_type === \App\Models\StudyProgram::class && $unit->faculty) {
            return "{$name} (Fak. {$unit->faculty->name})";
        }

        return $name;
    }


    public function actionRules($row): array
    {
        return [
            Button::make('edit', 'Edit')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                ->route('borrowings.edit', ['borrowing' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->route('borrowings.destroy', ['borrowing' => 'id'])
                ->method('delete')
        ];
    }
}
