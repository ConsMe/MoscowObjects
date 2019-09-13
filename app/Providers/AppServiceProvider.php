<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {

            return new ConfirmEmail($verificationUrl, $notifiable);

            // return (new MailMessage)
            //     ->subject(Lang::getFromJson('Подтверждение email'))
            //     ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
            //     ->action(Lang::getFromJson('Verify Email Address'), $verificationUrl)
            //     ->line(Lang::getFromJson('If you did not create an account, no further action is required.'))
            //     ->salutation('');
        });
    }
}
