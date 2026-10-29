<?php

use Amplify\System\Media\Http\Controllers\FileManagerController;
use Amplify\System\Media\Services\ConfigService\ConfigRepository;

$config = resolve(ConfigRepository::class);

// App middleware list
$middleware = $config->getMiddleware();

/**
 * If ACL ON add "fm-acl" middleware to array
 */
if ($config->getAcl()) {
    $middleware[] = 'fm-acl';
}

Route::group([
    'middleware' => $middleware,
    'prefix' => $config->getRoutePrefix(),
    'namespace' => 'Amplify\System\Media\Http\Controllers',
    'controller' => FileManagerController::class,
],
    function () {
        Route::get('initialize', 'initialize')->name('fm.initialize');
        Route::get('content', 'content')->name('fm.content');
        Route::get('tree', 'tree')->name('fm.tree');
        Route::get('select-disk', 'selectDisk')->name('fm.select-disk');
        Route::post('upload', 'upload')->name('fm.upload');
        Route::post('upload-chunk', 'chunkUpload')->name('fm.upload-chunk');
        Route::post('upload-chunk-finish', 'chunkUploadFinish')->name('fm.upload-chunk-finish');
        Route::post('upload-abort', 'chunkAbort')->name('fm.upload-abort');
        Route::post('delete', 'delete')->name('fm.delete');
        Route::post('paste', 'paste')->name('fm.paste');
        Route::post('rename', 'rename')->name('fm.rename');
        Route::get('download', 'download')->name('fm.download');
        Route::get('thumbnails', 'thumbnails')->name('fm.thumbnails');
        Route::get('preview', 'preview')->name('fm.preview');
        Route::get('url', 'url')->name('fm.url');
        Route::post('create-directory', 'createDirectory')->name('fm.create-directory');
        Route::post('create-file', 'createFile')->name('fm.create-file');
        Route::post('update-file', 'updateFile')->name('fm.update-file');
        Route::get('stream-file', 'streamFile')->name('fm.stream-file');
        Route::post('zip', 'zip')->name('fm.zip');
        Route::post('unzip', 'unzip')->name('fm.unzip');
        // Route::get('properties', 'properties');
        // Integration with editors
        Route::get('ckeditor', 'ckeditor')->name('fm.ckeditor');
        Route::get('tinymce', 'tinymce')->name('fm.tinymce');
        Route::get('tinymce5', 'tinymce5')->name('fm.tinymce5');
        Route::get('summernote', 'summernote')->name('fm.summernote');
        Route::get('fm-button', 'fmButton')->name('fm.fm-button');
    });
