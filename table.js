const URL_BUTTON = document.getElementById('url');
const HIDE = document.getElementById('hide_popup');

document.addEventListener('DOMContentLoaded', function(){

    URL_BUTTON.addEventListener('click', function(){
        document.getElementById('popup').style.display = 'block';
    });

    HIDE.addEventListener('click', function(){
        document.getElementById('popup').style.display = 'none';
    });
});
