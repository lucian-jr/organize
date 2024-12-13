<?php
	// Funções de URL
	
	function base_url($uri = '', $protocol = null)
	{
		$protocol = $protocol ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');

		$host = $_SERVER['HTTP_HOST'];

		$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

		return $protocol . '://' . $host . $base_path . '/' . ltrim($uri, '/');
	}

	function assets_url($dir = null)
	{
		$dir = ($dir) ? $dir . "/" : null;

		return base_url('assets') . '/' . $dir;
	}
