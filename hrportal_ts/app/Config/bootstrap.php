<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
CakePlugin::loadAll();
//CakePlugin::load('DocumentManager', array('bootstrap' => true));
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

function vd($data, $label = '', $return = false) {

        $debug = debug_backtrace();
        $callingFile = $debug[0]['file'];
        $callingFileLine = $debug[0]['line'];

        ob_start();
        var_dump($data);
        $c = ob_get_contents();
        ob_end_clean();

        $c = preg_replace("/\r\n|\r/", "\n", $c);
        $c = str_replace("]=>\n", '] = ', $c);
        $c = preg_replace('/= {2,}/', '= ', $c);
        $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
        $c = preg_replace('/  /', "    ", $c);
        $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
        $c = preg_replace("/(int|float)\(([0-9\.]+)\)/i", "$1() <span class=\"number\">$2</span>", $c);

// Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
        $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
        $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);

        $regex = array(
            // Numberrs
            'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
            // Keywords
            'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
            'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
            // Types
            'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
            // Objects
            'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
            // Function
            'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
        );

        foreach ($regex as $x) {
            $c = preg_replace($x[0], $x[1], $c);
        }

        $style = '
                    /* outside div - it will float and match the screen */
                    .dumpr {
                        margin: 2px;
                        padding: 2px;
                        background-color: #fbfbfb;
                        float: left;
                        clear: both;
                    }
                    /* font size and family */
                    .dumpr pre {
                        color: #000000;
                        font-size: 9pt;
                        font-family: "Courier New",Courier,Monaco,monospace;
                        margin: 0px;
                        padding-top: 5px;
                        padding-bottom: 7px;
                        padding-left: 9px;
                        padding-right: 9px;
                    }
                    /* inside div */
                    .dumpr div {
                        background-color: #fcfcfc;
                        border: 1px solid #d9d9d9;
                        float: left;
                        clear: both;
                    }
                    /* syntax highlighting */
                    .dumpr span.string {color: #c40000;}
                    .dumpr span.number {color: #ff0000;}
                    .dumpr span.keyword {color: #007200;}
                    .dumpr span.function {color: #0000c4;}
                    .dumpr span.object {color: #ac00ac;}
                    .dumpr span.type {color: #0072c4;}
                    ';

        $style = preg_replace("/ {2,}/", "", $style);
        $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
        $style = preg_replace("/\/\*.*?\*\//i", '', $style);
        $style = str_replace('}', '} ', $style);
        $style = str_replace(' {', '{', $style);
        $style = trim($style);

        $c = trim($c);
        $c = preg_replace("/\n<\/span>/", "</span>\n", $c);

        if ($label == '') {
            $line1 = '';
        } else {
            $line1 = "<strong>$label</strong> \n";
        }

        $out = "\n<!-- Dumpr Begin -->\n" .
                "<style type=\"text/css\">" . $style . "</style>\n" .
                "<div class=\"dumpr\">
    <div><pre>$line1 $callingFile : $callingFileLine \n$c\n</pre></div></div><div style=\"clear:both;\">&nbsp;</div>" .
                "\n<!-- Dumpr End -->\n";
        if ($return) {
            return $out;
        } else {
            echo $out;
        }
        die;
    }
    
    function dd($data, $label = '', $return = false) {

        $debug = debug_backtrace();
        $callingFile = $debug[0]['file'];
        $callingFileLine = $debug[0]['line'];

        ob_start();
        print_r($data);
        $c = ob_get_contents();
        ob_end_clean();

        $c = preg_replace("/\r\n|\r/", "\n", $c);
        $c = str_replace("]=>\n", '] = ', $c);
        $c = preg_replace('/= {2,}/', '= ', $c);
        $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
        $c = preg_replace('/  /', "    ", $c);
        $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
        $c = preg_replace("/(int|float)\(([0-9\.]+)\)/i", "$1() <span class=\"number\">$2</span>", $c);

// Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
        $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
        $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);

        $regex = array(
            // Numberrs
            'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
            // Keywords
            'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
            'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
            // Types
            'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
            // Objects
            'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
            // Function
            'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
        );

        foreach ($regex as $x) {
            $c = preg_replace($x[0], $x[1], $c);
        }

        $style = '
                    /* outside div - it will float and match the screen */
                    .dumpr {
                        margin: 2px;
                        padding: 2px;
                        background-color: #fbfbfb;
                        float: left;
                        clear: both;
                    }
                    /* font size and family */
                    .dumpr pre {
                        color: #000000;
                        font-size: 9pt;
                        font-family: "Courier New",Courier,Monaco,monospace;
                        margin: 0px;
                        padding-top: 5px;
                        padding-bottom: 7px;
                        padding-left: 9px;
                        padding-right: 9px;
                    }
                    /* inside div */
                    .dumpr div {
                        background-color: #fcfcfc;
                        border: 1px solid #d9d9d9;
                        float: left;
                        clear: both;
                    }
                    /* syntax highlighting */
                    .dumpr span.string {color: #c40000;}
                    .dumpr span.number {color: #ff0000;}
                    .dumpr span.keyword {color: #007200;}
                    .dumpr span.function {color: #0000c4;}
                    .dumpr span.object {color: #ac00ac;}
                    .dumpr span.type {color: #0072c4;}
                    ';

        $style = preg_replace("/ {2,}/", "", $style);
        $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
        $style = preg_replace("/\/\*.*?\*\//i", '', $style);
        $style = str_replace('}', '} ', $style);
        $style = str_replace(' {', '{', $style);
        $style = trim($style);

        $c = trim($c);
        $c = preg_replace("/\n<\/span>/", "</span>\n", $c);

        if ($label == '') {
            $line1 = '';
        } else {
            $line1 = "<strong>$label</strong> \n";
        }

        $out = "\n<!-- Dumpr Begin -->\n" .
                "<style type=\"text/css\">" . $style . "</style>\n" .
                "<div class=\"dumpr\">
    <div><pre>$line1 $callingFile : $callingFileLine \n$c\n</pre></div></div><div style=\"clear:both;\">&nbsp;</div>" .
                "\n<!-- Dumpr End -->\n";
        if ($return) {
            return $out;
        } else {
            echo $out;
        }
        die;
    }
    
    function prx($data, $terminate = true) {
        // capture the output of print_r
        $out = print_r($data, true);

        // replace something like '[element] => <newline> (' with <a href="javascript:toggleDisplay('...');">...</a><div id="..." style="display: none;">
        $out = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe', "'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $out);

        // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</div>
        $out = preg_replace('/^\s*\)\s*$/m', '</div>', $out);
        echo '<pre>';
        // print the javascript function toggleDisplay() and then the transformed output
        echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>' . "\n$out";
        if ($terminate) {
            die;
        }
    }
    
    
    
    
