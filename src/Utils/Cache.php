<?php

namespace Pravodev\Laramoud\Utils;

class Cache
{   
    /**
     * Directory for cached file
     * 
     * @return String
     */
    public function path($name = "")
    {
        return __DIR__ . '/../../cache/' . $name;
    }

    /**
     * Get value from cached file
     * 
     * @return null|string|array
     */
    public function get($type, $attribute = null)
    {
        $file = $this->path() . $type . '.php';
        if(file_exists($file)){
            $cached = include $file;
            if(is_bool($cached)) return null;
            
            if($attribute && is_array($cached)){
                return $cached[$attribute];
            }

            return $cached;
        }
        return null;
    }

    /**
     * Write or Set value to Cached with type
     * 
     * @param string $type
     * @param string $attribute
     * @param string|null $value
     * @return bool
     */
    public function set($type, $attribute, $value = null)
    {
        $filename = $this->path() . $type . '.php';
        $value = $value == null ? $attribute : $value;
        $export = "<?php \n return " . \var_export($attribute, true) . ';';
        
        //check if file exists append to it
        if(file_exists($filename)){
            // do nothing
        }
        
        try {
            file_put_contents($filename, $export);
            return true;
        } catch (\Throwable $th) {
            return false;
        }

    }

    /**
     * Clearing cache
     */
    public function clear($type = null)
    {
        if(\is_string($type)){
            $type = [$type];
        }
        if($type === null){
            $type = array_values(
                array_diff(
                    scandir($this->path(), 1),
                    array('..', '.')
                )
            );
        }

        $fails = [];
        
        foreach($type as $cache_file){
            $name = strpos($cache_file, '.php') > 0 ? $cache_file : $cache_file . '.php';
            $filename = $this->path($name);
            
            if(\file_exists($filename) == false) continue;

            try {
                unlink($filename);
            } catch (\Throwable $th) {
                array_push($fails, $filename);
            }
        }

        return count($fails) == 0;
    }
}