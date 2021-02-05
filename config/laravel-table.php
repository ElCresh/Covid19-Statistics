<?php

return [

    /** Set the default classes for each part of the table. */
    'classes' => [
        'container' => ['table-responsive'],
        'table' => ['table-borderless'],
        'tr' => ['border-bottom'],
        'th' => ['align-middle'],
        'td' => ['align-middle'],
        'results' => ['table-secondary'],
        'disabled' => ['table-danger', 'disabled'],
    ],

    /** Set all the action icons that are used on the table templates. */
    'icon' => [
        'rows_number' => '<i class="material-icons">list</i>',
        'sort' => '<i class="material-icons">sort</i>',
        'sort_asc' => '<i class="material-icons">expand_more</i>',
        'sort_desc' => '<i class="material-icons">expand_less</i>',
        'search' => '<i class="material-icons">search</i>',
        'validate' => '<i class="material-icons">done</i>',
        'info' => '<i class="material-icons">info</i>',
        'reset' => '<i class="material-icons">undo</i>',
        'create' => '<i class="material-icons">add_circle</i>',
        'show' => '<i class="material-icons">visibility</i>',
        'edit' => '<i class="material-icons">create</i>',
        'destroy' => '<i class="material-icons">delete</i>',
    ],

    /** Set the table default behavior. */
    'behavior' => [
        'rows_number' => 20,
        'activate_rows_number_definition' => true,
    ],

    /** Set the default view path for each component of the table. */
    'template' => [
        'table' => 'bootstrap.table',
        'thead' => 'bootstrap.thead',
        'rows_searching' => 'bootstrap.rows-searching',
        'rows_number_definition' => 'bootstrap.rows-number-definition',
        'create_action' => 'bootstrap.create-action',
        'column_titles' => 'bootstrap.column-titles',
        'tbody' => 'bootstrap.tbody',
        'show_action' => 'bootstrap.show-action',
        'edit_action' => 'bootstrap.edit-action',
        'destroy_action' => 'bootstrap.destroy-action',
        'results' => 'bootstrap.results',
        'tfoot' => 'bootstrap.tfoot',
        'navigation_status' => 'bootstrap.navigation-status',
        'pagination' => 'bootstrap.pagination',
    ],

];
