<?php
namespace App\Database\Eloquent\Relations\Traits;

use App\Database\Eloquent\Relations\HasManySyncable;
/**
 * Overrides the default Eloquent hasMany relationship to return a HasManySyncable.
 *
 * {@inheritDoc}
 */
trait eloquentRelation
{
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: $this->getKeyName();
        return new HasManySyncable(
            $instance->newQuery(),
            $this,
            $instance->getTable().'.'.$foreignKey,
            $localKey
        );
    }
}