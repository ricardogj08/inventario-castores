<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

// Renderiza un mensaje de alerta.
class AlertMessageCell extends Cell
{
    public $message = '';
    public $type    = 'default';
    private $class  = [
        'default' => 'alert',
        'info'    => 'alert alert-info',
        'success' => 'alert alert-success',
        'warning' => 'alert alert-warning',
        'error'   => 'alert alert-error',
    ];

    public function getClassProperty(): string
    {
        return $this->class[$this->type] ?? $this->class['default'];
    }
}
