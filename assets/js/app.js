/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
//import $ from 'jquery';

var $ = require('jquery');
require('jquery-ui/ui/widgets/droppable');
require('jquery-ui/ui/widgets/sortable');
require('jquery-ui/ui/widgets/selectable');

require('webpack-jquery-ui');
require('webpack-jquery-ui/css');
require('webpack-jquery-ui/autocomplete');
require('webpack-jquery-ui/interactions');
require('webpack-jquery-ui/widgets');
require('webpack-jquery-ui/effects');



console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
console.log('yap yap');

$MyOptions= document.querySelectorAll('select[multiple="multiple"] option')
$MyOptions.forEach(element => {
    element.addEventListener("click",()=>{
        console.log(this.selected=this.selected ^ true);
    })
});