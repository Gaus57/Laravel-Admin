<?php namespace Gaus\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Feedback extends Model {

	use SoftDeletes;

	protected $table = 'feedbacks';

	protected $fillable = ['user_id', 'type', 'data'];

	protected $casts = [
		'data' => 'array',
	];

	public static $types = array(
        1 => 'Обратный звонок',
        2 => 'Расчет ст-ти окон',
        3 => 'Расчет ст-ти балкона',
        4 => 'Расчет ст-ти двери',
        5 => 'Запрос цены товара',
    );

    private static $fields = [
    	'name' => 'Имя',
    	'phone' => 'Телефон',
    	'email' => 'E-mail',
    	'building_type' => 'Тип дома',
    	'underkey' => 'Под «ключ»',
    	'products' => 'Товары',
    	'product_id' => 'Товар',
    	'balcony_type' => 'Тип балкона',
    	'glazing_type' => 'Тип остекления',
    	'wind' => 'Внутренняя обшивка',
    	'works' => 'Работы',
    ];

    public function scopeNotRead($query)
	{
		return $query->whereNull('read_at');
	}

    public function getTypeNameAttribute()
    {
    	return array_get(self::$types, $this->type);
    }

    public function getDataInfoAttribute()
    {
    	$info = [];
    	foreach ($this->data as $key => $value) {
    		switch ($key) {
    			case 'products':
    				$value2 = [];
    				foreach ($value as $item) {
    					$value2[] = array_get($item, 'name').' '.array_get($item, 'size').' '.array_get($item, 'count').'шт.';
    				}
    				$value = $value2;
    			case 'product_id':
    				$product = Product::find($value);
    				if ($product) $value = '<span>'.$product->name.'</span>';
    				else $value = 'товара нет в каталоге';
    			default:
    				if (empty($value)) $value = '<i>не указано</i>';
    				$info[] = '<b>'.array_get(self::$fields, $key, $key).'</b>: '.(is_array($value) ? implode(', ', $value) : $value);
    		}
    	}
    	return implode('; ', $info);
    }

	public static function addItem($type, $data = array())
    {
        $arr = [];
        $arr['user_id'] = Auth::logedIn() ? Auth::user()->id : 0;
        $arr['type'] = $type;
        $arr['data'] = $data;
        return self::create($arr);
    }

}
