<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

// Renderiza un mensaje de alerta.
class AlertMessageCell extends Cell
{
    public $message = '';
    public $type    = 'default';
    private $class  = [
        'default' => '',
        'info'    => 'alert-info',
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'error'   => 'alert-error',
    ];

    public function getClassProperty(): string
    {
        return $this->class[$this->type] ?? $this->class['default'];
    }
}
