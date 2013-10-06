<?php namespace DevAddiction\Website\Documents;

use Illuminate\Filesystem\Filesystem;
use DevAddiction\Website\FactoryInterface;

class DocumentFactory implements FactoryInterface {

	/**
	 * Illuminate filesystem instance.
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * Document parser instance.
	 *
	 * @var \DevAddiction\Website\Documents\DocumentParser
	 */
	protected $parser;

	/**
	 * Create a new article factory instance.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @param  \DevAddiction\Website\Documents\DocumentParser  $parser
	 * @return void
	 */
	public function __construct(Filesystem $files, DocumentParser $parser)
	{
		$this->files = $files;
		$this->parser = $parser;
	}

	/**
	 * Make a new document instance from the path to a document.
	 *
	 * @param  string  $absolutePath
	 * @param  string  $relativePath
	 * @return \DevAddiction\Website\Documents\Document
	 */
	public function make($absolutePath, $relativePath)
	{
		$parsed = $this->parser->parse($this->files->get($absolutePath), $relativePath);

		return new Document($parsed['slug'], $parsed['meta'], $parsed['content']);
	}

}
