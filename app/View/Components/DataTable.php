<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;


class DataTable extends Component
{
    public $configFilters;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public array $columns,
        public array $filters,
    ) {
        $this->configFilters = $this->initFilters($filters);
    }

    public function initFilters($filters)
    {
        $filterState = [
            'label' => 'Estado:',
            'type' => 'select',
            'options' => [
                '' => 'Todos',
                '1' => 'Activos',
                '0' => 'Inactivos'
            ],
        ];

        $filterDate = [
            'label' => 'Fecha:',
            'type' => 'select',
            'options' => [
                'all' => 'All time',
                'thisyear' => 'This year',
                'thismonth' => 'This month',
                'lastmonth' => 'Last month',
                'last90days' => 'Last 90 days',
            ],
        ];

        $pos = array_search('state', $filters);
        if ($pos !== false) {
            unset($filters[$pos]);
            $filters['state'] = $filterState;
        }
        $pos = array_search('date', $filters);
        if ($pos !== false) {
            unset($filters[$pos]);
            $filters['date'] = $filterDate;
        }

        return $filters;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}
