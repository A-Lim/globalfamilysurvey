<?php

namespace App\Mail;

use App\Setting;
use App\Survey;
use App\Church;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    // unencrypted password
    protected $password;
    protected $survey_base_url;
    protected $surveys;
    protected $church;
    protected $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $type)
    {
        $this->user = $user;
        $this->password = $password;
        $this->survey_base_url = Setting::where('key', 'survey_base_url')->firstOrFail();
        $this->surveys = Survey::all();
        $this->church = Church::where('id', $this->user->church_id)->firstOrFail();
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@globalfamilychallenge.com', 'Global Family Survey')
                    ->subject('Welcome to Global Family Survey')
                    ->markdown('emails.welcome')->with([
                            'user' => $this->user,
                            'password' => $this->password,
                            'type' => $this->type,
                            'church' => $this->church,
                            'survey_base_url' => $this->survey_base_url,
                            'surveys' => $this->surveys,
                        ]);
    }
}
