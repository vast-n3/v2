<?php
$save = 'cursor-pointer cursor-not-allowed grow-x-infinite b-1 hover:raise-1-gray-light text-white bg-transparent hover\:text-white';
$save .= ' swipe-enter-active swipe-enter-from swipe-leave-from slide-fade-enter-active';
$save .= ' slide-fade-leave-active grid-4-4-4 grind-3-3-3-3 grid-6-6';
$classes = explode(' ',$save);

/*
 * Maintain theming
 *
 * */

foreach (['primary', 'accent', 'warning', 'success', 'black'] as $main){
    $classes[] = "bg-$main";
    $classes[] = "b-$main";
    $classes[] = "text-$main";
    $classes[] = "hover\:bg-$main";
    foreach (['light','lighter','dark','darker'] as $modifier){
        $classes[] = "bg-$main-$modifier";
        $classes[] = "b-$main-$modifier";
        $classes[] = "text-$main-$modifier";
        $classes[] = "hover\:bg-$main-$modifier";
    }
}



foreach(glob('component/*/*.vue')as $file){
    parseClasses(file_get_contents($file));
}
foreach(glob('component/Ui/*/*.vue')as $file){
    parseClasses(file_get_contents($file));
}
function parseClasses($content) {
    global $classes;
    preg_match_all('/ class="([^"]+)/', $content, $matches);
    if(!empty($matches[1])){
        foreach ($matches[1] as $hit){
            $allHits = explode(' ', $hit);
            foreach ($allHits as $class){
                $class = str_replace(':','\:', $class);
                if(!in_array($class, $classes)){
                    $classes[] = $class;
                }
            }
        }
    }
}
foreach ($classes as $i => $class){
    $classes[$i] = preg_replace('/(hover|focus|active)\\\:[^\s]+/','$0:$1', $class);
}

$cssPath = 'frame/VastN3/css/index.css';
$css = file_get_contents($cssPath);
// remove unused classes
$newCss = preg_replace_callback('/^\s*\.([a-z0-9\\\:-]+)\s{[^}]+}\n/m', function($hit) use($classes){
    if(!empty($hit[1])&& !in_array($hit[1],$classes)){
        return '';
    }
    return $hit[0];

}, $css);
// remove comments
$newCss = preg_replace('/\/\*.+\*\//m', '', $newCss);

// remove unused media queries
$newCss = preg_replace('/@media\s\([a-z0-9:\s-]+\)\s\{\n\}/m', '', $newCss);

// remove new-line characters
$newCss = preg_replace('/\n/m', ' ', $newCss);
file_put_contents($cssPath, $newCss);