<?php
namespace App\Mail;

// use App\Setting;
// use App\Survey;
// use App\Church;
use App\Repositories\ChurchRepositoryInterface;
use App\Repositories\SurveyRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    // unencrypted password
    private $password;
    private $type;

    private $churchRepository;
    private $surveyRepository;
    private $settingsRepository;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $type)
    {
        $this->churchRepository = resolve(ChurchRepositoryInterface::class);
        $this->surveyRepository = resolve(SurveyRepositoryInterface::class);
        $this->settingsRepository = resolve(SettingsRepositoryInterface::class);

        $this->user = $user;
        $this->password = $password;
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
                        'church' => $this->churchRepository->find($this->user->church_id),
                        'survey_base_url' => $this->settingsRepository->get('survey_base_url'),
                        'surveys' => $this->surveyRepository->all(),
                    ]);
    }
}
