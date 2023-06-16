<?php

use Illuminate\Support\Facades\Validator;

/* Helper For Validation Incoming Data **/

function storeImage($file, $disk = 'public')
{
    $path = $file->store('images', $disk);
    return  sprintf('storage/%s', $path);
}

function validateForm($request, $inputs)
{
    return Validator::make($request, $inputs)->validate();
}
