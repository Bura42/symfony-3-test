<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 05/07/18
 * Time: 10:46
 */

namespace AppBundle\Twig;


use AppBundle\Service\MarkdownTransformer;

class MarkdownExtension extends \Twig_Extension {

  private $MarkdownTransformer;

  public function __construct(MarkdownTransformer $MarkdownTransformer) {
    $this->MarkdownTransformer = $MarkdownTransformer;
  }

  public function getFilters() {
    return [
      new \Twig_SimpleFilter('markdownify', array($this, 'parseMarkdown'), [
        'is_safe' => ['html'],
      ]),
    ];
  }

  public function parseMarkdown($str) {
    return $this->MarkdownTransformer->parse($str);
  }

  public function getName() {
    return 'app_markdown';
  }

}