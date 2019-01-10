<?php
/**
 * Classe parsant un fichier xml et affichant les informations sous la forme
 * d'une hierarchie de texte
 */
class XmlParser
{
    private $path;
    private $result;
    private $depth;

    private $sourceTitle;
    private $sourceImage = null;
    private $currentItem;

    private $isItem;
    private $isTitle;
    private $isLink;
    private $isDesc;
    private $isPubDate;
    private $isImg;
    private $isImgUrl;
     
    public function __construct($path, $sourceTitle)
    {
        $this -> path = $path;
        $this->sourceTitle=$sourceTitle;
        $this -> depth = 0;
    }
     
    public function getResult()
    {
        return $this->result;
    }
     
    /**
     * Parse le fichier et met le resultat dans Result
     */
    public function parse()
    {
        ob_start();
        $xml_parser = xml_parser_create();
        xml_set_object($xml_parser, $this);
        xml_set_element_handler($xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($xml_parser, 'characterData');
        if (!($fp = fopen($this -> path, "r"))) {
            // die("could not open XML input");
            throw new Exception("could not open XML input on ".$this->path);
            
        }
 
        while ($data = fread($fp, 4096)) {
            if (!xml_parse($xml_parser, $data, feof($fp))) {
                // die(sprintf(
                //     "XML error: %s at line %d on feed %s",
                //             xml_error_string(xml_get_error_code($xml_parser)),
                //             xml_get_current_line_number($xml_parser),
                //             $this->path
                // ));
                throw new Exception(sprintf(
                    "XML error: %s at line %d on feed %s",
                            xml_error_string(xml_get_error_code($xml_parser)),
                            xml_get_current_line_number($xml_parser),
                            $this->path
                ));
            }
        }
         
        $this -> result = ob_get_contents();
        ob_end_clean();
        fclose($fp);
        xml_parser_free($xml_parser);
    }
     
    private function startElement($parser, $name, $attrs)
    {
        switch ($name) {
            case 'ITEM':
                $this->currentItem = new News();
                $this->currentItem->setWebsite($this->sourceTitle);
                $this->isItem = true;
                break;
            case 'TITLE':
                $this->isTitle = true;
                break;
            case 'LINK':
                $this->isLink = true;
                break;
            case 'DESCRIPTION':
                $this->isDesc = true;
                break;
            case 'PUBDATE':
                $this->isPubDate = true;
                break;
            case 'IMAGE':
                $this->isImg = true;
                break;
            case 'URL':
                $this->isImgUrl = true;
                break;
            case 'MEDIA:THUMBNAIL':
            case 'ENCLOSURE':
                if($this->isItem) $this->setUrl($attrs);
                break;
        }
    }

    private function setUrl($attrs) {
        foreach ($attrs as $attr => $txt) {
            if($attr=="URL") {
                $this->currentItem->setImage($txt);
            }
        }
    }
 
    private function endElement($parser, $name)
    {
        switch ($name) {
            case 'ITEM':
                $mdlNews = new MdlNews();
                if (!$this->currentItem->getImage()) {
                    $this->currentItem->setImage($this->sourceImage);
                }
                if(!$mdlNews->getNewsByUrl($this->currentItem->getUrl())) {
                    // var_dump($this->currentItem);
                    $mdlNews->addNews($this->currentItem);
                }
                $this->isItem = false;
                break;
            case 'TITLE':
                $this->isTitle = false;
                break;
            case 'LINK':
                $this->isLink = false;
                break;
            case 'DESCRIPTION':
                $this->isDesc = false;
                break;
            case 'PUBDATE':
                $this->isPubDate = false;
                break;
            case 'IMAGE':
                $this->isImg = false;
                break;
            case 'URL':
                $this->isImgUrl = false;
                break;
        }
    }
     
    private function characterData($parser, $data)
    {
        if(!$this->isItem) {
            // if($this->isTitle) $this->sourceTitle = $data;
            if($this->isImg && $this->isImgUrl) $this->sourceImage = $data;
        }
        if($this->isItem) {
            if($this->isTitle) {
                if(!$this->currentItem->getTitle()) {
                    $this->currentItem->setTitle(filter_var($data, FILTER_SANITIZE_STRING));
                } else {
                    $tmp = $this->currentItem->getTitle();
                    $this->currentItem->setTitle($tmp.filter_var($data, FILTER_SANITIZE_STRING));
                }
            }
            if($this->isDesc) {
                $data = preg_replace( "/\r|\n/", "", $data);
                $data = trim($data);
                $matches = [];
                $test = preg_match('/<img.*src="(.*)"/', $data, $matches);
                if($test!=0)
                    $this->currentItem->setImage($matches[1]);

                if(!$this->currentItem->getDescription()) {
                    $this->currentItem->setDescription(filter_var($data, FILTER_SANITIZE_STRING));
                } else {
                    $tmp = $this->currentItem->getDescription();
                    $this->currentItem->setDescription($tmp.filter_var($data, FILTER_SANITIZE_STRING));
                }
            }
            if($this->isLink) {
                if(!$this->currentItem->getUrl()) {
                    $this->currentItem->setUrl(filter_var($data, FILTER_SANITIZE_STRING));
                } else {
                    $tmp = $this->currentItem->getUrl();
                    $this->currentItem->setUrl($tmp.filter_var($data, FILTER_SANITIZE_STRING));
                }
            }
            if ($this->isPubDate) {
                $this->currentItem->setDate(date('d/m/Y G:i:s', strtotime(filter_var($data, FILTER_SANITIZE_STRING))));
            }
        }
    }
}
