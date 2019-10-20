<?php
namespace App\Listeners;

use Mail;
use App\Mail\WelcomeMail;
use App\Events\UserRegistered;
use App\Events\NetworkRegistered;
use App\Events\ChurchRegistered;

class RegistrationEventSubscriber
{
    public function __construct() { }

    public function onChurchRegistered(ChurchRegistered $event) {
        Mail::to($event->user)
            ->send(new WelcomeMail($event->user, $event->password, 'church'));
    }

    public function onNetworkRegistered(NetworkRegistered $event) {
        Mail::to($event->user)
            ->send(new WelcomeMail($event->user, $event->password, 'network'));
    }

    public function onUserRegistered(UserRegistered $event) {
        Mail::to($event->user)
            ->send(new WelcomeMail($event->user, $event->password, 'user'));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
        $class = 'App\Listeners\RegistrationEventSubscriber';

        $events->listen(UserRegistered::class, "{$class}@onUserRegistered");
        $events->listen(ChurchRegistered::class, "{$class}@onChurchRegistered");
        $events->listen(NetworkRegistered::class, "{$class}@onNetworkRegistered");
    }
}
