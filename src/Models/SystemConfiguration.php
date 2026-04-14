<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Helpers\UtilityHelper;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use OwenIt\Auditing\Contracts\Auditable;

class SystemConfiguration extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL CONSTANTS
    |--------------------------------------------------------------------------
    */
    const BASIC_TAB = 'basic';

    const PIM_TAB = 'pim';

    const REPORT_TAB = 'report';

    const SAYT_TAB = 'sayt';

    const ICECAT_TAB = 'icecat';

    const GOOGLE_TAB = 'google';

    const FRONTEND_TAB = 'frontend';

    const PAYMENT_TAB = 'payment';

    const ERP_TAB = 'erp';

    const INVOICE_TAB = 'invoice';

    const SCHEDULE_TAB = 'schedule';

    const CMS_TAB = 'cms';

    const MARKETING_TAB = 'marketing';

    const ORDER_TAB = 'order';

    const PROP65_TAB = 'prop65';

    const DDS_TAB = 'dds';

    const SECURITY_TAB = 'security';

    const AMPLIFY_API_TAB = 'api';

    const DEVELOPER_TAB = 'developer';

    const VALUE_TYPES = [
        'bool' => 'Boolean',
        'float' => 'Decimal',
        'integer' => 'Integer',
        'json' => 'JSON',
        'string' => 'Text',
    ];
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'system_configurations';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $fillable = [];
    protected $hidden = ['field', 'created_at', 'updated_at'];

    protected $casts = [
        'field' => 'array',
        'active' => 'boolean',
    ];

    protected $attributes = [
        'field' => '{"name":"value","label":"Value","type":"text"}',
    ];

    protected static function booted(): void
    {
        static::saved(function ($model) {
            Artisan::call('queue:restart');
        });

        static::creating(function ($model) {
            if (empty($model->type)) {
                $model->type = self::checkType($model->value);
            }
        });
    }

    public function transformAudit(array $data): array
    {
        $newValues = $data['new_values'] ?? [];
        $oldValues = $data['old_values'] ?? [];

        $option = $newValues['option'] ?? $oldValues['option'] ?? null;

        if (in_array($option, [
            'configurations.csd-erp.access_token',
            'configurations.csd-erp.expires_at',
            'nxt_available_web_order_number'])) {
            return [];
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Set value for system configuration
     *
     * @return void
     */
    public static function setValue(string $name, string $option, $value = null, ?string $type = null)
    {
        $model = self::where(['name' => $name, 'option' => $option])
            ->when($type != null, function ($query) use ($type) {
                return $query->where('type', '=', $type);
            })->first();

        if (!$model) {
            $model = self::create([
                'name' => $name,
                'option' => $option,
                'type' => self::checkType($value, $type),
            ]);
        }
        $model->value = (string)UtilityHelper::stringify($model->type, $value);
        $model->active = true;

        $model->save();

    }

    /**
     * @return bool|string
     */
    private static function checkType($value, $type = null)
    {
        if ($type != null) {
            return $type;
        }

        $valueType = strtolower((gettype($value) ?? ''));

        switch ($valueType) {
            case 'array' :
            case 'object' :
                return 'json';

            case 'boolean' :
                return 'bool';

            case 'string' :
            case 'null':
                return 'string';

            default:
                return $valueType;
        }
    }

    public static function getValue(string $group, string $option)
    {
        if ($model = self::where(['name' => $group, 'option' => $option])->first()) {
            $model->value = UtilityHelper::typeCast($model->value, $model->type);

            return $model->value;
        }

        return null;
    }
}
