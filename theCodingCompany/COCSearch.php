<?php
/**
 * Intellectual Property of Svensk Coding Company AB - Sweden All rights reserved.
 * 
 * @copyright (c) 2016, Svensk Coding Company AB
 * @author V.A. (Victor) Angelier <victor@thecodingcompany.se>
 * @version 1.0
 * @license http://www.apache.org/licenses/GPL-compatibility.html GPL
 * 
 */
namespace theCodingCompany;

class COCSearch extends \theCodingCompany\HttpRequest
{
    /**
     * This is our base
     * @var type 
     */
    private $api_base = "https://zoeken.kvk.nl/JsonSearch.ashx";
    
    /**
     * Holds our result
     * @var type 
     */
    private $result_data = null;
    
    /**
     * Current page
     * @var type 
     */
    private $current_page = 0;
    
    /**
     * Total pages
     * @var type 
     */
    private $total_pages = 0;
    
    /**
     * Mandatory parameters
     * @var type 
     */
    private $params = array(
        "q" => "",
        "start" => 0,
        "prefproduct" => "",
        "prefpayment" => "",
        "senttimestamp" => 0
    );
    
    /**
     * Construct
     * @param type $base_path
     * @param type $base_url
     */
    public function __construct($base_path = "/", $base_url = "") {
        parent::__construct($base_path, $base_url);
        
        //Set our BASE
        $this->base_url = $this->api_base;
    }
    
    /**
     * Find a company
     * @param type $query
     */
    public function findCompany($query = ""){
        //Call the API
        $this->result_data = $this->Get("?".http_build_query($this->query($query)));
        if(!empty($this->result_data["entries"])){ 
            
            echo "Found {$this->result_data["pageinfo"]["resultscount"]} entries.\r\n";
            $this->handle_pages();
        }
    }
    
    /**
     * Read the current resultset
     */
    private function read_data(){
        if(!empty($this->result_data["entries"])){
            foreach($this->result_data["entries"] as $company){
                
                $title = "[".$company["dossiernummer"]."] ".(isset($company["type"]) ? $company["type"] : $company["subtype"]);
                echo str_pad("{$title} ", 100, "-")."\r\n";
                echo $company["handelsnaam"]."\r\n";
                if(isset($company["type"])){
                    echo $company["straat"]." ".$company["huisnummer"]." ".$company["huisnummertoevoeging"]."\r\n";
                    echo $company["postcode"]." ".$company["plaats"]."\r\n";
                }
                echo str_pad("", 100, "-")."\r\n";
            }
        }
        return false;
    }
    
    /**
     * Get next page
     * @return boolean
     */
    private function getNextPage(){
        $this->params["start"] = ($this->current_page*10);
        $this->result_data = $this->Get("?".http_build_query($this->params));
        if(!empty($this->result_data["entries"])){
            return true;
        }
        return false;
    }
    
    /**
     * Handle pages and start reading the result sets
     */
    private function handle_pages(){
        if(!empty($this->result_data["pageinfo"])){
            $this->total_pages = ceil($this->result_data["pageinfo"]["resultscount"]/$this->result_data["pageinfo"]["resultsperpage"]);
        }
        for($this->current_page = 0; $this->current_page <= $this->total_pages; $this->current_page++){
            $this->read_data();
            $this->getNextPage();
        }
    }
    
    /**
     * Set search query
     * @param type $query
     * @return type
     */
    private function query($query){
        $this->params["q"] = $query;
        $this->params["start"] = $this->current_page;
        return $this->params;
    }
}