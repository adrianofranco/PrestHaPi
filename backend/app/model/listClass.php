<?php 

class ListClass {

    public function getList(){

        return file_get_contents(__DIR__.'/playlist.json');

    }

}