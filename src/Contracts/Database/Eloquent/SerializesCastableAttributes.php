<?php

namespace SoftTent\WpEloquent\Contracts\Database\Eloquent;

interface SerializesCastableAttributes
{
    /**
     * Serialize the attribute when converting the model to an array.
     *
     * @param  \SoftTent\WpEloquent\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function serialize($model, string $key, $value, array $attributes);
}
