<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message;

class Content
{
    /**
     * 消息内容.
     *
     * @var string
     */
    protected $content;

    /**
     * 消息内容字体.
     *
     * @var Font
     */
    protected $font;

    /**
     * 表情.
     *
     * @var array
     */
    protected static $faceTexts = [
        '微笑', '撇嘴', '色', '发呆', '得意', '流泪', '害羞', '闭嘴', '睡', '大哭', '尴尬', '发怒', '调皮', '呲牙', '惊讶', '难过', '酷', '冷汗', '抓狂', '吐',
        '偷笑', '可爱', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '折磨', '衰', '骷髅', '敲打', '再见',
        '擦汗', '抠鼻', '鼓掌', '糗大了', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓',
        '咖啡', '饭', '猪头', '玫瑰', '凋谢', '示爱', '爱心', '心碎', '蛋糕', '闪电', '炸弹', '刀', '足球', '瓢虫', '便便', '月亮', '太阳', '礼物', '拥抱', '强',
        '弱', '握手', '胜利', '抱拳', '勾引', '拳头', '差劲', '爱你', 'NO', 'OK', '爱情', '飞吻', '跳跳', '发抖', '怄火', '转圈', '磕头', '回头', '跳绳', '挥手',
        '激动', '街舞', '献吻', '左太极', '右太极', '双喜', '鞭炮', '灯笼', '发财', 'K歌', '购物', '邮件', '帅', '喝彩', '祈祷', '爆筋', '棒棒糖', '喝奶', '下面', '香蕉',
        '飞机', '开车', '左车头', '车厢', '右车头', '多云', '下雨', '钞票', '熊猫', '灯泡', '风车', '闹钟', '打伞', '彩球', '钻戒', '沙发', '纸巾', '药', '手枪', '青蛙',
    ];

    /**
     * 表情索引.
     *
     * @var array
     */
    protected static $faceIndexs = [
        14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
        0, 50, 51, 96, 53, 54, 73, 74, 75, 76, 77, 78, 55, 56,
        57, 58, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 97, 98,
        99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112,
        32, 113, 114, 115, 63, 64, 59, 33, 34, 116, 36, 37, 38, 91,
        92, 93, 29, 117, 72, 45, 42, 39, 62, 46, 47, 71, 95, 118,
        119, 120, 121, 122, 123, 124, 27, 21, 23, 25, 26, 125, 126, 127,
        128, 129, 130, 131, 132, 133, 134, 136, 137, 138, 139, 140, 141, 142,
        143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156,
        157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170,
    ];

    /**
     * Content constructor.
     *
     * @param string $content 消息内容正文
     * @param Font   $font    消息内容字体
     */
    public function __construct($content, Font $font = null)
    {
        $this->content = $content;
        $this->font = $font;
    }

    /**
     * 魔术方法.
     *
     * @return string
     */
    public function __toString()
    {
        return \GuzzleHttp\json_encode($this->parseFaceContents());
    }

    protected function parseFaceContents()
    {
        $content = preg_replace('#\[([A-Z\x{4e00}-\x{9fa5}]{1,20}?)\]#ui', '@#[$1]@#', $this->getContent());
        $chunks = explode('@#', $content);
        $contents = [];
        foreach ($chunks as $chunk) {
            if (!$chunk) {
                continue;
            }
            $faceText = trim($chunk, '[]');
            if ($faceId = static::searchFaceId($faceText)) {
                $contents[] = ['face', $faceId];
            } else {
                $contents[] = $chunk;
            }
        }
        $font = $this->getFont() ?: Font::createDefault();
        $contents[] = [
            'font',
            $font->toArray(),
        ];

        return $contents;
    }

    /**
     * 查找表情对应的ID.
     *
     * @param string $faceText
     *
     * @return int|null
     */
    public static function searchFaceId($faceText)
    {
        if (false !== ($key = array_search($faceText, static::$faceTexts))) {
            return isset(static::$faceIndexs[$key]) ? static::$faceIndexs[$key] : null;
        }

        return null;
    }

    /**
     * 查找表情描述.
     *
     * @param int $faceId
     *
     * @return string|null
     */
    public static function searchFaceText($faceId)
    {
        if (false !== ($key = array_search($faceId, static::$faceIndexs))) {
            return isset(static::$faceTexts[$key]) ? static::$faceTexts[$key] : null;
        }

        return null;
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
