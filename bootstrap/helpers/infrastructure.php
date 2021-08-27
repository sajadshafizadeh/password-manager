<?php 

// To get the OS for makine a desicion on the command lines 
function getOS(){
    if (config('app.os') == 'windows'){ 
        return 'windows';
    } elseif (config('app.os') == 'linux') {
        return 'linux';
    } else {
        dd('Wrong OS defined');
    }
}