<?php

namespace App\Controller;

use App\Security\OTPService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/otp")
 */
class OTPController extends AbstractController {

    private OTPService $otpService;

    public function __construct(OTPService $otpService) {

        $this->otpService = $otpService;
    }

    /**
     * @Route("/generate", name="generateOTP", methods={"GET"})
     */
    public function generate(): Response {

        $this->otpService->generateOTP($this->getUser()->getPhoneNumber());

        return $this->json([
            'message' => 'OTP sent to registered phone number!',
        ]);
    }

    /**
     * @Route("/verify", name="verifyOTP", methods={"POST"})
     */
    public function verify(Request $request): Response {

        $otp = $request->toArray()['otp'];
        $phoneNumber = $this->getUser()->getPhoneNumber();

        if (!$this->otpService->isValidOTP($otp, $phoneNumber)) {
            return $this->json([
                'error' => 'Invalid OTP provided'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'message' => 'Success!!!',
        ]);
    }
}
