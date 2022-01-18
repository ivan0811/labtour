<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use App\Models\{Island, Province, City, Tour};
use DB;


class ScrapingController extends Controller
{    
    public function index(){    
        $island = collect();                

        $content = file_get_contents('https://tempatwisataseru.com/');  

        // $provinsi = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi');     
        
        // $provinsi = collect(json_decode($provinsi));               

        $parseHtml = HtmlDomParser::str_get_html($content);
        $html_encode = htmlentities($parseHtml);                 

        foreach ($parseHtml->find('ul')[4]->children() as $key => $value) {                        
            
            $province = collect();

            foreach ($value->children() as $value2) {
                if($value2->tag == 'ul'){
                    foreach ($value2->children() as $value3) {
                        
                        $city = collect();
                        foreach ($value3->children() as $value4) {
                            if($value4->tag == 'ul'){
                                foreach ($value4->children() as $value5) {
                                    $city->push([
                                        'title' => $value5->children(0)->innertext,
                                        'url' => $value5->children(0)->href                                        
                                    ]);                                    
                                }
                            }                            
                        }                                                           

                        if(count($city) > 0){
                            $province->push([
                                'title' => $value3->children(0)->innertext,
                                'url' => $value3->children(0)->href,
                                'city' => $city
                            ]);
                        }else{
                            $city->push([
                                'title' => $value3->children(0)->innertext,
                                'url' => $value3->children(0)->href
                            ]);
                            $province->push([
                                'city' => $city
                            ]);
                        }                                                
                    }
                }
            }

            $island->push([
                'title' => $value->children(0)->innertext,
                'url' => $value->children(0)->href,
                'province' => $province
            ]);
        }        
    
        return $island;    
    }      

    public function storeWilayah(){
        // print_r(json_decode($this->index()));
        // echo $this->index();
        foreach (json_decode($this->index()) as $value) {            
            // echo 'island '.$value->title.'<br>';            
                $island = Island::create([
                    'name' => $value->title
                ]);

                foreach ($value->province as $key => $value1) {                    
                    if(isset($value1->title)){
                        $province = Province::create([
                            'island_id' => $island->id,
                            'name' => $value1->title
                        ]);
                        // echo 'province '.$value1->title.'<br>';
                        foreach ($value1->city as $value2) {
                            $city = City::create([
                                'province_id' => $province->id,
                                'name' => $value2->title,
                                'url' => $value2->url
                            ]);
                            // echo 'city '.$value2->title.'<br>';
                            // echo 'url '.$value2->url.'<br>';
                        }
                    }

                    if(isset($value1->city)){
                        foreach ($value1->city as $value2) {
                            $city = City::create([      
                                'island_id' => $island->id,
                                'name' => $value2->title,
                                'url' => $value2->url
                            ]);
                        }
                    }
                }               
        }        
    }
    
    public function tour($url1, $city_id){
        $getPagination = file_get_contents($url1);
        $getContent = HtmlDomParser::str_get_html($getPagination);        
        $pageLast = 0;

        foreach($getContent->find('div.jeg_navigation > a.page_number') as $value){            
            $pageLast = $value->innertext;
        }                        
        
        echo $pageLast;
                
        $tour = collect();        
        $url = "";

        $i = 0;

        if($pageLast > 0){
            $i = 1;
        }

        for ($i; $i <= $pageLast; $i++) {
            if($i == 0 || $i == 1){                
                $getTour = file_get_contents($url1);
            }

            if($i > 1){
                $getTour = file_get_contents($url);
            }
            $getContent = HtmlDomParser::str_get_html($getTour);            
            foreach ($getContent->find('div.jnews_category_content_wrapper h3.jeg_post_title') as $value) {                
                if(preg_match("/[0-9]\sTempat\sWisata/", $value)){
                    if(!preg_match("/kuliner/i", $value)){
                        // echo strip_tags($value->children(0)->href).'<br>';
                        $this->getTour($value->children(0)->href, $city_id);
                    }
                }                
            }
            if($i > 0){
                $url = $url1.'page/'.$i;
            }            
        }        
    }

    public function tourPagination($url, $page){        
        return file_get_contents($url.$page);                        
    }    
    
    public function getTour($url, $city_id){
        $content = file_get_contents($url);
        $content = HtmlDomParser::str_get_html($content);

        $tour = collect();                
        foreach ($content->find('div.content-inner > h3') as $key => $value) {
            $image = "";
            echo trim(preg_replace('/[0-9][0-9]\.\s|[0-9]\.\s/', "", strip_tags($value->innertext))).'<br>';
            if(isset($value->parent()->find('img', $key)->src)){
                $image = $value->parent()->find('img', $key)->src;
                echo $image.'<br>';
            }            
            Tour::create([
                'city_id' => $city_id,
                'name' => trim(preg_replace('/[0-9][0-9]\.\s|[0-9]\.\s/', "", strip_tags($value->innertext))),                
                'image' => $image
            ]);            
        }
    }

    public function storeTour(){
        ini_set('max_execution_time', 4000);
        $city = DB::table('cities')
        ->select('name', 'id', 'url')
        ->distinct()
        ->groupBy('name')
        ->get();
        

        foreach ($city as $key => $value) {
            if($value->id >= 943 && $value->id < 946){
                $this->tour($value->url, $value->id);   
                sleep(3);            
            }            
            // echo $value->id.'<br>';
            // echo $value->name.'<br>';
            // echo $value->url.'<br>';
        }
    }
}
