<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getUserName($userId)
    {
        return ($userId) ? User::find($userId)->name : '';
    }

    public function getOldValuesFormat($auditId)
    {
        $oldText = '';
        $oldValuesData = Audit::find($auditId)->old_values;
        $oldValues = str_replace(array('{', '}', '"'), ' ',  $oldValuesData);
        $oldValuesFormat = explode(',',$oldValues);

        foreach ($oldValuesFormat as $value) {
            $oldText .= $value.', ';
        }
        return $oldText;
    }

    public function getNewValuesFormat($auditId)
    {
        $newText = '';
        $newValuesData = Audit::find($auditId)->new_values;
        $newValues = str_replace(array('{', '}', '"'), ' ',  $newValuesData);
        $newValuesFormat = explode(',',$newValues);
        
        foreach ($newValuesFormat as $value) {
            $newText .= $value.', ';
        }

        return $newText;
    }

    public function getColorAction($action)
    {
        switch ($action) {
            case 'created':
                return 'badge badge-pill badge-success';
                break;
            case 'updated':
                return 'badge badge-pill badge-warning';
                break;
            case 'deleted':
                return 'badge badge-pill badge-danger';
                break;
        }
    }
}
