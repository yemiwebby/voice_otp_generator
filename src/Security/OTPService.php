<?php

namespace App\Security;

use Twilio\Rest\Client;
use Twilio\Rest\Verify\V2\ServiceContext;

class OTPService {

    private ServiceContext $twilio;

    public function __construct(
        string $twilioSID,
        string $twilioToken,
        string $twilioVerificationSID
    ) {

        $client = new Client($twilioSID, $twilioToken);
        $this->twilio = $client->verify->v2->services($twilioVerificationSID);
    }

    public function generateOTP(string $phoneNumber)
    : void {

        $this->twilio->verifications->create($phoneNumber, 'call');
    }

    public function isValidOTP(string $otp, string $phoneNumber)
    : bool {

        $verificationResponse = $this->twilio->verificationChecks->create($otp, [
            'to' => $phoneNumber
        ]);

        return $verificationResponse->status === 'approved';
    }
}