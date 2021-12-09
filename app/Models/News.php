<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public static function getNews()
    {
        $html =  file_get_html("https://www.techrum.vn");
        $getPosts = $html->find("div.block-container.porta-article-container");
        $posts = [];

        for ($i =  0; $i < count($getPosts); $i++) {
            $post = [];
            $post["title"] = trim($getPosts[$i]->find("h2.block-header a", 0)->innertext);
            $post["href"] = trim($getPosts[$i]->find("h2.block-header a", 0)->href);
            $post["author"] = trim($getPosts[$i]->find("ul.listInline.listInline--bullet a.u-concealed", 0)->innertext);
            $post["time"] = trim($getPosts[$i]->find("ul.listInline.listInline--bullet a.u-concealed time.u-dt", 0)->innertext);
            $post["view"] = trim($getPosts[$i]->find("div.message-attribution-opposite ul.listInline.listInline--bullet li", 0)->plaintext);
            $post["image"] = trim($getPosts[$i]->find("div.bbWrapper img", 0)->src);
            $post["content"] = trim($getPosts[$i]->find("div.bbWrapper ", 0)->plaintext);
            $posts[] = $post;
        }

        return $posts;
    }
}
