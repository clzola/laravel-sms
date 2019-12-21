<?php

namespace clzola\Components\Sms\Console\Commands;

use clzola\Components\Sms\Contracts\HasPhoneNumber;
use clzola\Components\Sms\Exceptions\SmsCommandException;
use clzola\Components\Sms\Facades\SMS;
use Illuminate\Console\Command;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send 
                            {phone : Phone number or ID of entity} 
                            {message : A message to be sent} 
                            {--m|model= : Specify which model to use to retrieve instance from database} 
                            {--d|driver= : The driver this command should use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends sms message to phone number or to model instance that implements HasPhoneNumber contract';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws SmsCommandException
     * @throws \clzola\Components\Sms\Exceptions\SmsException
     */
    public function handle()
    {
        $phone = $this->argument("phone");
        $message = $this->argument("message");

        $model = $this->option("model");

        if(!is_null($model)) {
            $implementations = class_implements($model);
            if(!key_exists(HasPhoneNumber::class, $implementations)) {
                throw new SmsCommandException("Given model class does not implement HasPhoneNumber interface.");
            }

            $phone = $model::find($phone);
        }

        $phoneNumber = is_string($phone) ? $phone : $phone->getPhoneNumber();
        $this->info("Sending sms to $phoneNumber, message: $message");

        $driver = $this->option("driver");
        if(is_null($driver)) {
            SMS::to($phone)->content($message)->send();
        } else {
            SMS::channel($driver)->to($phone)->content($message)->send();
        }

        $this->info("Message sent.");
    }
}
