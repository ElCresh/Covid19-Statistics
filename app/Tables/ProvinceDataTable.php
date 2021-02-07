<?php

namespace App\Tables;

use Carbon\Carbon;

use App\ProvinceData;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class ProvinceDataTable extends AbstractTable
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
        return (new Table())->model(ProvinceData::class)
            ->routes([
                'index'   => ['name' => 'province.statistics',  'params' => [ 'sigla' => $this->sigla] ],
                //'create'  => ['name' => 'provinceData.create'],
                //'edit'    => ['name' => 'provinceData.edit'],
                //'destroy' => ['name' => 'provinceData.destroy'],
            ])
            ->query(function (Builder $query) {
                $query->where('sigla_provincia', $this->sigla);
            })
            ->rowsNumber(50)
            ->destroyConfirmationHtmlAttributes(fn(ProvinceData $provinceData) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $provinceData->data . ' ?'),
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
        $table->column('totale_casi')->title("Totale casi")->sortable();
        $table->column()->html(function(ProvinceData $data){
            $date = (new Carbon($data->data))->subDay();

            $prev_record = ProvinceData::where('sigla_provincia', $this->sigla)->where('data', $date)->first();
            $diff = $data->totale_casi - $prev_record->totale_casi;

            return $diff;

        })->title("Diff. prec. gior.");
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
