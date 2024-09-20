<?php


namespace App\Http\Controllers\ITSM\Pyrus\Parser;

use App\Http\Controllers\ITSM\Pyrus\Helper\Helper;
use App\Http\Controllers\ITSM\Pyrus\Types\Task;

class Parser
{
    /**
     * @param array $pyrusTask
     * @return Task
     */
    public static function parseTask(array $pyrusTask): Task
    {
        $task = new Task();

        foreach ($pyrusTask as $key => $value) {
            try {
                if($key == 'fields') $value = self::parseFields($value);

                $rp = new \ReflectionProperty($task, self::hasProperty($key));
                $rp->setAccessible(true);
                $rp->setValue($task, $value);
            } catch (\ReflectionException $e) {
            }
        }

        return $task;
    }

    /**
     * @param array $pyrusFields
     * @return array
     */
    public static function parseFields(array $pyrusFields): array
    {
        $fields = [];

        foreach ($pyrusFields as $field)
        {
            if(array_key_exists('value', $field))
            {
                //Если значение число или строка - записываем ключ(конвертируется из id в строку) и значение
                if(is_string($field['value']) or is_int($field['value']))
                    $fields[Helper::fieldToName($field['id'])] = $field['value'];

                //Если значение массив - записываем ключ(конвертируется из id в строку) и значение
                if(is_array($field['value']))
                {
                    if(array_key_exists('item_id', $field['value']))
                    {
                        $fields[Helper::fieldToName($field['id'])] = Helper::itemToName($field['value']['item_id']);
                    }
                    if(array_key_exists('choice_id', $field['value']))
                    {
                        $fields[Helper::fieldToName($field['id'])] = Helper::itemToName($field['value']['choice_id']);
                    }
                }
            } else {
                $fields[Helper::fieldToName($field['id'])] = '';
            }
        }

        return $fields;
    }

    /**
     * @param string $key
     * @return string
     */
    private static function hasProperty(string $key): string
    {
        $key = str_split($key);
        foreach ($key as $i => $char) {
            if ($char == '_') {
                unset($key[$i]);
                $key[$i + 1] = strtoupper($key[$i + 1]);
            }
        }
        return implode($key);
    }
}
