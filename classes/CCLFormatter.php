<?php


class CCLFormatter {
    private $raw_source;
    
    function __construct($raw_source) {
        $this->raw_source = $raw_source;
    }

    public function getFormattedVersion() {
        $source = str_replace(chr(10), ' <br> ', $this->raw_source);
        $pieces = explode(" ", $source);
        foreach ($pieces as &$word) {
            if (in_array(strtolower(trim($word)), $this->keywords)) {
                $word = "<span style='color:blue'>" . $word . "</span>";
            }
        }
        $source = implode("&nbsp;", $pieces);
        $source = str_replace(chr(9), '&nbsp;&nbsp;&nbsp;&nbsp;', $source);
        $source = str_replace('&nbsp;<br>&nbsp;', '<br>', $source);
        return $source;
    }
    
    public function getRaw_source() {
        return $this->raw_source;
    }

    private $keywords = array('drop', 'create', 'select', 'record','with', 'into',
        'from', 'end', 'go', 'declare', 'head', 'foot', 'plan', 'join', 'program',
        'prompt', 'execute', 'report', 'where', 'and', 'or', 'exists', 'in',
        'not', 'by', 'detail', 'order', 'group', 'set', 'if', 'else',
        'elseif', 'endif', 'while', 'endwhile', 'for', 'endfor', 'case',
        'of', 'endcase', 'default', 'call');

    
}

?>
