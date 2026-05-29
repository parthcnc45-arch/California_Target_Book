<?php

namespace App\Listeners;

use App\User;
use App\Jobs\SendAdminNotification;

class AdminNotifySubscriber
{

    private function getAdminForSetting($setting)
    {
        return User::where('role', User::ROLE_ADMIN)
            ->whereHas('settings', function ($q) use ($setting) {
                $q->where($setting, true);
            })
            ->get();
    }

    public function onNewSubscriber($event)
    {
        $sub = $event->subscriber->latestSubscription();

        $this->getAdminForSetting('admin_notify_signup')
            ->each(function ($admin) use ($sub) {
                dispatch(new SendAdminNotification([
                    'admin' => $admin,
                    'message' => 'Someone just subscribed to the Target Book.',
                    'link' => "/ctb-admin/subscriptions/$sub->id"
                ]));
            });
    }

    public function onFeedbackPosted($event)
    {
        $users = $this->getAdminForSetting('admin_notify_feedback');
        $users->each(function ($admin) {
            dispatch(new SendAdminNotification([
                'admin' => $admin,
                'message' => 'Someone just left some feedback about the Target Book.',
                'link' => "/ctb-admin/feedback"
            ]));
        });

    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\NewSubscriber',
            'App\Listeners\AdminNotifySubscriber@onNewSubscriber'
        );

        $events->listen(
            'App\Events\FeedbackPosted',
            'App\Listeners\AdminNotifySubscriber@onFeedbackPosted'
        );
    }
}
