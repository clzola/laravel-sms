<?php

namespace clzola\Components\Sms\Drivers;

use clzola\Components\Sms\Exceptions\SmsException;

class AndroidEmulatorDriver extends Driver
{
    /**
     * @var string Path to android sdk
     */
    private $androidSdkPath;


    /**
     * @var string Number of the sender to be shown on the emulator
     */
    private $senderNumber;


    /**
     * AndroidEmulatorDriver constructor.
     *
     * @param string $androidSdkPath Path to android sdk
     * @param string $senderNumber Number of the sender to be shown on the emulator
     */
    public function __construct(string $androidSdkPath, string $senderNumber)
    {
        $this->androidSdkPath = rtrim($androidSdkPath, DIRECTORY_SEPARATOR);
        $this->senderNumber = $senderNumber;
    }


    /**
     * Send the given message to given recipient.
     *
     * @return void
     * @throws SmsException
     */
    public function send()
    {
        $adbPath = $this->getAdbToolPath();

        $command = "$adbPath emu sms send {$this->senderNumber} \"{$this->message}\"";

        $output = trim(shell_exec($command));

        if($output !== "OK")
            throw new SmsException("Failed to send sms to Android emulator: $output");
    }


    /**
     * @throws SmsException
     */
    protected function getAdbToolPath()
    {
        if(!file_exists($this->androidSdkPath)) {
            throw new SmsException("Specified Android SDK path does not exists: {$this->androidSdkPath}");
        }

        if(!file_exists($this->androidSdkPath . DIRECTORY_SEPARATOR . "platform-tools")) {
            throw new SmsException("Cannot find Android SDK at specified path: {$this->androidSdkPath}");
        }

        $adbPath = join(DIRECTORY_SEPARATOR, [$this->androidSdkPath, "platform-tools", "adb"]);

        if(!file_exists($adbPath) && !file("$adbPath.exe")) {
            throw new SmsException("Cannot find ADB at $adbPath");
        }

        return $adbPath;
    }
}