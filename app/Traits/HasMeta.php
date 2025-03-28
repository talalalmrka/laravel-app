<?php

namespace App\Traits;

use App\Models\Meta;

trait HasMeta
{
    public function metas()
    {
        return $this->morphMany(Meta::class, 'model');
    }

    public function getMeta(string $key, $defaultValue = null)
    {
        $meta = $this->metas()->firstWhere('key', $key);
        $value = $meta?->value ?? $defaultValue;
        if (is_json($value)) {
            $value = json_decode($value, true);
        }
        return $value;
    }
    public function updateMeta(string $key, $value)
    {
        $meta = $this->metas()->firstOrCreate(['key' => $key]);
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $meta->value = $value;
        return $meta->save();
    }
    public function getMetas(...$keys) {
        if(!is_array($keys)){
            $keys = [$keys];
        }
        $metas = [];
        foreach ($keys as $key) {
            $metas[$key] = $this->getMeta($key);
        }
        return $metas;
    }
    public function saveMetas(array $metas)
    {
        $updated = true;
        foreach ($metas as $key => $value) {
            $update = $this->updateMeta($key, $value);
            if (!$update) {
                $updated = false;
            }
        }
        return $updated;
    }
}
