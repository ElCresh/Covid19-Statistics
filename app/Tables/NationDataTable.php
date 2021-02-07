<?php

namespace App\Tables;

use Carbon\Carbon;
use App\NationData;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class NationDataTable extends AbstractTable
{
    protected string $sigla;
    protected string $province;

    public function __construct(string $sigla, string $province)
    {
        $this->sigla = $sigla;
        $this->province = $province;
    }

    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(NationData::class)
            ->routes([
                'index'   => ['name' => 'nation.province.statistics',  'params' => [ 'sigla' => $this->sigla, 'province' => $this->province] ],
                //'create'  => ['name' => 'nationData.create'],
                //'edit'    => ['name' => 'nationData.edit'],
                //'destroy' => ['name' => 'nationData.destroy'],
            ])
            ->query(function (Builder $query) {
                if($this->province == '_'){
                    $query->where('country_region', $this->sigla)->where('province_state','');
                }else{
                    $query->where('province_state', $this->province);
                }
            })
            ->rowsNumber(50)
            ->destroyConfirmationHtmlAttributes(fn(NationData $nationData) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $nationData->last_update . ' ?'),
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
        $table->column('last_update')->title(__('statistics.date'))->html(function (NationData $data){
            return (new Carbon($data->last_update))->toDateString();
        })->sortable(true,'desc')->searchable();
        $table->column('confirmed')->title(__('statistics.total_case'))->sortable();
        $table->column()->title(__('statistics.active_case') . "*")->html(function (NationData $data){
            return ($data->confirmed - ($data->recovered + $data->deaths));
        });
        $table->column()->title("Variazione del totale positivi*")->html(function (NationData $data){
            $date = (new Carbon($data->last_update))->subDay();

            if($this->province == '_'){
                $prev_record = NationData::where('country_region', $this->sigla)->where('province_state','')->where('last_update', $date)->first();
            }else{
                $prev_record = NationData::where('province_state', $this->province)->where('last_update', $date)->first();
            }

            $active_case_prev = ($prev_record->confirmed - ($prev_record->recovered + $prev_record->deaths));
            $active_case = ($data->confirmed - ($data->recovered + $data->deaths));
            $variation_active_case = $active_case - $active_case_prev;

            if ($variation_active_case < 0){
                $html = '<span class="badge badge-success">' . $variation_active_case . '</span>';
            }elseif ($variation_active_case > 0){
                $html = '<span class="badge badge-danger">' . $variation_active_case . '</span>';
            }else{
                $html = '<span class="badge badge-secondary">' . $variation_active_case . '</span>';
            }

            return $html;
        });
        $table->column('recovered')->title(__('statistics.recovered'))->sortable();
        $table->column('deaths')->title(__('statistics.total_deaths'))->sortable();
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
