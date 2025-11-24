<?php

namespace App\Livewire;

use App\Models\ItemLoan;
use Livewire\Component;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Footer;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Header;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class ItemLoanTable extends Component
{

    public string $tableName = 'item_loans_table';

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearch(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->dispatch('openEditModal', id: $rowId);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        ItemLoan::destroy($rowId);
        $this->dispatch('pg:eventRefresh-' . $this->tableName);
    }

    public function columns(): PowerGridColumns
    {
        return PowerGridColumns::create()
            ->addColumn(
                Column::make('Nama Peminjam', 'nama_peminjam')
                    ->searchable()
                    ->sortable()
            )
            ->addColumn(
                Column::make('NIP', 'nip')
                    ->searchable()
                    ->sortable()
            )
            ->addColumn(
                Column::make('Nama Barang', 'nama_barang')
                    ->searchable()
                    ->sortable()
            )
            ->addColumn(
                Column::make('Jumlah', 'jumlah')
                    ->sortable()
            )
            ->addColumn(
                Column::make('Tgl Pinjam', 'tanggal_pinjam')
                    ->sortable()
            )
            ->addColumn(
                Column::make('Tgl Kembali', 'tanggal_kembali')
                    ->sortable()
            )
            ->addColumn(
                Column::make('Status', 'status')
                    ->searchable()
                    ->sortable()
            )
            ->addColumn(
                Column::make('Aksi', 'id')
                    ->label(
                        fn($row) => view('livewire.actions', ['row' => $row])
                    )
            );
    }


    public function datasource(): array
    {
        return ItemLoan::query()->orderBy('id', 'DESC')->toArray();
    }

    public function builder()
    {
        return ItemLoan::query();
    }

    public function render()
    {
        return view('livewire.item-loan-table');
    }
}
