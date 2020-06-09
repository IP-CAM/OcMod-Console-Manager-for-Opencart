<?php
define('OCmodVer', '1.0.1b');
/* helper */
function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

function noDiacritics( $string )
{
	//cyrylic transcription
	$cyrylicFrom = array( '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?' );
	$cyrylicTo   = array( 'A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia' );
	$from        = array( "Á", "A", "Â", "Ä", "Ă", "A", "A", "A", "Ą", "A", "Ć", "C", "C", "Č", "Ç", "Ď", "Đ", "?", "É", "E", "E", "E", "Ë", "Ě", "E", "Ę", "?", "G", "G", "G", "G", "á", "a", "â", "ä", "ă", "a", "a", "a", "ą", "a", "ć", "c", "c", "č", "ç", "ď", "đ", "?", "é", "e", "e", "e", "ë", "ě", "e", "ę", "?", "g", "g", "g", "g", "H", "H", "I", "Í", "I", "I", "Î", "I", "I", "I", "?", "J", "K", "L", "Ł", "Ń", "Ň", "N", "N", "Ó", "O", "Ô", "Ö", "O", "Ő", "O", "O", "O", "h", "h", "i", "í", "i", "i", "î", "i", "i", "i", "?", "j", "k", "l", "ł", "ń", "ň", "n", "n", "ó", "o", "ô", "ö", "o", "ő", "o", "o", "o", "Ŕ", "Ř", "Ś", "S", "Š", "Ş", "Ť", "Ţ", "?", "Ú", "U", "U", "Ü", "U", "U", "Ů", "U", "Ű", "U", "W", "Ý", "Y", "Y", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "s", "š", "ş", "ß", "ť", "ţ", "?", "ú", "u", "u", "ü", "u", "u", "ů", "u", "ű", "u", "w", "ý", "y", "y", "ź", "ż", "ž" );
	$to          = array( "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z" );
	$from        = array_merge( $from, $cyrylicFrom );
	$to          = array_merge( $to, $cyrylicTo );
	$newstring   = str_replace( $from, $to, $string );
	return $newstring;
}

function make_slug( $string, $maxlen = 0, $lower = true )
{
	$newStringTab = array();
	$string       = noDiacritics( $string );
	if($lower)
	{
		$string = strtolower($string);
	}

	if ( function_exists( 'str_split' ) )
	{
		$stringTab = str_split( $string );
	}
	else
	{
		$stringTab = my_str_split( $string );
	}
	$numbers = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "_" );
	$other = array("_");
	foreach ( $stringTab as $letter )
	{
		if ( in_array( $letter, range( "a", "z" ) ) ||  in_array( $letter, range( "A", "Z" ) ) || in_array( $letter, $numbers ) || in_array( $letter, $other ) )
		{
			$newStringTab[] = $letter;
			//print($letter);
		}
		elseif ( $letter == " " )
		{
			$newStringTab[] = "_";
		}
	}
	if ( count( $newStringTab ) )
	{
		$newString = implode( $newStringTab );
		if ( $maxlen > 0 )
		{
			$newString = substr( $newString, 0, $maxlen );
		}
		$newString = removeDuplicates( '__', '_', $newString );
	}
	else
	{
		$newString = '';
	}
	return $newString;
}

function checkSlug( $sSlug )
{
	if ( ereg( "^[a-zA-Z0-9]+[a-zA-Z0-9\_\-]*$", $sSlug ) )
	{
		return true;
	}
	return false;
}

function removeDuplicates( $sSearch, $sReplace, $sSubject )
{
	$i = 0;
	do
	{
		$sSubject = str_replace( $sSearch, $sReplace, $sSubject );
		$pos      = strpos( $sSubject, $sSearch );
		$i++;
		if ( $i > 100 )
		{
			die( 'removeDuplicates() loop error' );
		}
	} while ( $pos !== false );
	return $sSubject;
}

/* class app */
class OcMod
{
    var $params=array();
    function __construct()
    {
        /* Check OpenCart version */
        $index_php = @file_get_contents('index.php');
        if(preg_match("/define\(\'VERSION\', \'(.*)\'\);/i", $index_php, $version_array))
        {
            $this->opencart_version = $version_array[1];
        }
        else
        {
            print "OpenCart system not found".PHP_EOL;
            exit(1);
        }

        /* first run */
        if(!is_dir(getcwd().'/ocmod'))
        {
            if(!mkdir(getcwd().'/ocmod', 0755))
            {
                print "ocmod dir creation failed ".getcwd().'/ocmod'.PHP_EOL;
                exit(1);
            }
            $this->first_run = true;
        }

        $this->ocmod_dir = getcwd().'/ocmod/';
        $this->oc_dir = getcwd().'/';

        if(isset($this->first_run))
        {
            print "OpenCart ".$this->opencart_version." version detected";
        }

        /* params */
        foreach($_SERVER['argv'] as $parameter)
        {
            // --set-
            if(trim($parameter))
            {
                $this->params[] = trim($parameter);
            }
        }
    }

    function is_param($param)
    {
        foreach($this->params as $p)
        {
            if(mb_strtolower(trim($param)) == mb_strtolower(trim($p)))
            {
                return true;
            }
        }
        return false;
    }
    
    function new()
    {
        // create projetfile

        $name = readline('New OCmod Name:');
        if(empty($name))
        {
            print 'name is empty'.PHP_EOL;
            exit(2);
        }

        $version = readline('Version: [1.0.0]');
        if(empty($version))
        {
            $version = '1.0.0';
        }
        
        $code = make_slug($name);
        $this->code = $code;
        $this->name = $name;

        $json_data['name'] = $name;
        $json_data['code'] = $code;
        $json_data['version'] = $version;
        $json_data['author'] = 'OpenCart.hu';
        $json_data['link'] = 'https://opencart.hu';
        $json_data['sources'] = array();
        $this->json_data = $json_data;
        if(!is_file($this->ocmod_dir.$code.".json"))
        {
            $write = file_put_contents($this->ocmod_dir.$code.".json", json_encode($json_data, JSON_PRETTY_PRINT));
            if($write == false)
            {
                print 'json file write error'.PHP_EOL;
                exit(2);
            }
        }
        else
        {
            print 'json file already exists'.PHP_EOL;
            exit(2);
        }

        if(!is_file($this->ocmod_dir.$code.".xml"))
        {
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<modification>
    <name>".$json_data['name']."</name>
    <code>".$json_data['code']."</code>
    <version>".$json_data['version']."</version>
    <author>".$json_data['author']."</author>
    <link>".$json_data['link']."</link>
    
    <file path=\"\">
        <operation>
            <search trim=\"true|false\" index=\"1\"><![CDATA[]]></search>
            <add position=\"replace|before|after\" offset=\"1\"><![CDATA[]]></add>
        </operation>
    </file>
</modification>";
            $write = file_put_contents($this->ocmod_dir.$code.".xml", $xml);
            if($write == false)
            {
                print 'xml file write error'.PHP_EOL;
                exit(2);
            }
        }
        else
        {
            print 'xml file already exists'.PHP_EOL;
            exit(2);
        }
    }

    function ls()
    {
        $files = glob($this->ocmod_dir.'*.json');
        if(count($files)==0)
        {
            print "not found".PHP_EOL;
        }
        foreach($files as $file)
        {
            print pathinfo($file, PATHINFO_FILENAME).PHP_EOL;
        }
    }

    function code_load($code)
    {
        if(!is_file($this->ocmod_dir.$code.".json"))
        {
            print 'json file not found'.PHP_EOL;
            exit(2);
        }
        if(!is_file($this->ocmod_dir.$code.".xml"))
        {
            print 'xml file not found'.PHP_EOL;
            exit(2);
        }
        
        $json_data = json_decode(file_get_contents($this->ocmod_dir.$code.".json"), true);
        $this->json_data = $json_data;
        return $this->json_data;
    }

    function rm()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: rm [CODE] [FILE]".PHP_EOL;
            exit(2);
        }  

        if(isset($this->params[3]))
        {
            $file = @$this->params[3];
        }
        else
        {
            print "Required: rm ".$code." [FILE]".PHP_EOL;
            exit(2);
        } 
        
        $old_sources = $this->json_data['sources'];
        $this->json_data['sources'] = array();
        foreach($old_sources as $source)
        {
            if($source != $file)
            {
                $this->json_data['sources'][] = $source;
            }
        }

        $this->json_data['sources'] = array_unique($this->json_data['sources']);

        $write = file_put_contents($this->ocmod_dir.$this->json_data['code'].".json", json_encode($this->json_data, JSON_PRETTY_PRINT));
        if($write == false)
        {
            print 'json file write error'.PHP_EOL;
            exit(2);
        }
    }

    function add()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: add [CODE] [FILE]".PHP_EOL;
            exit(2);
        }  

        if(isset($this->params[3]))
        {
            $file = @$this->params[3];
        }
        else
        {
            print "Required: set ".$code." [FILE]".PHP_EOL;
            exit(2);
        } 
        
        $filepath = getcwd().'/'.$file;
        
        if(is_file($filepath))
        {
           
        }
        elseif(is_dir($filepath))
        {
           
        }
        else
        {
            print "Source not found: ".$filepath.PHP_EOL;
            exit(2);
        }

        $this->json_data['sources'][] = str_replace( getcwd().'/', '',$filepath);

        $this->json_data['sources'] = array_unique($this->json_data['sources']);

        $write = file_put_contents($this->ocmod_dir.$this->json_data['code'].".json", json_encode($this->json_data, JSON_PRETTY_PRINT));
        if($write == false)
        {
            print 'json file write error'.PHP_EOL;
            exit(2);
        }
    }

    function build()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: build".PHP_EOL;
            exit(2);
        }

        if(!is_file($this->ocmod_dir.$code.".xml"))
        {
            print "xml not found".PHP_EOL;
            exit(2);   
        }

        $zipname = $this->ocmod_dir.$code.'-v'.$this->json_data['version'].'.ocmod.zip';
        
        @unlink($zipname);

		$zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        
        $zip->addFile($this->ocmod_dir.$code.".xml", 'install.xml');
        $all_files = $this->json_data['sources'];

		foreach ($all_files as $file)
		{
            if(is_file($file))
            {
                $zip->addFile($file, 'upload/'.$file);
            }

            if(is_dir($file))
            {
                $sub_files = getDirContents($file);
                if($sub_files)
                {
                    foreach($sub_files as $sub_file)
                    {
                        if(is_file($sub_file))
                        {
                            $zip->addFile(str_replace(getcwd()."/","",$sub_file), 'upload/'.str_replace(getcwd()."/","",$sub_file));                            
                        }
                    }
                }
            }
        }
        
        $zip->close();
        print $zipname.PHP_EOL;
    }

    function set()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: set [CODE] [KEY] [VALUE]".PHP_EOL;
            exit(2);
        }

        if(isset($this->params[3]))
        {
            $key = @$this->params[3];
        }
        else
        {
            print "Required: set ".$code." [KEY] [VALUE]".PHP_EOL;
            exit(2);
        }
        if(isset($this->params[4]))
        {
            $value = @$this->params[4];
        }
        else
        {
            print "Required: set ".$code." ".$key." [VALUE]".PHP_EOL;
            exit(2);
        }

        if($key && $value)
        {
            $xml = file_get_contents($this->ocmod_dir.$this->json_data['code'].".xml");

            switch($key)
            {
                case "name":
                    $this->json_data['name'] = $value;
                    $this->json_data['code'] = make_slug($value);
                    $xml = preg_replace('/<name>(.*)<\/name>/ix', '<name>'.$this->json_data['name'].'</name>', $xml);
                    $xml = preg_replace('/<code>(.*)<\/code>/ix', '<code>'.$this->json_data['code'].'</code>', $xml);
                break;
                
                case "version":
                    if($value == "up")
                    {
                        $old_version = explode('.',$this->json_data['version']);
                        if($this->is_param('--minor'))
                        {
                            $old_version[0]++;
                        }
                        elseif($this->is_param('--feature'))
                        {
                            $old_version[count($old_version)-2]++;
                        }
                        else
                        {
                            $old_version[count($old_version)-1]++;
                        }

                        $this->json_data['version'] = implode('.',$old_version);
                        print 'new version '.$this->json_data['version'].PHP_EOL;
                    }
                    else
                    {
                        $this->json_data['version'] = $value;
                    }
                    $xml = preg_replace('/<version>(.*)<\/version>/ix', '<version>'.$this->json_data['version'].'</version>', $xml);
                break;
                
                case "author":
                    $this->json_data['author'] = $value;
                    $xml = preg_replace('/<author>(.*)<\/author>/ix', '<author>'.$this->json_data['author'].'</author>', $xml);
                break;
                
                case "link":
                    $this->json_data['link'] = $value;
                    $xml = preg_replace('/<link>(.*)<\/link>/ix', '<link>'.$this->json_data['link'].'</link>', $xml);
                break;

            }
            if($this->json_data['code'] != $code)
            {
                @rename($this->ocmod_dir.$code.".json", $this->ocmod_dir.$this->json_data['code'].".json");
                @rename($this->ocmod_dir.$code.".xml", $this->ocmod_dir.$this->json_data['code'].".xml");
            }

            $write = file_put_contents($this->ocmod_dir.$this->json_data['code'].".json", json_encode($this->json_data, JSON_PRETTY_PRINT));
            if($write == false)
            {
                print 'json file write error'.PHP_EOL;
                exit(2);
            }

            $write = file_put_contents($this->ocmod_dir.$this->json_data['code'].".xml", $xml);
            if($write == false)
            {
                print 'xml file write error'.PHP_EOL;
                exit(2);
            }
        }
    }

    function info()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: info [CODE]".PHP_EOL;
            exit(2);
        }

        print "Name: ".$this->json_data['name'].PHP_EOL;
        print "Code: ".$this->json_data['code'].PHP_EOL;
        print "Version: ".$this->json_data['version'].PHP_EOL;
        print "Author: ".$this->json_data['author'].PHP_EOL;
        print "Link: ".$this->json_data['link'].PHP_EOL;
        print "Sources: ".PHP_EOL;
        if($this->json_data['sources'])
        {
            foreach($this->json_data['sources'] as $path)
            {
                print " - ".$path.PHP_EOL;
            }
        }
    }

    function import()
    {
        if(isset($this->params[2]))
        {
            $file = @$this->params[2];
            if(!is_file($file))
            {
                print "File not found: ".$file.PHP_EOL;
                exit(2);
            }
        }
        else
        {
            print "Required: import [FILE]".PHP_EOL;
            exit(2);
        }
    }

    function write_model($name)
    {
        // eg. admin/tool/test
        $name = trim($name);
		$name = trim($name,'/');

		$routes = explode('/', $name);

		if($routes[0] == 'catalog')
		{
            $application = 'catalog';
            unset($routes[0]);
		}
		else if($routes[0] == 'admin')
		{
            $application = 'admin';
            unset($routes[0]);
		}
		else
		{
			print 'ERROR: application not specified (eg.: admin or catalog): '.PHP_EOL;
			exit(2);
        }
        $generate_file = $this->oc_dir.''.$application."/model/".implode('/',$routes).".php";
        $class_name = "Model".implode("",array_map('ucfirst',$routes));
        $class_name = str_replace('_', '', $class_name);
        $path = implode("/",$routes);

        $generate_content = '<?php
class '.$class_name.' extends Model {

}';
        if($this->save_file($generate_file,$generate_content) == false)
        {
            print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
            exit(2);
        }
    }

    function write_language($name)
    {
        // eg. admin/tool/test
        $name = trim($name);
		$name = trim($name,'/');

		$routes = explode('/', $name);

		if($routes[0] == 'catalog')
		{
            $application = 'catalog';
            unset($routes[0]);
		}
		else if($routes[0] == 'admin')
		{
            $application = 'admin';
            unset($routes[0]);
		}
		else
		{
			print 'ERROR: application not specified (eg.: admin or catalog): '.PHP_EOL;
			exit(2);
        }

        $installed_langs=glob($this->oc_dir. $application. '/language/*');

        foreach($installed_langs as $lang_dirs)
        {

            $generate_file = $lang_dirs."/".implode('/',$routes).".php";
            $path = implode("/",$routes);

            $generate_content = '<?php
// Heading Title
$_[\'heading_title\']    = \''.implode(" ",array_map('ucfirst',$routes)).'\';
';
            if($this->save_file($generate_file,$generate_content) == false)
            {
                print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
                exit(2);
            }
        }
    }

    function write_template($name)
    {
        // eg. admin/tool/test
        $name = trim($name);
		$name = trim($name,'/');

		$routes = explode('/', $name);

		if($routes[0] == 'catalog')
		{
            $application = 'catalog';
            unset($routes[0]);
		}
		else if($routes[0] == 'admin')
		{
            $application = 'admin';
            unset($routes[0]);
		}
		else
		{
			print 'ERROR: application not specified (eg.: admin or catalog): '.PHP_EOL;
			exit(2);
        }
        
        if($application == 'admin')
        {
            $generate_file = $application."/view/template/".implode('/',$routes).".twig";
            $generate_content = '{{ header }}{{ column_left }}
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
            </div>
            <h1>{{ heading_title }}</h1>
            <ul class="breadcrumb">
                {% for breadcrumb in breadcrumbs %}
                <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>
                {% endfor %}
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        {% if error_warning %}
        <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        {% endif %}
        {% if success %}
        <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> {{ success }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        {% endif %}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

            </div>
        </div>
    </div>
</div>
{{ footer }}';
            // write Controller file
            if($this->save_file($generate_file,$generate_content) == false)
            {
			    print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
			    exit(2);
            }
        }
            
        if($application == 'catalog')
        {
            $generate_file = $application."/view/theme/default/template/".implode('/',$routes).".twig";
            $div_id = implode("-",array_map('ucfirst',$routes));
		    $generate_content = '{{ header }}
<div id="'.$div_id.'" class="container">
<ul class="breadcrumb">
    {% for breadcrumb in breadcrumbs %}
    <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>
    {% endfor %}
</ul>
<div class="row">{{ column_left }}
    {% if column_left and column_right %}
    {% set class = \'col-sm-6\' %}
    {% elseif column_left or column_right %}
    {% set class = \'col-sm-9\' %}
    {% else %}
    {% set class = \'col-sm-12\' %}
    {% endif %}
    <div id="content" class="{{ class }}">{{ content_top }}
        <h1>{{ heading_title }}</h1>
        {{ content_bottom }}</div>
    {{ column_right }}</div>
</div>
{{ footer }}';
            // write file
            if($this->save_file($generate_file,$generate_content) == false)
            {
			    print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
			    exit(2);
            }
        }
    }

    function write_controller($name=false)
    {
        // eg. admin/tool/test
        $name = trim($name);
		$name = trim($name,'/');

		$routes = explode('/', $name);

		if($routes[0] == 'catalog')
		{
            $application = 'catalog';
            unset($routes[0]);
		}
		else if($routes[0] == 'admin')
		{
            $application = 'admin';
            unset($routes[0]);
		}
		else
		{
			print 'ERROR: application not specified (eg.: admin or catalog): '.PHP_EOL;
			exit(2);
        }
        
        $class = 'controller';

        if($application == 'admin')
		{
            $generate_file = $this->oc_dir.''.$application."/controller/".implode('/',$routes).".php";
            $controller = "Controller".implode("",array_map('ucfirst',$routes));
            $controller = str_replace('_', '',$controller); 
            $path = implode("/",$routes);
            $extension_add = "";

            if(in_array('extension', $routes))
            {
                $extension_add = 'public function install() {

    $this->load->model(\'user/user_group\');

    $this->model_user_user_group->addPermission($this->user->getId(), \'access\', \''.implode('/',$routes).'\');
    $this->model_user_user_group->addPermission($this->user->getId(), \'modify\', \''.implode('/',$routes).'\');
}

public function uninstall() {

}
';
            }

            $generate_content = '<?php
class '.$controller.' extends Controller {
    private $error = array();

    public function index() {
        // Loading language file
        $this->load->language(\''.$path.'\');

        $this->document->setTitle($this->language->get(\'heading_title\'));

        if (isset($this->session->data[\'error\'])) {
            $data[\'error_warning\'] = $this->session->data[\'error\'];

            unset($this->session->data[\'error\']);
        } elseif (isset($this->error[\'warning\'])) {
            $data[\'error_warning\'] = $this->error[\'warning\'];
        } else {
            $data[\'error_warning\'] = \'\';
        }

        if (isset($this->session->data[\'success\'])) {
            $data[\'success\'] = $this->session->data[\'success\'];

            unset($this->session->data[\'success\']);
        } else {
            $data[\'success\'] = \'\';
        }

        $data[\'breadcrumbs\'] = array();

        $data[\'breadcrumbs\'][] = array(
            \'text\' => $this->language->get(\'text_home\'),
            \'href\' => $this->url->link(\'common/dashboard\', \'user_token=\' . $this->session->data[\'user_token\'], true)
        );

        $data[\'breadcrumbs\'][] = array(
            \'text\' => $this->language->get(\'heading_title\'),
            \'href\' => $this->url->link(\''.$path.'\', \'user_token=\' . $this->session->data[\'user_token\'], true)
        );

        $data[\'header\'] = $this->load->controller(\'common/header\');
        $data[\'column_left\'] = $this->load->controller(\'common/column_left\');
        $data[\'footer\'] = $this->load->controller(\'common/footer\');

        $this->response->setOutput($this->load->view(\''.$path.'\', $data));
    }'.$extension_add.'
}';

            // write Controller file
            if($this->save_file($generate_file,$generate_content) == false)
            {
			    print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
			    exit(2);
            }
        }
        if($application == 'catalog')
		{
            $generate_file = $this->oc_dir.''.$application."/controller/".implode('/',$routes).".php";
            $controller = "Controller".implode("",array_map('ucfirst',$routes));
            $path = implode("/",$routes);
            $generate_content = '<?php
class '.$controller.' extends Controller {
    public function index() {
        $this->load->language(\''.$path.'\');

        $this->load->model(\''.$path.'\');

        $data[\'breadcrumbs\'] = array();

        $data[\'breadcrumbs\'][] = array(
            \'text\' => $this->language->get(\'text_home\'),
            \'href\' => $this->url->link(\'common/home\')
        );

        $this->document->setTitle($this->language->get(\'heading_title\'));

        $data[\'breadcrumbs\'][] = array(
            \'text\' => $this->language->get(\'heading_title\'),
            \'href\' => $this->url->link(\'common/home\')
        );

        $data[\'continue\'] = $this->url->link(\'common/home\');

        $data[\'column_left\'] = $this->load->controller(\'common/column_left\');
        $data[\'column_right\'] = $this->load->controller(\'common/column_right\');
        $data[\'content_top\'] = $this->load->controller(\'common/content_top\');
        $data[\'content_bottom\'] = $this->load->controller(\'common/content_bottom\');
        $data[\'footer\'] = $this->load->controller(\'common/footer\');
        $data[\'header\'] = $this->load->controller(\'common/header\');

        $this->response->setOutput($this->load->view(\''.$path.'\', $data));
    }
}';
            // write Controller file
            if($this->save_file($generate_file,$generate_content) == false)
            {
			    print 'ERROR: write failed: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
			    exit(2);
            }  
        }
    }

    function save_file($generate_file,$generate_content)
    {
        if(is_file($generate_file))
        {  
            print 'file already exists: '.str_replace($this->oc_dir, "", $generate_file).PHP_EOL;
            exit(2);
        }
        $dir = dirname($generate_file);
        if(!is_dir($dir))
        {
            mkdir($dir,0755, true);
        }
        $this->new_files_add[] = $generate_file;
        return file_put_contents($generate_file,$generate_content);
    }

    function extension()
    {
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: extension [CODE] [NAME]".PHP_EOL;
            exit(2);
        } 

        if(isset($this->params[3]))
        {
            $name = @$this->params[3];
            if($name)
            {
                if(!$this->is_param('--no-admin'))
                {
                    $this->write_controller('admin/extension/'.$name);
                    $this->write_model('admin/extension/'.$name);
                    $this->write_language('admin/extension/'.$name);
                    $this->write_template('admin/extension/'.$name);
                }

                if(!$this->is_param('--no-catalog'))
                {
                    $this->write_controller('catalog/extension/'.$name);
                    $this->write_model('catalog/extension/'.$name);  
                    $this->write_language('catalog/extension/'.$name);
                    $this->write_template('catalog/extension/'.$name);
                }


                if($this->new_files_add)
                {
                    foreach($this->new_files_add as $filepath)
                    {
                        $this->json_data['sources'][] = str_replace( getcwd().'/', '',$filepath);
                    }

                    $this->json_data['sources'] = array_unique($this->json_data['sources']);
    
                    $write = file_put_contents($this->ocmod_dir.$this->json_data['code'].".json", json_encode($this->json_data, JSON_PRETTY_PRINT));
                    if($write == false)
                    {
                        print 'json file write error'.PHP_EOL;
                        exit(2);
                    }
                }
            }
        }
        else
        {
            print "Required: extension [NAME] (eg: module/test)".PHP_EOL;
            exit(2);
        }
    }

    function install(){
        
        if(isset($this->params[2]))
        {
            $code = @$this->params[2];
            $this->code_load($code);
        }
        else
        {
            print "Required: install [CODE]".PHP_EOL;
            exit(2);
        }
        // add permission to ADMIN
        include($this->oc_dir.'config.php');

        $mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $mysqli->query("DELETE " . DB_PREFIX . "modification WHERE code = '" . $code . "'");

        $mysqli->query("INSERT INTO " . DB_PREFIX . "modification SET code = '" . $code . "', 
            `extension_install_id`='0',
            `date_added`='".date('Y-m-d H:i:s')."',
            `name`='".$this->json_data['name']."',
            `author`='".$this->json_data['author']."',
            `version`='".$this->json_data['version']."',
            `link`='".$mysqli->real_escape_string($this->json_data['link'])."',
            `xml`='".$mysqli->real_escape_string(file_get_contents($this->ocmod_dir.$code.".xml"))."',
            `status`=1
             ");
        print_r($mysqli);
        $mysqli->close();
    }
}

// Run app
$app = new OcMod;

if(!isset($app->params[1]) || $app->is_param('-v') || $app->is_param('--version'))
{
    print "OpenCart version: ".$app->opencart_version.PHP_EOL;
    print "OCmod version: ".OCmodVer.PHP_EOL;
    $files = glob($app->ocmod_dir.'*.json');
    print "OCmod modifications: ".count($files).PHP_EOL;

    if($files)
    {
        foreach($files as $file)
        {
            $data = json_decode(file_get_contents($file), true);
            print " - ".$data['name']." (".$data['version'].")".PHP_EOL;
        }
    }

    exit(0);
}

if(method_exists($app, $app->params[1]))
{
    $run = $app->params[1];
    $run = str_replace('-','_',$run);
    $app->{$run}();
}
else
{
    print 'Unkown function'.PHP_EOL;
    exit(1);
}
