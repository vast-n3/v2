<?php


namespace Neoan3\Frame;


use DOMDocument;
use DOMXPath;
use Neoan3\Apps\Ops;
use Neoan3\Apps\Template;
use Neoan3\Core\Renderer;
use ScssPhp\ScssPhp\Compiler;

class VueRenderer implements Renderer
{

    public array $hooks = [];
    public array $browserImports = [];
    public array $loadedElements = [];
    private array $templateParameters = [];
    private string $title = '';
    public array $exposedParams = [
        'base' => base,
        '$nRoutes' => []
    ];
    public function __construct($constants = [])
    {
        $this->hooks = [
            'title' => $this->title,
            'current_endpoint' => OPS::toCamelCase(current_endpoint),
            'header' => '',
            'main' => '',
            'footer' => '',
            'components' => '',
            'templates' => '',
            'scripts' => '',
            'styles' => '',
            'base' => base,
            'spaRoutes' => ''
        ];
        foreach ([0,1,2,3,4] as $i => $p){
            $v = sub($p);
            $this->exposedParams['$nRoutes'][] = $v;
            $this->exposedParams['sub.'. $i] = $v;
        }
        $this->readConstants($constants);
    }

    private function readConstants($constants)
    {
        foreach ($constants['modules'] as $include) {
            $this->hooks['scripts'] .= "<script type='module' src=\"$include\"></script>";
        }
    }

    public function output($afterHooks = []): void
    {

        $this->hooks['browserImports'] = implode("", $this->browserImports);
        $compileScss = false;
        if($compileScss){
            $scss = new Compiler();
            $scss->addImportPath(path);
            file_put_contents(__DIR__ . '/css/index.css', $scss->compile(file_get_contents(__DIR__ . '/css/index.scss')));
        }
        $this->hooks['title'] = $this->title;

        echo Template::embraceFromFile('/frame/VastN3/scaffold.html', $this->hooks);
    }

    public function setComponentName($qualifiedClassName): void
    {
        // TODO: Implement setComponentName() method.
    }

    public function getComponentName(): string
    {
        // TODO: Implement getComponentName() method.
    }

    public function setLang(string $lang): void
    {
        // TODO: Implement setLang() method.
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function attachParameters($assocArray = []): void
    {
        $this->templateParameters = array_merge($this->templateParameters, $assocArray);
    }

    public function readTemplateTag($path)
    {
        $vueComponent = file_get_contents($path);
        preg_match("/<template>(.+)<\/template>[\r\n]*<(script|style)>/ms", $vueComponent, $ssrTemplate);
        return $ssrTemplate[1];
    }

    private function handleImports($script)
    {
        return preg_replace_callback('/(@)*import(\s[a-z]+\s)*(\((.+)\))*.+\n/i',function($hit){
            if(isset($hit[4])){
                $routes = json_decode($hit[4], true);
                foreach ($routes as $route){
                    foreach ($route as $name => $path){
                        $name = Ops::toPascalCase($name);
                        $this->hooks['spaRoutes'] .= "\nrouter.addRoute({path: '$path', component: n$name})";
                        if(!in_array($name,$this->loadedElements)){
                            $this->includeElement($name);
                        }
                    }
                }

            } elseif(!isset($this->browserImports[$hit[2]])) {
                $this->browserImports[$hit[2]] = $hit[0];
            }
            return "//requires $hit[2]\n";
        }, $script);
    }


    public function includeElement($element, $params =[]): VueRenderer
    {
        if(in_array($element, $this->loadedElements)){
            return $this;
        }
        $params = array_merge($this->exposedParams, $params);

        $path = path . '/component/'. ucfirst($element) . '/' . ucfirst($element) . '.vue';
        if(file_exists($path)){
            $this->loadedElements[] = $element;
            $params['template'] = $this->readTemplateTag($path);

            // remove ssr notations from template

            // attributes using curlies
            $params['template'] = preg_replace('/\s[a-z]+="{{[a-z\.]+}}"/i','', $params['template']);
            // n-x attributes?

            $doc = $this->loadDomDoc(file_get_contents($path));
            $script = $this->prepareScript($doc, $params);



            $this->attachStyles($doc,'n-' . Ops::toKebabCase($element));

            // handle imports & remove duplicates
            $script = $this->handleImports($script);

            // register globally
            $script = preg_replace('/export default/', "const n$element = ", $script);
            $script .= "\napp.component('n$element', n$element);";
            $this->hooks['components'] .= $script;
        }

        return $this;
    }


    public function assignToHook($name, $view, $params = []): void
    {
        $path = path . '/component/'. ucfirst($view) . '/' . ucfirst($view) . '.vue';
        $template = $this->readTemplateTag($path);
        $currentRoute = Ops::toCamelCase($view);
        $condition = $name === 'main' ? "v-if=\"\$route.path === '/$currentRoute'\"" : '';
        $this->hooks[$name] = "<n-$view $condition>". Template::embrace($template,$params) . "</n-$view>";
    }
    public function storeObject($constName, $value){
        $this->hooks['scripts'] .= "<script>\nstoreObjects.$constName.state = " . json_encode($value) . ';</script>';
    }

    public function prepareStyles(DOMDocument $doc, $selector=''): string
    {
        $style = '';
        $xPath = new DOMXPath($doc);
        $styleTags = $xPath->query('//style');
        if($styleTags){
            for($i=0;$i<$styleTags->length;$i++){
                $style .= $styleTags->item($i)->textContent;
            }

        }
        return $style;
    }

    private function attachStyles(DOMDocument $doc, $selector = '')
    {
        $xPath = new DOMXPath($doc);
        $tag = $xPath->query('//style')->item(0);
        if($tag){
            $pure = $doc->saveHTML($tag);
            if($tag->attributes->length > 0){
                foreach ($tag->attributes as $attribute){
                    switch($attribute->name){
                        case 'scoped':
                            $this->hooks['styles'] .= preg_replace('/\n([a-z#\.])/', "\n$selector $1", $pure);
                            break;
                        default:
                            $this->hooks['styles'] .= $pure;
                    }
                }
            } else {
                $this->hooks['styles'] .= $pure;
            }

        }
    }
    public function loadDomDoc($html) : DOMDocument
    {
        libxml_use_internal_errors(TRUE);
        // secure @-notation
        $html = preg_replace('/(@)([a-z-]+)=/i', 'v-on:$2=', $html);
        // secure #-notation
        $html = preg_replace('/(<template[a-z\s\"=-]+)(#)([a-z-]+)/i', '$1v-slot:$3', $html);

        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->loadHTML("<html>$html</html>",LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS );
        return $doc;
    }

    private function attachTemplateTag(DOMDocument $doc, &$params = [])
    {
        $xPath = new DOMXPath($doc);
        // template
        $template = mb_substr(Template::embrace(

            $doc->saveHTML($xPath->query('//template')->item(0)),
            $this->templateParameters
        ),mb_strlen('<template>'),mb_strlen('</template>') *-1);



        $params['template'] = $template;
    }
    public function prepareScript(DOMDocument $doc, $params)
    {

        $xPath = new DOMXPath($doc);
        $requiredComponents = $xPath->query('//*[starts-with(name(), "n-")]');
        foreach ($requiredComponents as $requiredComponent){
            $componentName = Ops::toPascalCase(mb_substr($requiredComponent->nodeName, 2));
            $this->includeElement($componentName);
        }
        $jsParams = [];
        foreach ($params as $key => $value){
            $jsParams[$key] = is_array($value) ? json_encode($value) : $value;
        }

        return Template::embrace(
            substr($doc->saveHTML($xPath->query('//script')->item(0)),9,-10),
            $jsParams
        );

    }
}