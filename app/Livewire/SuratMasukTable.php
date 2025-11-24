<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Components\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Components\Filters\TextInput;

final class SuratMasukTable extends PowerGridComponent
{
    public string $tableName = 'suratMasukTable';


    public function datasource(): ?\Illuminate\Database\Eloquent\Builder
    {
        return SuratMasuk::query();
    }
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

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Nomor Surat', 'nomor_surat')->sortable()->searchable(),
            Column::make('Asal Surat', 'asal_surat')->searchable(),
            Column::make('Perihal', 'perihal')->searchable(),
            Column::make('Tanggal Surat', 'tanggal_surat')->sortable(),
            Column::make('Tanggal Terima', 'tanggal_terima')->sortable(),

            Column::action('Aksi'),
        ];
    }

    public function actions(SuratMasuk $row): array
    {
        return [
            Button::add('edit')
                ->caption('Edit')
                ->class('bg-blue-600 text-white px-2 py-1 rounded')
                ->route('surat-masuk.edit', ['id' => $row->id]),

            Button::add('hapus')
                ->caption('Hapus')
                ->class('bg-red-600 text-white px-2 py-1 rounded')
                ->emit('deleteSurat', ['id' => $row->id]),
        ];
    }

    // public function filters(): array
    // {
    //     return [
    //         Filter::inputText('nomor_surat'),
    //         Filter::inputText('asal_surat'),
    //     ];
    // }
}
