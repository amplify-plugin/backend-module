<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use App\Models\JsonException;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AttributeProduct extends Model implements Auditable
{
    use DynamicDBConnectionTrait, HasFactory, HasTranslations;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'attribute_product';

    protected $guarded = [];

    protected $translatable = ['attribute_value'];

    protected $append = ['local_attribute_value'];

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function getLocalAttributeValueAttribute()
    {
        return $this->attributes['local_attribute_value'] = $this->getDataOfAvailableLocale('attribute_value');
    }

    /**
     * @return string|null
     *
     * @throws JsonException
     */
    private function getDataOfAvailableLocale($original_field_name)
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);

        if (empty($data)) {
            try {
                $original_data = json_decode(($this->attributes[$original_field_name] ?? '{}'),
                    true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                // Handle the exception (e.g., log, provide a default value, etc.)
                $original_data = [];
            }
            $data = $original_data->{$locale} ?? collect($original_data)->first();
        }

        return $data;
    }
}
