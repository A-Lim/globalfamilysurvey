# globalfamilysurvey

<ol>
    <li>Edit .env file. Change your database settings.</li>
    <li>Make sure APP_TIMEZONE in env is set correctly</li>
    <li>Terminal, composer dump-autoload</li>
    <li>php artisan migrate:refresh --seed</li>
    <li>To enable queue, .edit env QUEUE_DRIVER to datatabase</li>
    <li>Install supervisor</li>
    <li>Setup cronjob</li>
</ol>
