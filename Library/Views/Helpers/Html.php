<?php

class HtmlHelper
{
	public function Link($content, $href, $attrs = array())
	{
		return $this->RawLink($content, WebRoot . $href, $attrs);
	}
	
	public function RawLink($content, $href, $attrs = array())
	{
		$attrs['href'] = $href;
		return '<a' . $this->FormatAttributes($attrs) . '>' . $title . '</a>';
	}
	
	public function Css($file, $parse = false, $attrs = array())
	{
		$attrs['href'] = $this->Content('css/' . $file) . ($parse ? '?parse' : '');
		$attrs['rel'] = 'stylesheet';
		return $this->Element('link', null, $attrs);
	}
	
	public function Js($file, $attrs = array())
	{
		$attrs['src'] = $this->Content('js/' . $file);
		return $this->Element('script', '', $attrs);
	}
	
	private function Element($element, $content = null, $attrs = array())
	{
		return '<' . $element . $this->FormatAttributes($attrs) . ($content === null ? ' />' : '>' . $content . '</' . $element . '>');
	}
	
	public function Content($file)
	{
		return WebRoot . $file;
	}
	
	private function FormatAttributes($attrs)
	{
		if ($attrs === null) return '';
		
		$s = '';
		$first = true;
		
		foreach ($attrs as $attr => $value) $s .= ' ' . $attr . '="' . $value . '"';
		return $s === '' ? ' ' : $s;
	}
}