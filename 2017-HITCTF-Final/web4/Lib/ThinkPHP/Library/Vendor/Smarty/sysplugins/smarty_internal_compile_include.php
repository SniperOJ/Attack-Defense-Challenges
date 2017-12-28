<?php
/**
* Smarty Internal Plugin Compile Include
*
* Compiles the {include} tag
*
* @package Smarty
* @subpackage Compiler
* @author Uwe Tews
*/

/**
* Smarty Internal Plugin Compile Include Class
*
* @package Smarty
* @subpackage Compiler
*/
class Smarty_Internal_Compile_Include extends Smarty_Internal_CompileBase {

    /**
    * caching mode to create nocache code but no cache file
    */
    const CACHING_NOCACHE_CODE = 9999;
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $required_attributes = array('file');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $shorttag_order = array('file');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $option_flags = array('nocache', 'inline', 'caching');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $optional_attributes = array('_any');

    /**
    * Compiles code for the {include} tag
    *
     * @param array $args array with attributes from parser
     * @param object $compiler compiler object
     * @param array $parameter array with compilation parameter
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // save posible attributes
        $include_file = $_attr['file'];

        if (isset($_attr['assign'])) {
            // output will be stored in a smarty variable instead of beind displayed
            $_assign = $_attr['assign'];
        }

        $_parent_scope = Smarty::SCOPE_LOCAL;
        if (isset($_attr['scope'])) {
            $_attr['scope'] = trim($_attr['scope'], "'\"");
            if ($_attr['scope'] == 'parent') {
                $_parent_scope = Smarty::SCOPE_PARENT;
            } elseif ($_attr['scope'] == 'root') {
                $_parent_scope = Smarty::SCOPE_ROOT;
            } elseif ($_attr['scope'] == 'global') {
                $_parent_scope = Smarty::SCOPE_GLOBAL;
            }
        }
        $_caching = 'null';
        if ($compiler->nocache || $compiler->tag_nocache) {
            $_caching = Smarty::CACHING_OFF;
        }
        // default for included templates
        if ($compiler->template->caching && !$compiler->nocache && !$compiler->tag_nocache) {
            $_caching = self::CACHING_NOCACHE_CODE;
        }
        /*
        * if the {include} tag provides individual parameter for caching
        * it will not be included into the common cache file and treated like
        * a nocache section
        */
        if (isset($_attr['cache_lifetime'])) {
            $_cache_lifetime = $_attr['cache_lifetime'];
            $compiler->tag_nocache = true;
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        } else {
            $_cache_lifetime = 'null';
        }
        if (isset($_attr['cache_id'])) {
            $_cache_id = $_attr['cache_id'];
            $compiler->tag_nocache = true;
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        } else {
            $_cache_id = '$_smarty_template->cache_id';
        }
        if (isset($_attr['compile_id'])) {
            $_compile_id = $_attr['compile_id'];
        } else {
            $_compile_id = '$_smarty_template->compile_id';
        }
        if ($_attr['caching'] === true) {
            $_caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
        if ($_attr['nocache'] === true) {
            $compiler->tag_nocache = true;
            $_caching = Smarty::CACHING_OFF;
        }

        $has_compiled_template = false;
        if (($compiler->smarty->merge_compiled_includes || $_attr['inline'] === true) && !$compiler->template->source->recompiled
            && !($compiler->template->caching && ($compiler->tag_nocache || $compiler->nocache)) && $_caching != Smarty::CACHING_LIFETIME_CURRENT) {
            // check if compiled code can be merged (contains no variable part)
            if (!$compiler->has_variable_string && (substr_count($include_file, '"') == 2 or substr_count($include_file, "'") == 2)
               and substr_count($include_file, '(') == 0 and substr_count($include_file, '$_smarty_template->') == 0) {
                $template_name = null;
                eval("\$template_name = $include_file;");
                if (!isset($compiler->smarty->merged_templates_func[$template_name]) || $compiler->inheritance) {
                    $template = new $compiler->smarty->template_class ($template_name, $compiler->smarty, $compiler->template, $compiler->template->cache_id, $compiler->template->compile_id);
                    // save unique function name
                    $compiler->smarty->merged_templates_func[$template_name]['func'] = $template->properties['unifunc'] = 'content_'.uniqid('', false);
                    // use current nocache hash for inlined code
                    $compiler->smarty->merged_templates_func[$template_name]['nocache_hash'] = $template->properties['nocache_hash'] = $compiler->template->properties['nocache_hash'];
                    if ($compiler->template->caching) {
                        // needs code for cached page but no cache file
                        $template->caching = self::CACHING_NOCACHE_CODE;
                    }
                    // make sure whole chain gest compiled
                    $template->mustCompile = true;
                    if (!($template->source->uncompiled) && $template->source->exists) {
                        // get compiled code
                        $compiled_code = $template->compiler->compileTemplate($template);
                        // release compiler object to free memory
                        unset($template->compiler);
                        // merge compiled code for {function} tags
                        $compiler->template->properties['function'] = array_merge($compiler->template->properties['function'], $template->properties['function']);
                        // merge filedependency
                        $template->properties['file_dependency'][$template->source->uid] = array($template->source->filepath, $template->source->timestamp,$template->source->type);
                        $compiler->template->properties['file_dependency'] = array_merge($compiler->template->properties['file_dependency'], $template->properties['file_dependency']);
                        // remove header code
                        $compiled_code = preg_replace("/(<\?php \/\*%%SmartyHeaderCode:{$template->properties['nocache_hash']}%%\*\/(.+?)\/\*\/%%SmartyHeaderCode%%\*\/\?>\n)/s", '', $compiled_code);
                        if ($template->has_nocache_code) {
                            // replace nocache_hash
                            $compiled_code = preg_replace("/{$template->properties['nocache_hash']}/", $compiler->template->properties['nocache_hash'], $compiled_code);
                            $compiler->template->has_nocache_code = true;
                        }
                        $compiler->merged_templates[$template->properties['unifunc']] = $compiled_code;
                        $has_compiled_template = true;
                    }
                } else {
                    $has_compiled_template = true;
                }
            }
        }
        // delete {include} standard attributes
        unset($_attr['file'], $_attr['assign'], $_attr['cache_id'], $_attr['compile_id'], $_attr['cache_lifetime'], $_attr['nocache'], $_attr['caching'], $_attr['scope'], $_attr['inline']);
        // remaining attributes must be assigned as smarty variable
        if (!empty($_attr)) {
            if ($_parent_scope == Smarty::SCOPE_LOCAL) {
                // create variables
                foreach ($_attr as $key => $value) {
                    $_pairs[] = "'$key'=>$value";
                }
                $_vars = 'array('.join(',',$_pairs).')';
                $_has_vars = true;
            } else {
                $compiler->trigger_template_error('variable passing not allowed in parent/global scope', $compiler->lex->taglineno);
            }
        } else {
            $_vars = 'array()';
            $_has_vars = false;
        }
        if ($has_compiled_template) {
            $_hash = $compiler->smarty->merged_templates_func[$template_name]['nocache_hash'];
            $_output = "<?php /*  Call merged included template \"" . $template_name . "\" */\n";
            $_output .= "\$_template_stack[] = \$_smarty_template;\n";
            $_output .= " \$_smarty_template = \$_smarty_template->setupInlineSubTemplate($include_file, $_cache_id, $_compile_id, $_caching, $_cache_lifetime, $_vars, $_parent_scope, '$_hash');\n";
            if (isset($_assign)) {
                $_output .= 'ob_start(); ';
            }
            $_output .= $compiler->smarty->merged_templates_func[$template_name]['func']. "(\$_smarty_template);\n";
            $_output .= "\$_smarty_template = array_pop(\$_template_stack); ";
            if (isset($_assign)) {
                $_output .= " \$_smarty_template->template_vars[$_assign] = new Smarty_variable(ob_get_clean());";
            }
            $_output .= "/*  End of included template \"" . $template_name . "\" */?>";
            return $_output;
        }

        // was there an assign attribute
        if (isset($_assign)) {
            $_output = "<?php \$_smarty_template->template_vars[$_assign] = new Smarty_variable(\$_smarty_template->getSubTemplate ($include_file, $_cache_id, $_compile_id, $_caching, $_cache_lifetime, $_vars, $_parent_scope));?>\n";;
        } else {
            $_output = "<?php echo \$_smarty_template->getSubTemplate ($include_file, $_cache_id, $_compile_id, $_caching, $_cache_lifetime, $_vars, $_parent_scope);?>\n";
        }
        return $_output;
    }

}

?>