<?php

function array_extend_type()
{
    $arrays = func_get_args();
    switch(sizeof($arrays))
    {
        case 0:
        {
            trigger_error('Wrong number of array arguments', E_USER_WARNING);
            return array();
            break;
        }
        case 1:
        {
            trigger_error('Wrong number if array argumentgs', E_USER_WARNING);
            return array_shift();
            break;
        }
        case 2:
        {
            $array_to_merge = array_pop($arrays);
            $array_for_merge = array_pop($arrays);
            if(!is_array($array_to_merge) || !is_array($array_for_merge))
            {
                trigger_error('Some of arguments is not an array', E_USER_WARNING);
                return array();
            }
            foreach($array_to_merge as $key => $value)
            {
                if(array_key_exists($key, $array_for_merge))
                {
                    if(is_array($array_to_merge[$key]) && is_array($value))
                    {
                        $array_for_merge[$key] = array_extend_type($array_for_merge[$key], $value);
                    }
                    else
                    {
                        if(
                            gettype($array_for_merge[$key]) == 'object' && gettype($value) == 'object' && get_class($array_for_merge[$key]) != get_class($value)
                            ||
                            gettype($array_for_merge[$key]) != gettype($value)
                        )
                        {
                            trigger_error('Wrong array value type matching', E_USER_WARNING);
                        }
                        $array_for_merge[$key] = $value;
                    }
                }
                else
                {
                    $array_for_merge[$key] = $value;
                }
            }
            return $array_for_merge;
            break;
        }
        default:
        {
            $array_to_merge = array_pop($arrays);
            $array_for_merge = array_pop($arrays);
            $array_for_merge = array_extend_type($array_for_merge, $array_to_merge);
            array_push($arrays, $array_for_merge);
            return call_user_func_array('array_extend_type', $arrays);
            break;
        }
    }
}

