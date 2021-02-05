<?php

namespace App\Tables;

use App\ItalyData;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class ItalyDataTable extends AbstractTable
{
    protected string $sigla;

    public function __construct(string $sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(ItalyData::class)
            ->routes([
                'index'   => ['name' => 'nation.statistics',  'params' => [ 'sigla' => $this->sigla] ],
                //'create'  => ['name' => 'italyData.create'],
                //'edit'    => ['name' => 'italyData.edit'],
                //'destroy' => ['name' => 'italyData.destroy'],
            ])
            ->rowsNumber(50)
            ->destroyConfirmationHtmlAttributes(fn(ItalyData $italyData) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $italyData->data . ' ?'),
            ]);
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('data')->title("Data")->dateTimeFormat('d/m/Y')->sortable(true, 'desc')->searchable();
        $table->column('ricoverati_con_sintomi')->title("Ricoverati con sintomi")->sortable();
        $table->column('terapia_intensiva')->title("Terapia intensiva")->sortable();
        $table->column('totale_ospedalizzati')->title("Ospedalizzati")->sortable();
        $table->column('isolamento_domiciliare')->title("Isolamento domiciliare")->sortable();
        $table->column('totale_attualmente_positivi')->title("Attualmente positivi")->sortable();
        $table->column('ingressi_terapia_intensiava')->title("Ingressi terapia intensiva")->sortable();
        $table->column('variazione_totale_positivi')->title("Variazione positivi")->html(function(ItalyData $data){
            if ($data->variazione_totale_positivi < 0){
                return '<span class="badge badge-success">' . $data->variazione_totale_positivi . '</span>';
            }elseif ($data->variazione_totale_positivi > 0){
                return '<span class="badge badge-danger">' . $data->variazione_totale_positivi . '</span>';
            }else{
                return '<span class="badge badge-secondary">' . $data->variazione_totale_positivi . '</span>';
            }
        })->sortable();
        $table->column('dimessi_guariti')->title("Dimessi")->sortable();
        $table->column('casi_da_sospetto_diagnostico')->title("Casi da sospetto diagnostico")->sortable();
        $table->column('casi_da_screening')->title("Casi da screening")->sortable();
        $table->column('deceduti')->title("Deceduti")->sortable();
        $table->column('totale_casi')->title("Totale casi")->sortable();
        $table->column('casi_testati')->title("Casi testati")->html(function(ItalyData $data){
            if ($data->casi_testati >= 0){
                return $data->casi_testati;
            }else{
                return '<span class="badge badge-warning">N/A</span>';
            }
        })->sortable();
        $table->column('tamponi')->title("Tamponi effettuati")->sortable();

    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
