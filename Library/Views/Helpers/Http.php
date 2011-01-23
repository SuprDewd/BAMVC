<?php

class HttpHelper
{
	public function Link($content, $href, $attrs = array())
	{
		$attrs['href'] = $href;
		return '<a' . $this->FormatAttributes($attrs) . '>' . $title . '</a>';
	}
	
	private function FormatAttributes($attrs)
	{
		if ($attrs === null) return '';
		
		$s = '';
		$first = true;
		
		foreach ($attrs as $attr => $value) $s .= ' ' . $attr . '="' . $value . '"';
		return $s;
	}
}