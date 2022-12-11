<?php
namespace App\Classes;
class Log
{
    public function __construct($filename, $path)
    {
        $this->path     = ($path) ?? "/";
        $this->filename = ($filename) ?? "log";
        $this->date     = date("Y-m-d H:i:s");
        $this->ip       = $_SERVER['REMOTE_ADDR'] ?? 0;
    }
    public function insert($text, $dated, $clear, $backup)
    {
        $append = ($clear) ? null : FILE_APPEND;
        if ($dated) {
            $date   = date("Ymd");
        }
        else {
            $date   = "";
            if ($backup) {
                $result = (copy($this->path . $this->filename . ".log", $this->path . $this->filename .  $date . "-backup.log")) ? 1 : 0;
                $append = ($result) ? $result : FILE_APPEND;
            }
        };
        $log    = $this->date . " [ip] " . $this->ip . " [text] " . $text . PHP_EOL;
        //$result = (file_put_contents($this->path .  $this->filename . $date . ".log", $log, $append)) ? 1 : 0;
        return 1;
        return $result;
    }
}

