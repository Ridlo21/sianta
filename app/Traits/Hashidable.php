<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait Hashidable
{
    /**
     * Get the value of the model's route key.
     * Overrides the default model route key mapping to return the Hashid.
     */
    public function getRouteKey()
    {
        return Hashids::encode($this->getKey());
    }

    /**
     * Retrieve the model for a bound value.
     * Decodes the Hashid and queries the model.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $decoded = Hashids::decode($value);

        if (empty($decoded)) {
            abort(404);
        }

        return $this->where($this->getKeyName(), $decoded[0])->firstOrFail();
    }
}
