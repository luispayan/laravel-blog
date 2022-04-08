<?php

namespace App\Helpers;

class FilterManager
{
    /**
     * @param $query
     * @param $options
     * @return mixed
     */
    public static function filter($query, $options)
    {
        $defaultOptions = [
            'take' => null, // Int, how many comments will be returned
            'skip' => null, // Int, how many comments will be skiped
            'sort' => null  // String, asc for ascending, desc for descending, default asc.
        ];
        $options = array_merge($defaultOptions, $options);

        if(isset($options['take'])){
            $query->take((int) $options['take']);
        }

        if(isset($options['skip'])){
            $query->skip((int) $options['skip']);
        }

        $query->orderBy('created_at', $options['sort'] ? $options['sort'] : 'asc');

        return $query;
    }
}