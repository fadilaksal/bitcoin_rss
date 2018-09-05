<?php
    $result = file_get_contents("https://cryptocurrencynews.com/feed/");
    $xml = new SimpleXMLElement($result);
    
    $internalErrors = libxml_use_internal_errors(true);
    
    foreach ($xml->channel->item as $key => $value) {
        $title = $value->title;
        $link_url = $value->link;
        $date = $value->pubDate;

        echo "Title : $value->title <br>";
        echo "Link : $link_url <br>";
        echo "Date : $date <br>";

        foreach ($value->description as $descriptionNode) {
            // print_r($descriptionNode);
            $descriptionDom = new DOMDocument();
            $descriptionDom->loadHTML((string)$descriptionNode);
            $description_sxml = simplexml_import_dom($descriptionDom);
            // print_r($description_sxml);
            // echo "<br><br>";

            $imgs = $description_sxml->xpath('//img');
            $image = $imgs[0]['src'];
            echo "Image : $image <br>";
            // foreach ($imgs as $image) {
            //     echo (string)$image['src'];
            // }
            
            echo "Description : ";

            $paragraphs = $description_sxml->xpath('//p');
            // print_r($paragraphs);
            // echo "<br><br>";
            foreach ($paragraphs as $paragraph) {
                if(isset($paragraph->a)){
                    break;
                }
                echo (string)$paragraph;
                echo " ";
            }

            // $link = $description_sxml->xpath('//a');
            // $link_url = (string)$link[0]['href'];

            echo " ";
            echo "<a href='$link_url'>Read More</a>";
            
        }
        // print_r($value->description);
        echo "<br><br>";
        // die();
    }
    
    libxml_use_internal_errors($internalErrors);
?>