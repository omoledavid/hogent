<?php

use App\Http\Controllers\SmsMail\MailController;
use App\Http\Controllers\SmsMail\SmsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sms-mail', 'as' => 'sms-mail.', 'middleware' => ['auth']], function () {
    Route::get('sms', [SmsController::class, 'index'])->name('sms');
    Route::post('sms-send', [SmsController::class, 'send'])->name('sms.send');
    Route::post('sms-test-send', [SmsController::class, 'testSend'])->name('sms.test.send');

    Route::get('mail', [MailController::class, 'index'])->name('mail');
    Route::post('mail-send', [MailController::class, 'send'])->name('mail.send');

    //email template
    Route::get('templates', [MailController::class, 'templates'])->name('template');
    Route::get('templates/{id}', [MailController::class, 'templatesEdit'])->name('template.edit');
    Route::post('templates/update/{id}', [MailController::class, 'templatesUpdate'])->name('template.update');
});
