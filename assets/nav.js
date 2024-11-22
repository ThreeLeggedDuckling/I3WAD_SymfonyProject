import './styles/nav.css';

let url = window.location.href;
// console.log('url :>> ', url);

// $(document).ready(function() {});    -> .ready() déprécié
$.when($.ready).then(function(){
    $('ul.navbar-nav a').filter(function(){
        return this.href == url;
    }).addClass('active');
});