<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'settings';

	protected $fillable = ['group_id', 'code', 'name', 'description', 'params', 'value', 'type', 'order'];

	protected $casts = [
		'params' => 'array',
	];

	const UPLOAD_PATH = '/public/uploads/settings/';
	const UPLOAD_URL = '/uploads/settings/';

	public static $types = [
    	0 => 'Одна строка', // inpyt type=text
    	1 => 'Много строк', // textarea
    	2 => 'Визивик', // Визивик
        3 => 'Файл', // Файл
        4 => 'Несколько полей', // Ассоциативный массив
        
        5 => 'Простой список', // Массив строк
        6 => 'Настраиваемый список', // Массив с параметрами
        7 => 'Галерея изображений', 
    ];

	public function group()
	{
		return $this->belongsTo('Gaus\Admin\Models\SettingGroup', 'group_id');
	}

	public function getValueAttribute($value)
	{
		switch ($this->type) {
            case 4:
            case 5:
            case 6:
            case 7:
                $json = json_decode($value, true);
                return is_array($json) ? $json : [];
                break;
            
            default:
                return $value;
                break;
        }
	}
}
