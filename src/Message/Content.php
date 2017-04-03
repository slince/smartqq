<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message;

class Content
{
    /**
     * 消息内容
     * @var string
     */
    protected $content;

    /**
     * 消息内容字体
     * @var Font
     */
    protected $font;

    /**
     * Content constructor.
     * @param string $content 消息内容正文
     * @param Font $font 消息内容字体
     */
    public function __construct($content, Font $font = null)
    {
        $this->content = $content;
        $this->font = $font;
    }

    /**
     * 魔术方法
     * @return string
     */
    public function __toString()
    {
        $font = $this->getFont() ?: Font::createDefault();
        return \GuzzleHttp\json_encode([
            $this->getContent(),
            [
                'font',
                $font->toArray()
            ]
        ]);
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param Font $font
     */
    public function setFont($font)
    {
        $this->font = $font;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return Font
     */
    public function getFont()
    {
        return $this->font;
    }
}
