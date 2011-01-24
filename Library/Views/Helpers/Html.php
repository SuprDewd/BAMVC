<?php

class HtmlHelper
{
	public function Escape($string)
	{
		return htmlspecialchars($string);
	}
	
	public function UrlEscape($string)
	{
		return urlencode($string);
	}
	
	public function Link($content, $href, $attrs = array())
	{
		return $this->RawLink($content, WebRoot . $href, $attrs);
	}
	
	public function RawLink($content, $href, $attrs = array())
	{
		$attrs['href'] = $href;
		return '<a' . $this->FormatAttributes($attrs) . '>' . $content . '</a>';
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

	public function CreateForm($action = '', $method = 'post', $attrs = array())
	{
		$attrs['action'] = WebRoot . $action;
		$attrs['method'] = $method;
		return '<form' . $this->FormatAttributes($attrs) . '>';
	}
	
	public function Label($label, $for = null, $attrs = array())
	{
		$attrs['for'] = $for;
		return $this->Element('label', $label, $attrs);
	}
	
	public function Submit($title, $attrs = array())
	{
		$attrs['value'] = $title;
		$attrs['type'] = 'submit';
		return $this->Element('input', null, $attrs);
	}
	
	public function Input($type = 'text', $content = null, $attrs = array())
	{
		$attrs['type'] = $type;		
		return $this->Element('input', $content, $attrs);
	}
	
	public function EndForm()
	{
		return '</form>';
	}
	
	private function FormatAttributes($attrs)
	{
		if ($attrs === null) return '';
		
		$s = '';
		$first = true;
		
		foreach ($attrs as $attr => $value) if ($value !== null) $s .= ' ' . $attr . '="' . $value . '"';
		return $s === '' ? ' ' : $s;
	}
}