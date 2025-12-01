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
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Borrowing::query()
            ->with([
            'item',
            'borrowerUnit' => function (MorphTo $morphTo) {
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
            ->add('borrow_date')
            ->add('estimated_return_date')
            ->add('actual_return_date')
            ->add('purpose')
            ->add('quantity')
            ->add('condition_out')
            ->add('status')
            ->add('condition_in')
            ->add('notes')
            ->add('admin_out')
            ->add('admin_in')
            ->add('created_at')
            // Tambahkan field komputasi/relasi agar bisa disort/search
            ->add('item_name')
            ->add('unit_peminjam_display')
            // Formatted versions
            ->add('borrow_date_formatted', fn(Borrowing $m) => Carbon::parse($m->borrow_date)->format('d/m/Y H:i'))
            ->add('estimated_return_date_formatted', fn(Borrowing $m) => Carbon::parse($m->estimated_return_date)->format('d/m/Y H:i'))
            ->add('actual_return_date_formatted', fn(Borrowing $m) => $m->actual_return_date ? Carbon::parse($m->actual_return_date)->format('d/m/Y H:i') : '-') // Perbaikan untuk actual_return_date null
            ->add('created_at_formatted', fn(Borrowing $m) => Carbon::parse($m->created_at)->format('d/m/Y H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Nama Peminjam', 'borrower_name')
                ->sortable()
                ->searchable(),

            // Kolom komputasi, tidak perlu argumen ketiga (kecuali ingin disort/search berdasarkan field DB lain)
            Column::make('Unit Peminjam', 'unit_peminjam_display')
                ->sortable(),

            // Kolom komputasi/relasi
            Column::make('Nama Barang', 'item_name')
                ->sortable()
                ->searchable(),

            // **PERBAIKAN TANGGAL** Menggunakan field yang diformat, tetapi sort/filter berdasarkan field DB asli
            Column::make('Tgl Pinjam', 'borrow_date_formatted', 'borrow_date')
                ->sortable(), // Hapus ->filterDateBetween() karena sudah di filters()

            // **PERBAIKAN TANGGAL**
            Column::make('Tgl Kembali Estimasi', 'estimated_return_date_formatted', 'estimated_return_date')
                ->sortable(), // Hapus ->filterDateBetween() karena sudah di filters()

            Column::make('Tgl Kembali Aktual', 'actual_return_date_formatted', 'actual_return_date')
                ->sortable(), // Tambahkan kolom Tgl Kembali Aktual

            Column::make('Status', 'status')
                ->sortable()
                ->makeSelect(
                    config('powergrid.borrowing_statuses'),
                    'status',
                    'status'
                ),

            Column::make('Admin Keluar', 'admin_out')
                ->sortable()
                ->searchable(),

            Column::make('Admin Kembali', 'admin_in')
                ->sortable()
                ->searchable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter tanggal didefinisikan di sini
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
                ->class('pg-btn-white')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    public function render(): View
    {
        $unitDisplay = fn(Borrowing $model) => $this->getBorrowerUnitDisplay($model);

        return view('powergrid::components.table', [
            'data' => $this->prepareData($this->request())
                ->map(function (Borrowing $model) use ($unitDisplay) {
                    // Penambahan data komputasi untuk kolom
                    $model->item_name = $model->item->name ?? '-';
                    $model->unit_peminjam_display = $unitDisplay($model);

                return $model;
            })
        ]);
    }

    protected function getBorrowerUnitDisplay(Borrowing $borrowing): string
    {
        $unit = $borrowing->borrowerUnit;

        if (!$unit) return 'N/A';

        $name = $unit->name;

        if (
            $borrowing->borrower_unit_type === \App\Models\StudyProgram::class
            && $unit->faculty
        ) {
            return "{$name} (Fak. {$unit->faculty->name})";
        }

        return $name;
    }

    public function actionRules($row): array
    {
        return [
            // Action rules menggunakan tombol yang didefinisikan di actions()
            // Jika Anda ingin menggunakan Action Rules (route), ganti dengan:

            /*
            Button::make('edit', 'Edit')
                ->class('bg-indigo-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->route('borrowings.edit', ['borrowing' => $row->id]),

            Button::make('destroy', 'Delete')
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->route('borrowings.destroy', ['borrowing' => $row->id])
                ->method('delete')
            */

            // Karena Anda memiliki actions(Borrowing $row) di atas, saya asumsikan Anda ingin menggunakan itu.
            // Biarkan actionRules() kosong atau gunakan route seperti di atas.

            // Saya biarkan versi asli Anda, tetapi menggunakan $row->id
            Button::make('edit', 'Edit')
                ->class('bg-indigo-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->route('borrowings.edit', ['borrowing' => $row->id]), // Perbaikan: gunakan $row->id

            Button::make('destroy', 'Delete')
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->route('borrowings.destroy', ['borrowing' => $row->id]) // Perbaikan: gunakan $row->id
                ->method('delete')
        ];
    }
}
