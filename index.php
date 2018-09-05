<?php
    $result = file_get_contents("https://cryptocurrencynews.com/feed/");
    $xml = new SimpleXMLElement($result);
    
    $internalErrors = libxml_use_internal_errors(true);
    
    foreach ($xml->channel->item as $key => $value) {
        $title = $value->title;
        $link_url = $value->link;
        $date = $value->pubDate;
        $description = "";
        $image = "";

        echo "Title : $value->title <br>";
        echo "Link : $link_url <br>";
        echo "Date : $date <br>";

        foreach ($value->description as $descriptionNode) {
            $descriptionDom = new DOMDocument();
            $descriptionDom->loadHTML((string)$descriptionNode);
            $description_sxml = simplexml_import_dom($descriptionDom);

            $imgs = $description_sxml->xpath('//img');
            $image = $imgs[0]['src'];

            $paragraphs = $description_sxml->xpath('//p');
            
            foreach ($paragraphs as $paragraph) {
                if(isset($paragraph->a)){
                    break;
                }
                $description .= (string)$paragraph . " ";
                
            }
            $description .= "<a href='$link_url'>Read More</a>";
        }

        
        echo "Image : $image <br>";
        echo "Description : $description <br><br>";
    }
    
    libxml_use_internal_errors($internalErrors);
?>