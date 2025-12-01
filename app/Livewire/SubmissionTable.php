<?php

namespace App\Livewire;

use App\Models\Submission;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class SubmissionTable extends PowerGridComponent
{
    public string $tableName = 'submissionTable';

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
        return Submission::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('unit_id')
            ->add('submission_type_id')
            ->add('requester_name')
            ->add('requester_email')
            ->add('subject')
            ->add('content')
            ->add('attachments')
            ->add('submission_date_formatted', fn (Submission $model) => Carbon::parse($model->submission_date)->format('d/m/Y'))
            ->add('status')
            ->add('current_stage')
            ->add('reference_number')
            ->add('verified_by')
            ->add('verification_notes')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Unit id', 'unit_id'),
            Column::make('Submission type id', 'submission_type_id'),
            Column::make('Requester name', 'requester_name')
                ->sortable()
                ->searchable(),

            Column::make('Requester email', 'requester_email')
                ->sortable()
                ->searchable(),

            Column::make('Subject', 'subject')
                ->sortable()
                ->searchable(),

            Column::make('Content', 'content')
                ->sortable()
                ->searchable(),

            Column::make('Attachments', 'attachments')
                ->sortable()
                ->searchable(),

            Column::make('Submission date', 'submission_date_formatted', 'submission_date')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Current stage', 'current_stage')
                ->sortable()
                ->searchable(),

            Column::make('Reference number', 'reference_number')
                ->sortable()
                ->searchable(),

            Column::make('Verified by', 'verified_by')
                ->sortable()
                ->searchable(),

            Column::make('Verification notes', 'verification_notes')
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
            Filter::datepicker('submission_date'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Submission $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
