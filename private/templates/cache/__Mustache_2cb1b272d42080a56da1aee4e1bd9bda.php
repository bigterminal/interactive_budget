<?

class __Mustache_2cb1b272d42080a56da1aee4e1bd9bda extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '', $escape = false)
    {
        $buffer = '';

        $buffer .= $indent . '<!DOCTYPE html>';
        $buffer .= "\n";
        $buffer .= $indent . '<html class="';
        $value = $context->find('html_classes');
        if (!is_string($value) && is_callable($value)) {
            $value = $this->mustache
                ->loadLambda((string) call_user_func($value))
                ->renderInternal($context, $indent);
        }
        $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        $buffer .= '">';
        $buffer .= "\n";
        $buffer .= $indent . '    <head>';
        $buffer .= "\n";
        $buffer .= $indent . '        <title>Interactive Budget</title>';
        $buffer .= "\n";
        $buffer .= $indent . '        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />';
        $buffer .= "\n";
        $buffer .= $indent . '        <meta name="viewport" content="width=device-width" />';
        $buffer .= "\n";
        $buffer .= $indent . '        <link href=\'/css/styles.css\' rel=\'stylesheet\' type=\'text/css\'>';
        $buffer .= "\n";
        $buffer .= $indent . '        <script type="text/javascript" src="/js/main.js"></script>';
        $buffer .= "\n";
        $buffer .= $indent . '    </head>';
        $buffer .= "\n";
        $buffer .= $indent . '    <body>';
        $buffer .= "\n";
        $buffer .= $indent . '        <h1>Interactive Budget</h1>';
        $buffer .= "\n";
        $buffer .= $indent . '    </body>';
        $buffer .= "\n";
        $buffer .= $indent . '</html>';

        if ($escape) {
            return htmlspecialchars($buffer, ENT_COMPAT, 'UTF-8');
        } else {
            return $buffer;
        }
    }

}