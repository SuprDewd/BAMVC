<?php

class RecaptchaHelper
{
	protected $Recaptcha;
	
	public function __construct($view, $controller)
	{
		$this->Recaptcha = $controller->LoadComponent('Recaptcha');
	}
	
	public function GetHtml($pubkey = null)
	{
		return $this->Recaptcha->GetHtml($pubkey !== null ? $pubkey : Config::Read('Recaptcha.PublicKey'));
	}
	
	public function WithTheme($themeName)
	{
		return '<script type="text/javascript">var RecaptchaOptions={theme:\'' . $themeName . '\'};</script>';
	}
}